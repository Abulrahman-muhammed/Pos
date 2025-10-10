<?php

namespace App\Models;

use App\Enums\UnitStatusEnum;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model 
{

    protected $table = 'units';
    public $timestamps = true;
    protected $fillable = array('name', 'status');

    public function items()
    {
        return $this->hasMany('App\Models\Item');
    }

    protected function casts(): array
    {
        return [
            'status' => UnitStatusEnum::class
        ];
    }
}