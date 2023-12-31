<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Muscle extends Model
{
    public function exercises()
    {
        return $this->hasMany(Exercise::class, 'target');
    } 
}
