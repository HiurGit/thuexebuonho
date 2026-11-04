<?php

namespace App\Support;

class Phone
{
    /**
     * Normalize a Vietnamese phone number to a consistent local format.
     */
    public static function normalize(?string $value): ?string
    {
        $digits = preg_replace('/\D+/', '', (string) $value);

        if ($digits === '') {
            return null;
        }

        if (str_starts_with($digits, '0084')) {
            $digits = '0'.substr($digits, 4);
        } elseif (str_starts_with($digits, '84') && strlen($digits) >= 11) {
            $digits = '0'.substr($digits, 2);
        } elseif (str_starts_with($digits, '0') === false && strlen($digits) === 9) {
            $digits = '0'.$digits;
        }

        return $digits;
    }
}
