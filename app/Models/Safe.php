<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\SafeStatusEnum;
use App\Enums\SafeTypeEnum;

class Safe extends Model 
{

    protected $table = 'safes';
    public $timestamps = true;
    protected $fillable = array('name', 'balance', 'status', 'description', 'type');

        protected function casts(): array
    {
        return [
            'status' => SafeStatusEnum::class,
            'type' => SafeTypeEnum::class,
        ];
    }
}