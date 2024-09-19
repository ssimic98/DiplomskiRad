<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adoption extends Model
{
    use HasFactory;

    protected $fillable=['shelter_id','title','description'];


    public function questions()
    {
        return $this->hasMany(AdoptionQuestion::class);
    }

    public function shelter()
    {
        return $this->belongsTo(User::class,'shelter_id');
    }
}
