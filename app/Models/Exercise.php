<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Training;

class Exercise extends Model
{
     public function training()
    {
        return $this->belongsTo(Training::class);
       }
}
