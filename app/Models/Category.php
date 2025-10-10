<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\CategoryStatusEnum;

class Category extends Model 
{

    protected $table = 'categories';
    public $timestamps = true;
    protected $fillable = array('name', 'status');

    public function items()
    {
        return $this->hasMany(\App\Models\Item::class, 'category_id', 'id');
    }

    public function photo()
    {
        return $this->morphOne('App\Models\File', 'fileable')->where('usage','category_photo');
    }
    protected function casts(): array
    {
        return [
            'status' => CategoryStatusEnum::class
        ];
    }

}