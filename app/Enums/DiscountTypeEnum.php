<?php

namespace App\Enums;

enum DiscountTypeEnum: int
{

    case Percentage = 1;
    case Fixed = 2;

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function label(): string
    {
        return match($this) {
            self::Percentage => 'Percentage',
            self::Fixed => 'Fixed',
        };
    }

    public function style(): string
    {
        return match($this) {
            self::Percentage => 'success',
            self::Fixed => 'danger',
        };
    }

    public static function labels(): array
    {
        $labels = [];
        foreach (self::cases() as $case) {
            $labels[$case->value] = $case->label();
        }
        return $labels;
    }

}
