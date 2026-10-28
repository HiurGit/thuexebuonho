<?php

namespace App\Support;

class NumberToWords
{
    private const DIGITS = ['không', 'một', 'hai', 'ba', 'bốn', 'năm', 'sáu', 'bảy', 'tám', 'chín'];

    private const SCALES = ['', ' nghìn', ' triệu', ' tỷ', ' nghìn tỷ', ' triệu tỷ'];

    public static function convert(int|float|string|null $number): string
    {
        $number = (int) preg_replace('/\D/', '', (string) $number);

        if ($number === 0) {
            return 'Không';
        }

        $groups = [];
        $n = $number;
        while ($n > 0) {
            $groups[] = $n % 1000;
            $n = intdiv($n, 1000);
        }

        $parts = [];
        $count = count($groups);
        for ($i = $count - 1; $i >= 0; $i--) {
            $g = $groups[$i];
            if ($g === 0) {
                continue;
            }
            $isFull = $i < $count - 1;
            $words = self::readGroup($g, $isFull);
            $parts[] = trim($words.self::SCALES[$i]);
        }

        $result = implode(' ', $parts);
        $result = preg_replace('/\s+/', ' ', $result);

        return mb_strtoupper(mb_substr($result, 0, 1), 'UTF-8').mb_substr($result, 1, null, 'UTF-8');
    }

    private static function readGroup(int $n, bool $full): string
    {
        $h = intdiv($n, 100);
        $t = intdiv($n % 100, 10);
        $u = $n % 10;
        $words = [];

        if ($h > 0 || $full) {
            $words[] = self::DIGITS[$h].' trăm';
        }

        if ($t > 1) {
            $words[] = self::DIGITS[$t].' mươi';
            if ($u === 1) {
                $words[] = 'mốt';
            } elseif ($u === 5) {
                $words[] = 'lăm';
            } elseif ($u > 0) {
                $words[] = self::DIGITS[$u];
            }
        } elseif ($t === 1) {
            $words[] = 'mười';
            if ($u === 5) {
                $words[] = 'lăm';
            } elseif ($u > 0) {
                $words[] = self::DIGITS[$u];
            }
        } else {
            if ($u > 0) {
                if ($h > 0 || $full) {
                    $words[] = 'lẻ';
                }
                $words[] = self::DIGITS[$u];
            }
        }

        return implode(' ', $words);
    }
}
