<?php

namespace App\Enums;

enum SafeStatusEnum: int
{

    case Active = 1;
    case Inactive = 2;

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function label(): string
    {
        return match($this) {
            self::Active => 'active',
            self::Inactive => 'inactive',
        };
    }

    public function style(): string
    {
        return match($this) {
            self::Active => 'success',
            self::Inactive => 'danger',
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
