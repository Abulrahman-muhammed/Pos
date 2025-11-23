<?php

namespace App\Services;
use App\Models\Item;
use App\Models\WarehouseTransaction;
use App\Enums\WarehouseTransactionTypeEnum;
class StockMangmentService
{
    public function initStock($item, $warehouseId, $initQuantity){
        // warehouse && warehouse transaction
        $item->warehouses()->attach(
            $warehouseId,
            ['quantity' => $initQuantity]
        );

        $item->warehouseTransactions()->create([
            'transaction_type' => WarehouseTransactionTypeEnum::init,
            'quantity' => $initQuantity,
            'quantity_after' => $initQuantity,
            'description' => 'Initial stock added to warehouse ID: ' . $warehouseId,
        ]);
    }

    public function decreaseStock($item, $warehouseId, $quantity, $reference = null)
    {
        $stock = $item->warehouses()->where('itemable_id', $warehouseId)->first();
        if (!$stock) {
            $this->initStock($item, $warehouseId, 0);
        }
        $item->warehouses()->where('itemable_id', $warehouseId)->decrement('quantity', $quantity);
        $item->warehouseTransactions()->create([
            'transaction_type' => WarehouseTransactionTypeEnum::sub,
            'quantity' => $quantity * -1,
            'quantity_after' => $item->warehouses()->where('itemable_id', $warehouseId)->first()->pivot->quantity,
            'description' => 'Stock decreased from warehouse ID: ' . $warehouseId . ($reference ? ', Reference ID: ' . $reference->id : ''),
        ]);

    }
}