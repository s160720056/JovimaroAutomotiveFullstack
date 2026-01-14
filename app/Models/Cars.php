<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cars extends Model
{
    protected $table = 'cars';
    public $timestamps = true;
    protected $fillable = [
        'owner_id',
        'brand_id',
        'color',
        'description',
       
    ];
    //time

    public function owner()
    {
        return $this->belongsTo(Owners::class, 'owner_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brands::class, 'brand_id');
    }
}
