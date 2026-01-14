<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brands extends Model
{
    protected $table = 'brands';

    protected $fillable = [
        'brand_name'
    ];

    public function cars()
    {
        return $this->hasMany(Cars::class, 'brand_id');
    }
}
