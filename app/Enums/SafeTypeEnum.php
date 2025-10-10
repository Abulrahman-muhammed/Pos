<?php

namespace App\Enums;

enum SafeTypeEnum: int
{
    case Cash = 1;
    case Online = 2;

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
    public function label(): string
    {
        return match($this) {
            self::Cash => 'cash',
            self::Online => 'online',
        };
    }
    public function style(): string
    {
        return match($this) {
            self::Cash => 'success',
            self::Online => 'info',
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
