<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use App\Models\UserDetail;
use App\Models\Food;
use App\Models\Meal;
use App\Models\Menu;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function details()
    {
        return $this->hasOne(UserDetail::class, 'user_id');
    } 
    public function foods()
    {
        return $this->hasMany(Food::class, 'user_id');
    } 
    public function meals()
    {
        return $this->hasMany(Meal::class, 'user_id');
    }
    public function menus()
    {
        return $this->hasMany(Menu::class, 'user_id');
    }
}
