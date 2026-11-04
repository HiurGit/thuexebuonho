<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Car;
use App\Models\Collaborator;
use App\Models\Contract;
use App\Models\ContractImage;
use App\Services\CollaboratorCommissionService;
use App\Support\Phone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ContractController extends Controller
{
    public function index(Request $request)
    {
        $query = Contract::with('creator')->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('contract_code', 'like', "%{$search}%")
                    ->orWhere('customer_name', 'like', "%{$search}%")
                    ->orWhere('customer_phone', 'like', "%{$search}%")
                    ->orWhere('cccd', 'like', "%{$search}%")
                    ->orWhere('car_plate', 'like', "%{$search}%")
                    ->orWhere('car_name', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $contracts = $query->paginate(20)->withQueryString();

        return view('admin.contracts.index', compact('contracts'));
    }

    public function create()
    {
        $cars = Car::orderBy('name')->get();
        $collaborators = $this->collaboratorOptions();

        return view('admin.contracts.create', compact('cars', 'collaborators'));
    }

    public function store(Request $request, CollaboratorCommissionService $commissionService)
    {
        $validated = $this->validateData($request);
        $validated['contract_date'] = now();

        $contract = Contract::create($validated + [
            'contract_code' => $this->generateContractCode(),
            'created_by' => auth()->id(),
        ]);

        $this->storeImages($request, $contract);
        $commissionService->syncForContract($contract);

        return redirect()->route('admin.contracts.show', $contract)
            ->with('success', 'Đã tạo hợp đồng '.$contract->contract_code.'.');
    }

    public function show(Contract $contract)
    {
        $contract->load(['creator', 'car', 'images', 'collaborator', 'commission']);

        return view('admin.contracts.show', compact('contract'));
    }

    public function referralLookup(Request $request, CollaboratorCommissionService $commissionService)
    {
        $request->validate([
            'phone' => 'nullable|string|max:30',
            'cccd' => 'nullable|string|max:50',
        ]);

        $phone = Phone::normalize($request->input('phone'));
        $cccd = trim((string) $request->input('cccd')) ?: null;

        if (! $phone && ! $cccd) {
            return response()->json([
                'found' => false,
                'message' => 'Vui lòng nhập số điện thoại hoặc CCCD để kiểm tra.',
            ]);
        }

        $source = $commissionService->findCustomerSource($phone, $cccd);

        $booking = null;

        if ($phone) {
            $booking = Booking::with('collaborator')
                ->whereNotNull('collaborator_id')
                ->where(function ($query) use ($phone) {
                    $query->where('customer_phone', $phone)
                        ->orWhereRaw("REPLACE(REPLACE(REPLACE(REPLACE(customer_phone, ' ', ''), '.', ''), '-', ''), '+', '') = ?", [$phone]);
                })
                ->latest('id')
                ->first();
        }

        $contracts = Contract::with('collaborator')
            ->where(function ($query) use ($phone, $cccd) {
                if ($phone) {
                    $query->where('customer_phone', $phone)
                        ->orWhereRaw("REPLACE(REPLACE(REPLACE(REPLACE(customer_phone, ' ', ''), '.', ''), '-', ''), '+', '') = ?", [$phone]);
                }

                if ($cccd) {
                    $query->orWhere('cccd', $cccd);
                }
            })
            ->latest('id')
            ->limit(5)
            ->get();

        $collaborator = $source?->collaborator
            ?? $booking?->collaborator
            ?? $contracts->first()?->collaborator;

        return response()->json([
            'found' => (bool) $collaborator,
            'collaborator' => $collaborator ? [
                'id' => $collaborator->id,
                'name' => $collaborator->name,
                'code' => $collaborator->code,
                'phone' => $collaborator->phone,
                'commission_rate' => $collaborator->commission_rate_value,
            ] : null,
            'source_type' => $source ? 'Đã khóa nguồn khách hàng' : ($booking ? 'Từ đơn đặt xe' : ($contracts->isNotEmpty() ? 'Từ hợp đồng trước' : null)),
            'booking' => $booking ? [
                'id' => $booking->id,
                'status' => $booking->status,
                'created_at' => optional($booking->created_at)->format('d/m/Y H:i'),
            ] : null,
            'contracts' => $contracts->map(fn (Contract $contract) => [
                'code' => $contract->contract_code,
                'status' => $contract->status_label,
                'date' => optional($contract->contract_date)->format('d/m/Y'),
            ])->values(),
            'message' => $collaborator
                ? 'Khách đã thuộc về CTV '.$collaborator->name.'. Hệ thống sẽ giữ nguyên nguồn này.'
                : 'Chưa tìm thấy nguồn giới thiệu cho khách hàng này.',
        ]);
    }

    public function edit(Contract $contract)
    {
        $cars = Car::orderBy('name')->get();
        $collaborators = $this->collaboratorOptions();
        $contract->load(['images', 'collaborator', 'commission']);

        return view('admin.contracts.edit', compact('contract', 'cars', 'collaborators'));
    }

    public function update(Request $request, Contract $contract, CollaboratorCommissionService $commissionService)
    {
        $validated = $this->validateData($request);

        $contract->update($validated);
        $commissionService->syncForContract($contract);

        if ($request->delete_images) {
            $images = ContractImage::whereIn('id', $request->delete_images)
                ->where('contract_id', $contract->id)
                ->get();
            foreach ($images as $img) {
                Storage::disk('public')->delete(str_replace('storage/', '', $img->path));
                $img->delete();
            }
        }

        $this->storeImages($request, $contract);

        return redirect()->route('admin.contracts.show', $contract)
            ->with('success', 'Đã cập nhật hợp đồng '.$contract->contract_code.'.');
    }

    public function destroy(Contract $contract)
    {
        foreach ($contract->images as $img) {
            Storage::disk('public')->delete(str_replace('storage/', '', $img->path));
        }
        $contract->images()->delete();
        $contract->delete();

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Đã xóa hợp đồng '.$contract->contract_code,
            ]);
        }

        return redirect()->route('admin.contracts.index')->with('success', 'Đã xóa hợp đồng.');
    }

    public function destroyImage(ContractImage $image)
    {
        Storage::disk('public')->delete(str_replace('storage/', '', $image->path));
        $image->delete();

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Đã xóa ảnh.']);
        }

        return back()->with('success', 'Đã xóa ảnh.');
    }

    private function validateData(Request $request): array
    {
        foreach (['deposit_amount', 'daily_rate', 'total_rental_fee'] as $field) {
            if ($request->filled($field)) {
                $request->merge([$field => str_replace('.', '', $request->input($field))]);
            }
        }

        return $request->validate([
            'status' => 'required|in:pending,active,returned,cancelled',
            'collaborator_id' => 'nullable|integer|exists:collaborators,id',
            'branch' => 'nullable|string|max:255',
            'cccd' => 'nullable|string|max:50',
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'nullable|string|max:50',
            'dob' => 'nullable|date',
            'gender' => 'nullable|string|max:20',
            'cccd_issue_date' => 'nullable|date',
            'cccd_issue_place' => 'nullable|string|max:255',
            'customer_address' => 'nullable|string|max:255',
            'driver_license_no' => 'nullable|string|max:50',
            'license_issue_date' => 'nullable|date',
            'license_expiry_date' => 'nullable|date',
            'license_class' => 'nullable|string|max:50',
            'car_id' => 'nullable|integer|exists:cars,id',
            'car_name' => 'nullable|string|max:255',
            'car_plate' => 'nullable|string|max:50',
            'car_brand' => 'nullable|string|max:255',
            'car_model' => 'nullable|string|max:255',
            'car_color' => 'nullable|string|max:255',
            'car_chassis' => 'nullable|string|max:255',
            'car_engine' => 'nullable|string|max:255',
            'car_owner' => 'nullable|string|max:255',
            'car_year' => 'nullable|integer|min:1900|max:2100',
            'car_seats' => 'nullable|integer|min:0',
            'car_transmission' => 'nullable|string|max:50',
            'car_fuel' => 'nullable|string|max:50',
            'pickup_datetime' => 'nullable|date',
            'pickup_location' => 'nullable|string|max:255',
            'return_datetime' => 'nullable|date',
            'return_location' => 'nullable|string|max:255',
            'total_days' => 'nullable|integer|min:0',
            'total_hours' => 'nullable|integer|min:0',
            'km_limit' => 'nullable|integer|min:0',
            'deposit_type' => 'nullable|in:cash,motorcycle',
            'deposit_amount' => 'nullable|numeric|min:0',
            'deposit_note' => 'nullable|string|max:255',
            'deposit_moto_brand' => 'nullable|string|max:255',
            'deposit_moto_plate' => 'nullable|string|max:255',
            'deposit_moto_registration' => 'nullable|string|max:255',
            'deposit_other' => 'nullable|string|max:255',
            'daily_rate' => 'nullable|numeric|min:0',
            'rental_days' => 'nullable|integer|min:0',
            'total_rental_fee' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
            'images_cccd_front' => 'nullable|array',
            'images_cccd_front.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'images_cccd_back' => 'nullable|array',
            'images_cccd_back.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'images_license_front' => 'nullable|array',
            'images_license_front.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'images_license_back' => 'nullable|array',
            'images_license_back.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'images_car_before' => 'nullable|array',
            'images_car_before.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'images_car_video' => 'nullable|array',
            'images_car_video.*' => [
                'file',
                'max:204800',
                function ($attribute, $file, $fail) {
                    if (! $file) {
                        return;
                    }
                    $mime = (string) $file->getMimeType();
                    $isImage = str_starts_with($mime, 'image/');
                    $isVideo = str_starts_with($mime, 'video/');
                    if (! $isImage && ! $isVideo) {
                        $fail('Tệp phải là ảnh hoặc video.');

                        return;
                    }
                    if ($isImage && $file->getSize() > 5 * 1024 * 1024) {
                        $fail('Ảnh tối đa 5MB.');
                    }
                },
            ],
            'delete_images' => 'nullable|array',
            'delete_images.*' => 'integer|exists:contract_images,id',
        ]);
    }

    private function collaboratorOptions()
    {
        return Collaborator::whereIn('status', ['active', 'pending'])
            ->orderByRaw("FIELD(status, 'active', 'pending')")
            ->orderBy('name')
            ->get();
    }

    private function storeImages(Request $request, Contract $contract): void
    {
        $categories = [
            'images_cccd_front' => 'cccd_front',
            'images_cccd_back' => 'cccd_back',
            'images_license_front' => 'license_front',
            'images_license_back' => 'license_back',
            'images_car_before' => 'car_before',
            'images_car_video' => 'car_video',
        ];

        foreach ($categories as $field => $category) {
            if (! $request->hasFile($field)) {
                continue;
            }

            $lastOrder = $contract->images()->where('category', $category)->max('sort_order') ?? -1;

            foreach ($request->file($field) as $i => $file) {
                $folder = $category === 'car_video' ? 'contracts/videos' : 'contracts/'.$category;
                $path = $file->store($folder, 'public');
                $contract->images()->create([
                    'category' => $category,
                    'path' => 'storage/'.$path,
                    'sort_order' => $lastOrder + 1 + $i,
                ]);
            }
        }
    }

    private function generateContractCode(): string
    {
        $date = now()->format('Ymd');
        $countToday = Contract::where('contract_code', 'like', "HD-{$date}-%")->count();

        return 'HD-'.$date.'-'.str_pad((string) ($countToday + 1), 3, '0', STR_PAD_LEFT);
    }
}
