<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Owners extends Model
{
    protected $table = 'owners';

    protected $fillable = [
        'name',
        'address',
        'note'
    ];

    public function cars()
    {
        return $this->hasMany(Cars::class, 'owner_id');
    }
}
