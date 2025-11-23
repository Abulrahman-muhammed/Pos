<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model 
{

    protected $table = 'sales';
    public $timestamps = true;
    protected $fillable = array('total',
                                'discount',
                                'discount_type','client_id' ,'shipping_cost', 'net_amount', 'paid_amount', 'remaining_amount', 'invoice_number', 'payment_type' 
                                ,'safe_id', 'user_id' , 'sale_date','warehouse_id');


    public function safeTransactions()
    {
        return $this->morphMany('App\Models\SafeTransaction', 'reference');
    }

    public function client()
    {
        return $this->belongsTo('App\Models\Client');
    }

    public function safe()
    {
        return $this->belongsTo('App\Models\Safe');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function items()
    {
        return $this->morphToMany('App\Models\Item', 'itemable')->withPivot('unit_price','notes','quantity','total_price');
    }
    public function warehouseItems()
    {
        return $this->morphToMany('App\Models\Item', 'itemable')->withPivot('quantity')->wherePivot('warehouse_id', $this->warehouse_id);
    }

    public function clientAccountTransactions()
    {
        return $this->morphMany('App\Models\client_account_transactions', 'reference');
    }

    // warehouse relation
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'warehouse_id');
    }
}