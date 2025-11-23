<?php

namespace App\Enums;

enum WarehouseStatusEnum: int
{
    case Active = 1;
    case Inactive = 2;


    public static function values(): array
    {
        return array_map(fn($case) => $case->value, self::cases());
    }
    public function label(): string
    {
        return match($this) {
            WarehouseStatusEnum::Active => __('active'),
            WarehouseStatusEnum::Inactive => __('inactive'),
        };
    }

    public function style()
    {
        return match($this) {
            WarehouseStatusEnum::Active => 'success',
            WarehouseStatusEnum::Inactive => 'danger',
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