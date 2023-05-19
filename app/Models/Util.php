<?php

namespace App\Models;

class Util
{
    public static function convertMinutesToHours($minutes): string
    {
        $hours = floor($minutes / 60);
        $minutes = $minutes % 60;

        return sprintf("%02d:%02d", $hours, $minutes);
    }

    public static function convertHoursToMinutes($hours): int
    {
        [$hours, $minutes] = explode(":", $hours);

        return ($hours * 60) + $minutes;
    }

    public static function increasePercentage($value, $percentage): string
    {
        $valueInMinutes = self::convertHoursToMinutes($value);
        $increasedValue = $valueInMinutes + ($valueInMinutes / 100 * $percentage);

        return self::convertMinutesToHours($increasedValue);
    }

    public static function splitByHashtag($value): array
    {
        if (is_array($value)) {
            return $value;
        }

        return explode(',', $value);
    }

    public static function calculateTimeSpent($filters = 0, $treatment = 0): string
    {
        $filters = self::splitByHashtag($filters);
        $treatmentTime = Tratamentos::getById($treatment)->tempo_gasto;
        $filterPercentage = Filtro::filtroById($filters);

        foreach ($filterPercentage as $value) {
            $treatmentTime = self::increasePercentage($treatmentTime, $value->porcentagem_tempo);
        }

        return $treatmentTime;
    }

    public static function convertHoursToSeconds($time): int
    {
        return strtotime('1970-01-01 ' . $time . 'UTC');
    }
}
