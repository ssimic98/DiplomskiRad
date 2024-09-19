<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdoptionQuestion extends Model
{
    use HasFactory;

    protected $fillable=['adoption_id','question_type','question_text','options'];

    protected $casts=[
        'options'=>'array'
    ];

    public function adoption()
    {
        return $this->belongsTo(Adoption::class);
    }
}
