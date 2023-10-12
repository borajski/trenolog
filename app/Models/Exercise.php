<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Muscle;
use App\Models\Training;

class Exercise extends Model
{
    public function muscle()
    {
     return $this->belongsTo(Muscle::class);
    }
    public function training()
    {
        return $this->belongsTo(Training::class);
       }
}
