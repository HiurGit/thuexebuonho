<?php

namespace App\Services;

use App\Models\Contract;
use App\Support\NumberToWords;
use Illuminate\Support\Carbon;

class ContractDocumentService
{
    /**
     * Map a contract to the placeholder values used by the HTML contract document.
     */
    public function data(Contract $contract): array
    {
        $car = $contract->car;
        $date = fn ($v) => $v ? Carbon::parse($v)->format('d/m/Y') : '';
        $hour = fn ($v) => $v ? Carbon::parse($v)->format('H') : '';
        $minute = fn ($v) => $v ? Carbon::parse($v)->format('i') : '';
        $money = fn ($v) => ($v === null || $v === '') ? '' : number_format((float) $v, 0, ',', '.');

        $contractDate = $contract->contract_date ?: now();
        $depositAmount = (int) ($contract->deposit_amount ?? 0);

        return [
            'contract_day' => $contractDate->format('d'),
            'contract_month' => $contractDate->format('m'),
            'contract_year' => $contractDate->format('Y'),
            'contract_place' => $contract->branch ?: '07 Chu Văn An, Buôn Hồ',

            'customer_name' => (string) $contract->customer_name,
            'cccd' => (string) $contract->cccd,
            'cccd_issue_date' => $date($contract->cccd_issue_date),
            'cccd_issue_place' => (string) $contract->cccd_issue_place,
            'dob' => $date($contract->dob),
            'customer_address' => (string) $contract->customer_address,
            'customer_phone' => (string) $contract->customer_phone,
            'license_no' => (string) $contract->driver_license_no,
            'license_class' => (string) $contract->license_class,
            'license_expiry' => $date($contract->license_expiry_date),

            'car_brand' => (string) ($contract->car_brand ?: ($car->brand ?? '')),
            'car_model' => (string) ($contract->car_model ?: ($car->model ?? '')),
            'car_plate' => (string) $contract->car_plate,
            'car_color' => (string) ($contract->car_color ?: ($car->color ?? '')),
            'car_year' => (string) ($contract->car_year ?: ''),
            'car_chassis' => (string) ($contract->car_chassis ?: ($car->chassis_no ?? '')),
            'car_owner' => (string) ($contract->car_owner ?: ($car->owner ?? '')),
            'car_engine' => (string) ($contract->car_engine ?: ($car->engine_no ?? '')),

            'pickup_hour' => $hour($contract->pickup_datetime),
            'pickup_minute' => $minute($contract->pickup_datetime),
            'pickup_date' => $date($contract->pickup_datetime),
            'return_hour' => $hour($contract->return_datetime),
            'return_minute' => $minute($contract->return_datetime),
            'return_date' => $date($contract->return_datetime),
            'pickup_location' => (string) ($contract->pickup_location ?: ($car->address ?? '')),
            'route' => (string) $contract->return_location,
            'route_line' => '',

            'deposit_moto_brand' => (string) $contract->deposit_moto_brand,
            'deposit_moto_plate' => (string) $contract->deposit_moto_plate,
            'deposit_moto_registration' => (string) $contract->deposit_moto_registration,
            'deposit_amount' => $money($contract->deposit_amount),
            'deposit_words' => $depositAmount > 0 ? NumberToWords::convert($depositAmount) : '',
            'deposit_other' => (string) $contract->deposit_other,

            'daily_rate' => $money($contract->daily_rate),
            'rental_days' => $contract->rental_days ? (string) $contract->rental_days : '',
            'rental_unit' => '',
            'total_fee' => $money($contract->total_rental_fee),

            'appendix_name' => (string) $contract->customer_name,
            'appendix_cccd' => (string) $contract->cccd,
            'appendix_cccd_date' => $date($contract->cccd_issue_date),
            'appendix_license_no' => (string) $contract->driver_license_no,
            'appendix_license_date' => $date($contract->license_issue_date),
            'appendix_car_plate' => (string) $contract->car_plate,

            'ap_pickup_hour' => $hour($contract->pickup_datetime),
            'ap_pickup_minute' => $minute($contract->pickup_datetime),
            'ap_pickup_date' => $date($contract->pickup_datetime),
            'ap_return_hour' => $hour($contract->return_datetime),
            'ap_return_minute' => $minute($contract->return_datetime),
            'ap_return_date' => $date($contract->return_datetime),
        ];
    }
}
