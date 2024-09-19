<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HealthStatus extends Model
{
    use HasFactory;
    protected $fillable=['status'];

    public function dogs()
    {
        return $this->belongsToMany(Dog::class,'dog_health_status','dog_id','health_status_id');
    }
}
