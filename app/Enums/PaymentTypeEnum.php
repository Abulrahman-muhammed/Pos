<?php

namespace App\Enums;

enum PaymentTypeEnum: int
{
    case Cash = 1;
    case Debit = 2; 

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function label(): string
    {
        return match($this) {
            self::Cash => 'cash',
            self::Debit => 'debit',
        };
    }

    public function style(): string
    {
        return match($this) {
            self::Cash => 'success',
            self::Debit => 'info',
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
