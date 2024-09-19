<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dog extends Model
{
    use HasFactory;

    protected $fillable=[
        'name',
        'user_id',
        'breed_id',
        'poster',
        'location',
        'is_adopted',
        'birth_date',
        'description',
        'gender_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function breed()
    {
        return $this->belongsTo(Breed::class);
    }
    public function gender()
    {
        return $this->belongsTo(Gender::class);
    }
    public function healthstatuses()
    {
        return $this->belongsToMany(HealthStatus::class,'dog_health_status','dog_id','health_status_id');
    }
    public function characteristics()
    {
        return $this->belongsToMany(Characteristic::class,'dog_characteristic','dog_id', 'characteristic_id');
    }
    public function favoritedByUser()
    {
        return $this->belongsToMany(User::class,'favorite_dogs')->withTimestamps();
    }

    public function adoptionAnswer()
    {
        return $this->hasMany(AdoptionAnswer::class);
    }

}
