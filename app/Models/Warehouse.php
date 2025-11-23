<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Item;
use App\Models\Sale;
use App\Enums\WarehouseStatusEnum;
class Warehouse extends Model 
{

    protected $table = 'warehouses';
    public $timestamps = true;
    protected $fillable = array('name', 'description', 'status');
    //cast 
    protected $casts = [
        'status' => WarehouseStatusEnum::class,
    ];
    public function items()
    {
        return $this->morphToMany('App\Models\Item', 'itemable')
        ->withPivot('quantity')->withTimestamps();
    }
    public function warehouseTransactions()
    {
        return $this->hasMany('App\Models\WarehouseTransaction', 'warehouse_id');
    }


    public function sales()
    {
        return $this->hasMany(Sale::class);
    }




}