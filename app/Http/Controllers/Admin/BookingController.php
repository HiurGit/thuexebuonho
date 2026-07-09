<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Car;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function calendar(Request $request)
    {
        $monthInput = $request->input('month');
        $selectedCarId = $request->integer('car_id') ?: null;
        $selectedStatus = $request->input('status');
        $monthlySort = $request->input('monthly_sort', 'time');
        $availabilityDateInput = $request->input('availability_date');
        $availabilityEndDateInput = $request->input('availability_end_date');

        if (!in_array($monthlySort, ['time', 'car'], true)) {
            $monthlySort = 'time';
        }

        try {
            $month = $monthInput
                ? Carbon::createFromFormat('Y-m', $monthInput)->startOfMonth()
                : now()->startOfMonth();
        } catch (\Throwable $e) {
            $month = now()->startOfMonth();
        }

        $monthStart = $month->copy()->startOfMonth();
        $monthEnd = $month->copy()->endOfMonth();
        $calendarStart = $month->copy()->startOfMonth()->startOfWeek(Carbon::MONDAY);
        $calendarEnd = $month->copy()->endOfMonth()->endOfWeek(Carbon::SUNDAY);

        $cars = Car::orderBy('name')->get(['id', 'name', 'status']);
        $selectedCar = $selectedCarId ? $cars->firstWhere('id', $selectedCarId) : null;

        $bookingsQuery = Booking::with('car')
            ->whereNotNull('start_date')
            ->where(function ($query) use ($monthStart, $monthEnd) {
                $query->whereDate('start_date', '<=', $monthEnd)
                    ->where(function ($subQuery) use ($monthStart) {
                        $subQuery->whereNull('end_date')
                            ->orWhereDate('end_date', '>=', $monthStart);
                    });
            });

        if ($selectedCarId) {
            $bookingsQuery->where('car_id', $selectedCarId);
        }

        if ($selectedStatus) {
            $bookingsQuery->where('status', $selectedStatus);
        }

        $bookings = $bookingsQuery
            ->orderBy('start_date')
            ->orderBy('start_time')
            ->get();

        $statusLabels = [
            'pending' => 'Chờ xử lý',
            'confirmed' => 'Đã xác nhận',
            'delivered' => 'Đã giao',
            'completed' => 'Hoàn thành',
            'cancelled' => 'Đã hủy',
        ];

        $statusClasses = [
            'pending' => 'warning',
            'confirmed' => 'primary',
            'delivered' => 'info',
            'completed' => 'success',
            'cancelled' => 'secondary',
        ];

        $calendarEvents = $bookings->map(function (Booking $booking) use ($statusLabels, $statusClasses) {
            $isHourly = $booking->rental_type === 'hourly';
            $startDate = $booking->start_date ? Carbon::parse($booking->start_date) : null;
            $endDate = $booking->end_date ? Carbon::parse($booking->end_date) : $startDate;

            $event = [
                'id' => (string) $booking->id,
                'title' => trim(($booking->car?->name ? $booking->car->name . ' - ' : '') . ($booking->customer_name ?: 'Khách')),
                'url' => route('admin.bookings.edit', $booking),
                'backgroundColor' => match ($booking->status) {
                    'pending' => '#f39c12',
                    'confirmed' => '#007bff',
                    'delivered' => '#17a2b8',
                    'completed' => '#28a745',
                    default => '#6c757d',
                },
                'borderColor' => match ($booking->status) {
                    'pending' => '#d68910',
                    'confirmed' => '#0069d9',
                    'delivered' => '#138496',
                    'completed' => '#1e7e34',
                    default => '#5a6268',
                },
                'extendedProps' => [
                    'statusLabel' => $statusLabels[$booking->status] ?? $booking->status,
                    'statusClass' => $statusClasses[$booking->status] ?? 'secondary',
                    'carName' => $booking->car?->name ?? 'Chưa chọn xe',
                    'customerPhone' => $booking->customer_phone,
                    'totalPrice' => number_format((int) $booking->total_price) . 'đ',
                ],
            ];

            if ($isHourly && $startDate) {
                $event['start'] = $startDate->format('Y-m-d') . 'T' . ($booking->start_time ?: '06:00');
                $event['end'] = ($endDate ?: $startDate)->format('Y-m-d') . 'T' . ($booking->end_time ?: '12:00');
                $event['allDay'] = false;
            } elseif ($startDate) {
                $event['start'] = $startDate->format('Y-m-d');
                $event['end'] = ($endDate ?: $startDate)->copy()->addDay()->format('Y-m-d');
                $event['allDay'] = true;
            }

            return $event;
        })->filter(fn ($event) => !empty($event['start']))->values();

        $activeOverlapStatuses = ['confirmed', 'delivered'];
        $bookingsForOverlap = Booking::with('car')
            ->whereNotNull('car_id')
            ->whereNotNull('start_date')
            ->whereIn('status', $activeOverlapStatuses)
            ->orderBy('car_id')
            ->orderBy('start_date')
            ->orderBy('start_time')
            ->get();

        $overlapIds = collect();
        $overlapMap = [];

        $groupedByCar = $bookingsForOverlap->groupBy('car_id');
        foreach ($groupedByCar as $carId => $carBookings) {
            $items = $carBookings->values();
            for ($i = 0; $i < $items->count(); $i++) {
                for ($j = $i + 1; $j < $items->count(); $j++) {
                    $first = $items[$i];
                    $second = $items[$j];

                    $firstStart = Carbon::parse(($first->start_date?->format('Y-m-d') ?? '') . ' ' . ($first->start_time ?: '06:00'));
                    $firstEnd = Carbon::parse((($first->end_date ?? $first->start_date)?->format('Y-m-d') ?? '') . ' ' . ($first->end_time ?: '22:00'));
                    $secondStart = Carbon::parse(($second->start_date?->format('Y-m-d') ?? '') . ' ' . ($second->start_time ?: '06:00'));
                    $secondEnd = Carbon::parse((($second->end_date ?? $second->start_date)?->format('Y-m-d') ?? '') . ' ' . ($second->end_time ?: '22:00'));

                    if ($firstStart < $secondEnd && $firstEnd > $secondStart) {
                        $overlapIds->push($first->id, $second->id);
                        $overlapMap[$first->id][] = $second->id;
                        $overlapMap[$second->id][] = $first->id;
                    }
                }
            }
        }

        $overlapIds = $overlapIds->unique()->values();
        $overlapWarnings = $bookingsForOverlap
            ->whereIn('id', $overlapIds)
            ->values();

        $calendarEvents = $calendarEvents->map(function ($event) use ($overlapIds, $overlapMap) {
            $eventId = (int) $event['id'];
            $hasOverlap = $overlapIds->contains($eventId);
            $event['extendedProps']['hasOverlap'] = $hasOverlap;
            $event['extendedProps']['overlapCount'] = count($overlapMap[$eventId] ?? []);
            return $event;
        });

        $weeks = [];
        $cursor = $calendarStart->copy();
        while ($cursor->lte($calendarEnd)) {
            $week = [];
            for ($i = 0; $i < 7; $i++) {
                $day = $cursor->copy();
                $dayBookings = $bookings->filter(function (Booking $booking) use ($day) {
                    $start = $booking->start_date ? Carbon::parse($booking->start_date)->startOfDay() : null;
                    $end = $booking->end_date
                        ? Carbon::parse($booking->end_date)->endOfDay()
                        : ($start ? $start->copy()->endOfDay() : null);

                    if (!$start || !$end) {
                        return false;
                    }

                    return $day->between($start, $end, true);
                })->values();

                $week[] = [
                    'date' => $day,
                    'isCurrentMonth' => $day->month === $month->month,
                    'isToday' => $day->isToday(),
                    'bookings' => $dayBookings,
                ];

                $cursor->addDay();
            }
            $weeks[] = $week;
        }

        $stats = [
            'total_bookings' => $bookings->count(),
            'total_cars' => $selectedCarId ? 1 : $cars->count(),
            'occupied_days' => collect($weeks)->flatten(1)->filter(fn ($day) => $day['bookings']->isNotEmpty())->count(),
            'pending_bookings' => $bookings->where('status', 'pending')->count(),
        ];

        $today = now()->startOfDay();
        $tomorrow = now()->copy()->addDay()->endOfDay();
        $activeStatuses = ['confirmed', 'delivered'];

        $allRelevantBookings = Booking::with('car')
            ->whereNotNull('car_id')
            ->whereNotNull('start_date')
            ->whereIn('status', $activeStatuses)
            ->get();

        $busyCarIds = $allRelevantBookings
            ->filter(function (Booking $booking) use ($today) {
                $start = $booking->start_date ? Carbon::parse($booking->start_date)->startOfDay() : null;
                $end = $booking->end_date
                    ? Carbon::parse($booking->end_date)->endOfDay()
                    : ($start ? $start->copy()->endOfDay() : null);

                return $start && $end && $today->between($start, $end, true);
            })
            ->pluck('car_id')
            ->unique()
            ->values();

        $busyCars = $cars->whereIn('id', $busyCarIds)->values();

        $dueSoonBookings = $allRelevantBookings
            ->filter(function (Booking $booking) use ($today, $tomorrow) {
                if (!$booking->end_date) {
                    return false;
                }

                $end = Carbon::parse($booking->end_date)->endOfDay();
                return $end->between($today, $tomorrow, true);
            })
            ->sortBy('end_date')
            ->values();

        $upcomingStartWindow = now()->copy()->addDays(2)->endOfDay();
        $startingSoonBookings = $allRelevantBookings
            ->filter(function (Booking $booking) use ($today, $upcomingStartWindow) {
                if (!$booking->start_date) {
                    return false;
                }

                $start = Carbon::parse($booking->start_date)->startOfDay();
                return $start->gt($today) && $start->lte($upcomingStartWindow);
            })
            ->sortBy('start_date')
            ->values();

        $freeCars = $cars
            ->reject(fn (Car $car) => $busyCarIds->contains($car->id))
            ->values();

        $openCars = $freeCars
            ->map(function (Car $car) use ($allRelevantBookings, $today) {
                $nextBooking = $allRelevantBookings
                    ->where('car_id', $car->id)
                    ->filter(function (Booking $booking) use ($today) {
                        return $booking->start_date && Carbon::parse($booking->start_date)->startOfDay()->gt($today);
                    })
                    ->sortBy('start_date')
                    ->first();

                return [
                    'car' => $car,
                    'next_booking' => $nextBooking,
                ];
            })
            ->values();

        $availabilityDate = null;
        $availabilityEndDate = null;
        $availabilityCheck = null;
        $allCarsAvailability = null;
        $allCarsBusySlots = collect();
        $allCarsFreeSlots = collect();
        $carBusySlots = collect();
        $carFreeSlots = collect();

        try {
            $availabilityDate = $availabilityDateInput
                ? Carbon::parse($availabilityDateInput)
                : null;
        } catch (\Throwable $e) {
            $availabilityDate = null;
        }

        try {
            $availabilityEndDate = $availabilityEndDateInput
                ? Carbon::parse($availabilityEndDateInput)
                : null;
        } catch (\Throwable $e) {
            $availabilityEndDate = null;
        }

        if ($availabilityDate && !$selectedCarId) {
            $allCarsAvailability = $this->buildAllCarsAvailabilityForRange(
                $cars,
                $allRelevantBookings,
                $availabilityDate,
                $availabilityEndDate ?: $availabilityDate
            );
        }

        if (!$selectedCarId) {
            [$allCarsBusySlots, $allCarsFreeSlots] = $this->buildAllCarsMonthlyAvailabilitySlots(
                $cars,
                $monthStart,
                $monthEnd,
                $activeStatuses,
                $monthlySort
            );
        }

        if ($selectedCarId) {
            [$carBusySlots, $carFreeSlots] = $this->buildCarAvailabilitySlots(
                $selectedCarId,
                $monthStart,
                $monthEnd,
                $activeStatuses
            );

            if ($availabilityDate) {
                $availabilityCheck = $this->checkCarAvailabilityRange(
                    $selectedCarId,
                    $availabilityDateInput,
                    $availabilityEndDateInput ?: $availabilityDateInput,
                    $activeStatuses
                );
            }
        }

        return view('admin.bookings.calendar', [
            'cars' => $cars,
            'bookings' => $bookings,
            'weeks' => $weeks,
            'month' => $month,
            'selectedCar' => $selectedCar,
            'selectedCarId' => $selectedCarId,
            'selectedStatus' => $selectedStatus,
            'monthlySort' => $monthlySort,
            'statusLabels' => $statusLabels,
            'statusClasses' => $statusClasses,
            'stats' => $stats,
            'calendarEvents' => $calendarEvents,
            'busyCars' => $busyCars,
            'freeCars' => $freeCars,
            'dueSoonBookings' => $dueSoonBookings,
            'openCars' => $openCars,
            'startingSoonBookings' => $startingSoonBookings,
            'overlapWarnings' => $overlapWarnings,
            'availabilityDate' => $availabilityDate,
            'availabilityDateInput' => $availabilityDateInput,
            'availabilityEndDate' => $availabilityEndDate,
            'availabilityEndDateInput' => $availabilityEndDateInput,
            'availabilityCheck' => $availabilityCheck,
            'allCarsAvailability' => $allCarsAvailability,
            'allCarsBusySlots' => $allCarsBusySlots,
            'allCarsFreeSlots' => $allCarsFreeSlots,
            'carBusySlots' => $carBusySlots,
            'carFreeSlots' => $carFreeSlots,
        ]);
    }

    private function buildAllCarsAvailabilityForRange($cars, $bookings, Carbon $startDate, Carbon $endDate): array
    {
        $targetStart = $startDate->copy()->startOfDay();
        $targetEnd = $endDate->copy()->endOfDay();

        if ($targetEnd->lt($targetStart)) {
            [$targetStart, $targetEnd] = [$targetEnd, $targetStart];
        }

        $busy = collect();
        $free = collect();

        foreach ($cars as $car) {
            $conflicts = $bookings
                ->where('car_id', $car->id)
                ->filter(function (Booking $booking) use ($targetStart, $targetEnd) {
                    $start = $booking->start_date ? Carbon::parse($booking->start_date)->startOfDay() : null;
                    $end = $booking->end_date
                        ? Carbon::parse($booking->end_date)->endOfDay()
                        : ($start ? $start->copy()->endOfDay() : null);

                    return $start && $end && $start->lte($targetEnd) && $end->gte($targetStart);
                })
                ->values();

            $item = [
                'car' => $car,
                'conflicts' => $conflicts,
            ];

            if ($conflicts->isEmpty()) {
                $free->push($item);
            } else {
                $busy->push($item);
            }
        }

        return [
            'start_date' => $targetStart,
            'end_date' => $targetEnd,
            'busy' => $busy->sortBy(fn ($item) => $item['car']->name)->values(),
            'free' => $free->sortBy(fn ($item) => $item['car']->name)->values(),
        ];
    }

    private function buildAllCarsMonthlyAvailabilitySlots($cars, Carbon $monthStart, Carbon $monthEnd, array $activeStatuses, string $sortBy = 'time'): array
    {
        $busySlots = collect();
        $freeSlots = collect();

        foreach ($cars as $car) {
            [$carBusySlots, $carFreeSlots] = $this->buildCarAvailabilitySlots(
                $car->id,
                $monthStart,
                $monthEnd,
                $activeStatuses
            );

            foreach ($carBusySlots as $slot) {
                $slot['car'] = $car;
                $busySlots->push($slot);
            }

            foreach ($carFreeSlots as $slot) {
                $slot['car'] = $car;
                $freeSlots->push($slot);
            }
        }

        $sortSlots = function ($slots) use ($sortBy) {
            return $slots->sort(function ($a, $b) use ($sortBy) {
                if ($sortBy === 'car') {
                    $carCompare = strcasecmp($a['car']->name, $b['car']->name);

                    if ($carCompare !== 0) {
                        return $carCompare;
                    }

                    return $a['start']->timestamp <=> $b['start']->timestamp;
                }

                $startCompare = $a['start']->timestamp <=> $b['start']->timestamp;

                if ($startCompare !== 0) {
                    return $startCompare;
                }

                return strcasecmp($a['car']->name, $b['car']->name);
            })->values();
        };

        return [
            $sortSlots($busySlots),
            $sortSlots($freeSlots),
        ];
    }

    private function buildCarAvailabilitySlots(
        int $carId,
        Carbon $monthStart,
        Carbon $monthEnd,
        array $activeStatuses
    ): array {
        $today = now()->startOfDay();
        $windowStart = $monthStart->copy()->startOfDay();
        $windowEnd = $monthEnd->copy()->endOfDay();

        $bookings = Booking::with('car')
            ->where('car_id', $carId)
            ->whereIn('status', $activeStatuses)
            ->whereNotNull('start_date')
            ->where(function ($query) use ($windowStart, $windowEnd) {
                $query->whereDate('start_date', '<=', $windowEnd->toDateString())
                    ->where(function ($subQuery) use ($windowStart) {
                        $subQuery->whereNull('end_date')
                            ->orWhereDate('end_date', '>=', $windowStart->toDateString());
                    });
            })
            ->orderBy('start_date')
            ->orderBy('start_time')
            ->get();

        $busySlots = $bookings->map(function (Booking $booking) use ($windowStart, $windowEnd) {
            $start = $booking->start_date ? Carbon::parse($booking->start_date)->startOfDay() : null;
            $end = $booking->end_date
                ? Carbon::parse($booking->end_date)->endOfDay()
                : ($start ? $start->copy()->endOfDay() : null);

            if (!$start || !$end) {
                return null;
            }

            $clampedStart = $start->copy()->max($windowStart);
            $clampedEnd = $end->copy()->min($windowEnd);

            if ($clampedStart->gt($clampedEnd)) {
                return null;
            }

            return [
                'type' => 'busy',
                'start' => $clampedStart,
                'end' => $clampedEnd,
                'booking' => $booking,
            ];
        })->filter()->values();

        $freeSlots = collect();
        $freeWindowStart = $windowStart->copy()->max($today);
        $cursor = $freeWindowStart->copy();

        foreach ($busySlots as $slot) {
            if ($cursor->lt($slot['start'])) {
                $freeSlots->push([
                    'type' => 'free',
                    'start' => $cursor->copy(),
                    'end' => $slot['start']->copy()->subDay()->endOfDay(),
                ]);
            }

            if ($cursor->lte($slot['end'])) {
                $cursor = $slot['end']->copy()->addDay()->startOfDay();
            }
        }

        if ($cursor->lte($windowEnd)) {
            $freeSlots->push([
                'type' => 'free',
                'start' => $cursor->copy(),
                'end' => $windowEnd->copy(),
            ]);
        }

        return [$busySlots, $freeSlots];
    }

    private function checkCarAvailabilityRange(
        int $carId,
        string $startDateInput,
        string $endDateInput,
        array $activeStatuses
    ): array
    {
        $startTarget = Carbon::parse($startDateInput)->startOfDay();
        $endTarget = Carbon::parse($endDateInput)->endOfDay();

        if ($endTarget->lt($startTarget)) {
            [$startTarget, $endTarget] = [$endTarget->copy()->startOfDay(), $startTarget->copy()->endOfDay()];
        }

        $bookings = Booking::with('car')
            ->where('car_id', $carId)
            ->whereIn('status', $activeStatuses)
            ->whereNotNull('start_date')
            ->orderBy('start_date')
            ->orderBy('start_time')
            ->get();

        $conflicts = $bookings->filter(function (Booking $booking) use ($startTarget, $endTarget) {
            $start = $booking->start_date ? Carbon::parse($booking->start_date)->startOfDay() : null;
            $end = $booking->end_date
                ? Carbon::parse($booking->end_date)->endOfDay()
                : ($start ? $start->copy()->endOfDay() : null);

            return $start && $end && $start->lte($endTarget) && $end->gte($startTarget);
        })->values();

        return [
            'checked_at' => $startTarget,
            'checked_end_at' => $endTarget,
            'is_free' => $conflicts->isEmpty(),
            'conflicts' => $conflicts,
        ];
    }

    public function index()
    {
        $bookings = Booking::with('car')->latest()->get();
        return view('admin.bookings.index', compact('bookings'));
    }

    public function create()
    {
        $cars = Car::orderBy('name')->get();
        return view('admin.bookings.create', compact('cars'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_phone' => 'required|string|max:20',
            'customer_name' => 'nullable|string|max:255',
            'car_id' => 'nullable|exists:cars,id',
            'rental_type' => 'required|in:one-day,multi-day,hourly',
            'start_date' => 'nullable|date_format:d/m/Y',
            'end_date' => 'nullable|date_format:d/m/Y',
            'start_time' => 'nullable|string',
            'end_time' => 'nullable|string',
            'session_type' => 'nullable|string',
            'pickup_type' => 'nullable|in:shop,delivery',
            'trip_plan' => 'nullable|in:in-province,out-province',
            'days' => 'nullable|integer|min:1',
            'total_price' => 'nullable|numeric',
            'deposit' => 'nullable|numeric',
            'status' => 'required|in:pending,confirmed,delivered,completed,cancelled',
            'notes' => 'nullable|string',
        ]);

        $validated = $this->normalizeBookingPayload($validated);

        Booking::create($validated);

        return redirect()->route('admin.bookings.index')->with('success', 'Đã tạo đơn đặt xe mới.');
    }

    public function edit(Booking $booking)
    {
        $cars = Car::orderBy('name')->get();
        return view('admin.bookings.edit', compact('booking', 'cars'));
    }

    public function update(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'customer_phone' => 'required|string|max:20',
            'customer_name' => 'nullable|string|max:255',
            'car_id' => 'nullable|exists:cars,id',
            'rental_type' => 'required|in:one-day,multi-day,hourly',
            'start_date' => 'nullable|date_format:d/m/Y',
            'end_date' => 'nullable|date_format:d/m/Y',
            'start_time' => 'nullable|string',
            'end_time' => 'nullable|string',
            'session_type' => 'nullable|string',
            'pickup_type' => 'nullable|in:shop,delivery',
            'trip_plan' => 'nullable|in:in-province,out-province',
            'days' => 'nullable|integer|min:1',
            'total_price' => 'nullable|numeric',
            'deposit' => 'nullable|numeric',
            'status' => 'required|in:pending,confirmed,delivered,completed,cancelled',
            'notes' => 'nullable|string',
        ]);

        $validated = $this->normalizeBookingPayload($validated);

        $booking->update($validated);

        return redirect()->route('admin.bookings.index')->with('success', 'Đã cập nhật đơn đặt xe.');
    }

    public function destroy(Booking $booking)
    {
        $booking->delete();

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Đã xóa đơn #' . $booking->id]);
        }

        return redirect()->route('admin.bookings.index')->with('success', 'Đã xóa đơn đặt xe.');
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,delivered,completed,cancelled',
        ]);

        Booking::whereKey($booking->getKey())->update([
            'status' => $request->status,
            'updated_at' => now(),
        ]);

        $labels = [
            'pending' => 'Chờ xử lý',
            'confirmed' => 'Đã xác nhận',
            'delivered' => 'Đã giao',
            'completed' => 'Hoàn thành',
            'cancelled' => 'Đã hủy',
        ];

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Đã đổi trạng thái thành "' . ($labels[$request->status] ?? $request->status) . '"']);
        }

        return back()->with('success', 'Đã cập nhật trạng thái.');
    }

    private function normalizeBookingPayload(array $validated): array
    {
        if (!empty($validated['start_date'])) {
            $validated['start_date'] = Carbon::createFromFormat('d/m/Y', $validated['start_date'])->format('Y-m-d');
        }

        if (!empty($validated['end_date'])) {
            $validated['end_date'] = Carbon::createFromFormat('d/m/Y', $validated['end_date'])->format('Y-m-d');
        }

        $rentalType = $validated['rental_type'] ?? null;
        $validated['start_time'] = $this->normalizeTimeValue($validated['start_time'] ?? null, '06:00');
        $validated['end_time'] = $this->normalizeTimeValue(
            $validated['end_time'] ?? null,
            $rentalType === 'hourly' ? '12:00' : '22:00'
        );

        if (($rentalType === 'one-day' || $rentalType === 'hourly') && !empty($validated['start_date']) && empty($validated['end_date'])) {
            $validated['end_date'] = $validated['start_date'];
        }

        return $validated;
    }

    private function normalizeTimeValue(?string $value, string $default): string
    {
        $value = trim((string) $value);

        return $value !== '' ? $value : $default;
    }
}
