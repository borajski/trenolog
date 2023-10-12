<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\Exercise;

class Training extends Model
{
    public function user()
    {
     return $this->belongsTo(User::class);
    }
    public function exercises()
    {
        return $this->hasMany(Exercise::class, 'exercise_id');
    } 
}
