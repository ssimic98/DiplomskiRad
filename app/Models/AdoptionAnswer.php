<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdoptionAnswer extends Model
{
    use HasFactory;

    protected $fillable=['user_id','dog_id','answers','adoption_id','status'];
    protected $casts = [
        'answers' => 'array', 
    ];
    

    public function adoption()
    {
        return $this->belongsTo(Adoption::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function dog()
    {
        return $this->belongsTo(Dog::class);
    }
}
