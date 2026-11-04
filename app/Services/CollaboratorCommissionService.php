<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Collaborator;
use App\Models\CollaboratorCommission;
use App\Models\CollaboratorCustomer;
use App\Models\Contract;
use App\Support\Phone;
use Illuminate\Database\UniqueConstraintViolationException;

class CollaboratorCommissionService
{
    /**
     * Find the customer source that was locked for this phone / CCCD.
     */
    public function findCustomerSource(?string $phone, ?string $cccd = null): ?CollaboratorCustomer
    {
        $phone = Phone::normalize($phone);
        $cccd = trim((string) $cccd) ?: null;

        if (! $phone && ! $cccd) {
            return null;
        }

        $query = CollaboratorCustomer::query();

        if ($phone) {
            $query->where('customer_phone', $phone);
        } else {
            $query->where('cccd', $cccd);
        }

        $source = $query->first();

        if (! $source && $phone && $cccd) {
            $source = CollaboratorCustomer::where('cccd', $cccd)->first();
        }

        if ($source) {
            $this->fillMissingCustomerData($source, null, $phone, $cccd);
        }

        return $source;
    }

    /**
     * Resolve the collaborator who owns a customer by locked source, booking or contract.
     */
    public function resolveCollaborator(?string $phone, ?string $cccd = null, ?Contract $contract = null): ?Collaborator
    {
        $source = $this->findCustomerSource($phone, $cccd);

        if ($source && $source->collaborator) {
            return $source->collaborator;
        }

        if ($contract && $contract->collaborator) {
            return $contract->collaborator;
        }

        $normalized = Phone::normalize($phone);

        if ($normalized) {
            $booking = Booking::where('customer_phone', $normalized)
                ->whereNotNull('collaborator_id')
                ->latest('id')
                ->first();

            if ($booking && $booking->collaborator) {
                return $booking->collaborator;
            }
        }

        if ($contract && $contract->collaborator_id) {
            return Collaborator::find($contract->collaborator_id);
        }

        return null;
    }

    /**
     * Lock a customer to a collaborator. First confirmed source wins forever.
     */
    public function attachCustomer(
        Collaborator $collaborator,
        ?string $customerName,
        ?string $phone,
        ?string $cccd = null,
        string $source = 'contract',
        ?int $bookingId = null,
        ?int $contractId = null
    ): ?CollaboratorCustomer {
        $phone = Phone::normalize($phone);
        $cccd = trim((string) $cccd) ?: null;

        if (! $phone && ! $cccd) {
            return null;
        }

        $existing = $this->findCustomerSource($phone, $cccd);

        if ($existing) {
            $this->fillMissingCustomerData($existing, $customerName, $phone, $cccd);

            if ($contractId && ! $existing->contract_id) {
                $existing->contract_id = $contractId;
                $existing->saveQuietly();
            }

            return $existing;
        }

        try {
            return CollaboratorCustomer::create([
                'collaborator_id' => $collaborator->id,
                'customer_name' => $customerName,
                'customer_phone' => $phone,
                'cccd' => $cccd,
                'source' => $source,
                'booking_id' => $bookingId,
                'contract_id' => $contractId,
            ]);
        } catch (UniqueConstraintViolationException $e) {
            // Một nguồn khác vừa được tạo cho cùng số điện thoại/CCCD: ưu tiên bản ghi đầu tiên.
            return $this->findCustomerSource($phone, $cccd);
        }
    }

    /**
     * Keep contract attribution and commissions in sync with the current contract state.
     */
    public function syncForContract(Contract $contract): void
    {
        if ($contract->status === 'cancelled') {
            CollaboratorCommission::where('contract_id', $contract->id)
                ->where('status', 'pending')
                ->delete();

            return;
        }

        $source = $this->findCustomerSource($contract->customer_phone, $contract->cccd);
        $collaborator = $this->resolveCollaborator($contract->customer_phone, $contract->cccd, $contract);

        if (! $collaborator) {
            CollaboratorCommission::where('contract_id', $contract->id)
                ->where('status', 'pending')
                ->delete();

            return;
        }

        // Khách đã thuộc về CTV nào thì giữ nguyên CTV đó cho mọi hợp đồng sau.
        if ($source && (int) $contract->collaborator_id !== (int) $source->collaborator_id) {
            $contract->forceFill([
                'collaborator_id' => $source->collaborator_id,
                'referral_source' => $contract->referral_source ?: 'customer_source',
            ])->saveQuietly();

            $collaborator = $source->collaborator;
        } elseif (! $contract->collaborator_id) {
            $contract->forceFill([
                'collaborator_id' => $collaborator->id,
                'referral_source' => $contract->referral_source ?: ($source ? 'customer_source' : 'contract'),
            ])->saveQuietly();
        }

        if ($contract->status !== 'returned') {
            CollaboratorCommission::where('contract_id', $contract->id)
                ->where('status', 'pending')
                ->delete();

            $this->attachCustomer(
                $collaborator,
                $contract->customer_name,
                $contract->customer_phone,
                $contract->cccd,
                $source ? 'customer_source' : 'contract',
                null,
                $contract->id
            );

            return;
        }

        $this->attachCustomer(
            $collaborator,
            $contract->customer_name,
            $contract->customer_phone,
            $contract->cccd,
            $source ? 'customer_source' : 'contract',
            null,
            $contract->id
        );

        $commission = CollaboratorCommission::firstOrNew(['contract_id' => $contract->id]);

        if ($commission->exists && $commission->status === 'paid') {
            return;
        }

        $rate = $collaborator->commission_rate_value;
        $total = (int) round((float) $contract->total_rental_fee);
        $amount = (int) round($total * $rate / 100);

        $commission->fill([
            'collaborator_id' => $collaborator->id,
            'contract_code' => $contract->contract_code,
            'customer_name' => $contract->customer_name,
            'customer_phone' => $contract->customer_phone,
            'contract_total' => $total,
            'commission_rate' => $rate,
            'commission_amount' => $amount,
            'status' => 'pending',
            'recognized_at' => $commission->recognized_at ?: now(),
        ]);

        $commission->save();
    }

    private function fillMissingCustomerData(
        CollaboratorCustomer $source,
        ?string $customerName,
        ?string $phone,
        ?string $cccd
    ): void {
        $changed = false;

        if (! $source->customer_name && $customerName) {
            $source->customer_name = $customerName;
            $changed = true;
        }

        if (! $source->customer_phone && $phone) {
            $source->customer_phone = $phone;
            $changed = true;
        }

        if (! $source->cccd && $cccd) {
            $source->cccd = $cccd;
            $changed = true;
        }

        if ($changed) {
            try {
                $source->saveQuietly();
            } catch (UniqueConstraintViolationException $e) {
                // Bản ghi khác đã giữ số điện thoại/CCCD này, bỏ qua phần bổ sung.
            }
        }
    }
}
