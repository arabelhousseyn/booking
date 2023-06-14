<?php


if (!function_exists('specialFormat')) {
    function specialFormat(float $number): int
    {
        $part1 = intval($number);

        $fractionalPart = $number - floor($number);

        if ($fractionalPart == 0.0) {
            $resultAsString = strval($part1).'00';
            return intval($resultAsString);
        }

        $multiplier = pow(10, strlen($fractionalPart) - 2);
        $adjustedFractionalPart = $fractionalPart * $multiplier;

        $adjustedNumber = floor($number) + $adjustedFractionalPart;

        $part2 = intval(number_format($adjustedNumber, 2));

        $resultAsString = strval($part1).''.strval($part2);

        return intval($resultAsString);
    }
}
