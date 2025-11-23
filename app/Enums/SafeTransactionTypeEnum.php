<?php


namespace App\Enums;

enum SafeTransactionTypeEnum: int
{

    case In = 1;
    case Out = -1;


    public function label(): string
    {
        return match($this) {
            SafeTransactionTypeEnum::In => __('trans.cash_in'),
            SafeTransactionTypeEnum::Out => __('trans.cash_out'),
        };
    }

    public function style()
    {
        return match($this) {
            SafeTransactionTypeEnum::In => 'success',
            SafeTransactionTypeEnum::Out => 'danger',
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