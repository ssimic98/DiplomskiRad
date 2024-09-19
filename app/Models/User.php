<?php

namespace App\Models;

use App\Notifications\CustomPasswordResetEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Notifications\VerifyEmail;
use Laravel\Sanctum\HasApiTokens;
class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable,HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name','email','password','role','surname','city','address',];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = ['password','remember_token',];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
     /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmail);
    }
    public function dogs()
    {
        return $this->hasMany(Dog::class);
    }

    public function favoriteDogs()
    {
        return $this->belongsToMany(Dog::class,'favorite_dogs','user_id','dog_id')->withTimestamps();
    }

    public function getRoleAttribute()
    {
        return $this->attributes['role'];
    }
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new CustomPasswordResetEmail($token));
    }

    public function adoptions()
    {
        return $this->hasMany(User::class,'shelter_id');
    }

    public function surveyAnswers()
    {
        return $this->hasMany(AdoptionAnswer::class);
    }
}
