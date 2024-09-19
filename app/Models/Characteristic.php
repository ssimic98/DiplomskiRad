<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Characteristic extends Model
{
    use HasFactory;
    protected $fillable=['characteristic'];

    public function dogs()
    {
        return $this->belongsToMany(Dog::class,'dog_characteristic','dog_id','characteristic_id');
    }
}
