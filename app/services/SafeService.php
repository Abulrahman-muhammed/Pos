<?php
namespace App\Services;

use App\Models\SafeTransaction;
use App\Enums\SafeTransactionTypeEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Enums\SafeStatusEnum;
use DB;

class SafeService
{
    /**
     * Update the safe balance
     */
    public function inTransaction(Model $reference, float $amount, string $description): void
    {
        $this->performTransaction($reference, $amount, SafeTransactionTypeEnum::In, $description);
    }

    public function outTransaction(Model $reference, float $amount, string $description): void
    {
        $this->performTransaction($reference, $amount, SafeTransactionTypeEnum::Out, $description);
    }

    private function performTransaction(Model $reference, float $amount, SafeTransactionTypeEnum $type, string $description): void
    {
        if ($amount <= 0) {
            return;
        }

        DB::transaction(function () use ($reference, $amount, $type, $description) {
            $safe = $reference->safe()->lockForUpdate()->firstOrFail();

            if ($type === SafeTransactionTypeEnum::in) {
                $safe->balance += $amount;
            } else {
                $safe->balance -= $amount;
            }

            $safe->save();

            $reference->safeTransactions()->create([
                'user_id' => Auth::id(),
                'type' => $type,
                'safe_id' => $safe->id,
                'amount' => $amount,
                'balance_after' => $safe->fresh()->balance,
                'description' => $description,
            ]);
        });
    }


}