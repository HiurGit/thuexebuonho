<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Car;
use App\Services\TelegramNotificationService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class BookingController extends Controller
{
    public function submit(Request $request, TelegramNotificationService $telegramNotificationService)
    {
        try {
            $validated = $request->validate([
                'car_id' => 'nullable|integer|exists:cars,id',
                'phone' => 'required|regex:/^0[0-9]{9}$/',
                'rental_type' => 'required|in:one-day,multi-day,multi-range,hourly',
                'start_date' => 'nullable|string',
                'end_date' => 'nullable|string',
                'session_type' => 'nullable|string|in:sang,chieu,toi,Sang (6h-12h),Chieu (12h-18h),Toi (18h-23h)',
                'pickup_type' => 'nullable|string|in:shop,delivery',
                'trip_plan' => 'nullable|string|in:in-province,out-province',
                'total_price' => 'nullable|integer|min:0',
                'car_name' => 'nullable|string|max:255',
                'form_source' => 'nullable|string|in:quick-booking,car-detail',
            ], [
                'phone.required' => 'Vui long nhap so dien thoai',
                'phone.regex' => 'So dien thoai khong hop le',
                'rental_type.required' => 'Vui long chon loai thue',
            ]);

            $rentalType = $validated['rental_type'] === 'multi-range'
                ? 'multi-day'
                : $validated['rental_type'];

            [$startDate, $endDate, $startTime, $endTime, $days, $sessionType] = $this->extractBookingDateData(
                $rentalType,
                $validated['start_date'] ?? '',
                $validated['end_date'] ?? '',
                $validated['session_type'] ?? ''
            );

            $car = !empty($validated['car_id']) ? Car::find($validated['car_id']) : null;
            $carName = $validated['car_name'] ?? null;

            $booking = Booking::create([
                'car_id' => $validated['car_id'] ?? null,
                'customer_name' => null,
                'customer_phone' => $validated['phone'],
                'rental_type' => $rentalType,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'start_time' => $startTime,
                'end_time' => $endTime,
                'session_type' => $sessionType,
                'pickup_type' => $validated['pickup_type'] ?? 'shop',
                'trip_plan' => $validated['trip_plan'] ?? 'in-province',
                'days' => $days,
                'total_price' => $this->resolveTotalPrice(
                    $car,
                    $rentalType,
                    $days,
                    $validated['total_price'] ?? null,
                    $validated['trip_plan'] ?? 'in-province'
                ),
                'status' => 'pending',
                'notes' => $carName ? 'Xe khach chon: ' . $carName : null,
            ]);

            $telegramNotificationService->sendNewBookingNotification(
                $booking,
                $validated['form_source'] ?? ($validated['car_id'] ?? null ? 'car-detail' : 'quick-booking')
            );

            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Dat xe thanh cong! Chung toi se lien he ban trong 5-10 phut.',
                    'booking_id' => $booking->id,
                ]);
            }

            return back()->with('success', 'Dat xe thanh cong!');
        } catch (ValidationException $e) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => collect($e->errors())->flatten()->first() ?: 'Du lieu chua hop le.',
                    'errors' => $e->errors(),
                ], 422);
            }

            throw $e;
        } catch (\Throwable $e) {
            report($e);

            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Khong the luu don dat xe luc nay, vui long thu lai.',
                ], 500);
            }

            return back()->withErrors([
                'booking' => 'Khong the luu don dat xe luc nay, vui long thu lai.',
            ]);
        }
    }

    private function extractBookingDateData(
        string $rentalType,
        string $startDateText,
        string $endDateText,
        ?string $sessionType
    ): array {
        $startDate = null;
        $endDate = null;
        $startTime = '06:00';
        $endTime = '22:00';
        $days = 1;
        $normalizedSessionType = null;

        if ($rentalType === 'hourly') {
            $startDate = $this->extractDate($startDateText);
            $endDate = $startDate ? $startDate->copy() : null;

            $normalizedSessionType = match (trim((string) $sessionType)) {
                'sang', 'Sang (6h-12h)' => 'sang',
                'chieu', 'Chieu (12h-18h)' => 'chieu',
                'toi', 'Toi (18h-23h)' => 'toi',
                default => null,
            };

            [$startTime, $endTime] = match ($normalizedSessionType) {
                'chieu' => ['12:00', '18:00'],
                'toi' => ['18:00', '23:00'],
                default => ['06:00', '12:00'],
            };
        } elseif ($rentalType === 'multi-day') {
            $startDate = $this->extractDate($startDateText);
            $endDate = $this->extractDate($endDateText);

            if (!$startDate || !$endDate) {
                throw ValidationException::withMessages([
                    'date' => 'Vui long chon khoang ngay thue hop le.',
                ]);
            }

            if ($endDate->lt($startDate)) {
                throw ValidationException::withMessages([
                    'date' => 'Ngay tra xe phai sau ngay nhan xe.',
                ]);
            }

            $days = max(1, (int) $startDate->diffInDays($endDate) + 1);
        } else {
            $startDate = $this->extractDate($startDateText);
            $endDate = $startDate ? $startDate->copy() : null;
        }

        if (!$startDate) {
            throw ValidationException::withMessages([
                'date' => 'Vui long chon ngay thue hop le.',
            ]);
        }

        return [$startDate, $endDate, $startTime, $endTime, $days, $normalizedSessionType];
    }

    private function extractDate(?string $value): ?Carbon
    {
        if (!$value || !preg_match('/(\d{2}\/\d{2}\/\d{4})/', $value, $matches)) {
            return null;
        }

        return Carbon::createFromFormat('d/m/Y', $matches[1])->startOfDay();
    }

    private function resolveTotalPrice(
        ?Car $car,
        string $rentalType,
        int $days,
        ?int $submittedTotalPrice = null,
        ?string $tripPlan = null
    ): int
    {
        if ($car) {
            $basePrice = match ($rentalType) {
                'hourly' => (int) $car->price_per_session,
                'multi-day' => (int) ($days >= 3 ? $car->price_multi_day : $car->price_per_day) * $days,
                default => (int) $car->price_per_day,
            };

            $outsideProvinceFee = $tripPlan === 'out-province'
                ? (int) $car->price_out_province * ($rentalType === 'multi-day' ? max(1, $days) : 1)
                : 0;

            return $basePrice + $outsideProvinceFee;
        }

        if ($submittedTotalPrice !== null) {
            return $submittedTotalPrice;
        }

        return 0;
    }
}
