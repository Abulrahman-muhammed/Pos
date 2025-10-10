<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Enums\ClientStatusEnum;

class Client extends Model 
{

    protected $table = 'clients';
    public $timestamps = true;

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = array('name', 'email', 'phone', 'address', 'balance', 'status');
    protected function casts(): array
    {
        return [
            'status' => ClientStatusEnum::class
        ];
    }
}