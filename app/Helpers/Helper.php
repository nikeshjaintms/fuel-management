<?php

if (!function_exists('convertToIndianWords')) {
    function convertToIndianWords($number)
    {
        $words = [
            0 => '', 1 => 'One', 2 => 'Two', 3 => 'Three', 4 => 'Four',
            5 => 'Five', 6 => 'Six', 7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
            10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve', 13 => 'Thirteen',
            14 => 'Fourteen', 15 => 'Fifteen', 16 => 'Sixteen', 17 => 'Seventeen',
            18 => 'Eighteen', 19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
            40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty', 70 => 'Seventy',
            80 => 'Eighty', 90 => 'Ninety'
        ];

        $units = ['', 'Thousand', 'Lakh', 'Crore'];

        // Ensure it's a valid number
        if (!is_numeric($number)) {
            return "Invalid Number";
        }

        // Split rupees and paise
        $integerPart = floor($number);
        $decimalPart = round(($number - $integerPart) * 100);

        $result = convertIntegerToIndianWords($integerPart, $words, $units);

        if ($decimalPart > 0) {
            $result .= " and " . convertIntegerToIndianWords($decimalPart, $words, $units) . " Paise";
        }

        return $result . " Only";
    }

    function convertIntegerToIndianWords($number, $words, $units)
    {
        if ($number == 0) {
            return 'Zero';
        }

        $result = '';
        $partArray = [];

        // Handle first 3 digits separately (Hundreds)
        if ($number >= 1000) {
            $partArray[] = $number % 1000;
            $number = (int)($number / 1000);
        } else {
            $partArray[] = $number;
            $number = 0;
        }

        // Handle rest of the digits in two-digit groups (Indian system: Lakh, Crore)
        while ($number > 0) {
            $partArray[] = $number % 100;
            $number = (int)($number / 100);
        }

        // Convert each part
        $i = 0;
        foreach ($partArray as $part) {
            if ($part > 0) {
                $result = convertThreeDigits($part, $words) . ' ' . ($units[$i] ?? '') . ' ' . $result;
            }
            $i++;
        }

        return trim($result);
    }

    function convertThreeDigits($num, $words)
    {
        $result = '';

        if ($num >= 100) {
            $result .= $words[(int)($num / 100)] . ' Hundred ';
            $num %= 100;
        }

        if ($num > 0) {
            if ($num < 20) {
                $result .= $words[$num] . ' ';
            } else {
                $result .= $words[(int)($num / 10) * 10] . ' ';
                if ($num % 10 > 0) {
                    $result .= $words[$num % 10] . ' ';
                }
            }
        }

        return trim($result);
    }
}
