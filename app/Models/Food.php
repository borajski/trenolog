<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class Food extends Model
{
   // use HasFactory;
   public function validateRequest(Request $request)
    {
      $request->validate([
          'name'  => 'required',
          'proteins'  => 'required',
          'carbs'  => 'required',
          'fats'  => 'required',
          'calories'  => 'required',
          'status'  => 'required',
     ]);    
      $this->setRequest($request);    
      return $this;
    }
    public static function storeData($request)
{
    
    return self::insertGetId([
        'user_id'         =>  auth()->user()->id,
        'name'            =>  $request->name,
        'producer'        =>  $request->producer,
        'sort'            =>  $request->sort,
        'proteins'        =>  $request->proteins,
        'carbs'           =>  $request->carbs,
        'sugars'          =>  $request->sugars,
        'fibers'          =>  $request->fibers,
        'fats'            =>  $request->fats,
        'saturated-fats'  =>  $request->saturated_fats,
        'calories'        =>  $request->calories,
        'status'          =>  $request->status,
        'created_at'    =>  Carbon::now(),
        'updated_at'    =>  Carbon::now()
    ]);
}
private function setRequest($request)
  {
      $this->request = $request;
  }

  public static function updateData($request, $food_id)
  {

      return self::where('id', $food_id)->update([
        'user_id'         =>  auth()->user()->id,
        'name'            =>  $request->name,
        'producer'        =>  $request->producer,
        'sort'            =>  $request->sort,
        'proteins'        =>  $request->proteins,
        'carbs'           =>  $request->carbs,
        'sugars'          =>  $request->sugars,
        'fibers'          =>  $request->fibers,
        'fats'            =>  $request->fats,
        'saturated-fats'  =>  $request->saturated_fats,
        'calories'        =>  $request->calories,
        'status'          =>  $request->status,
        'updated_at' => Carbon::now()
      ]);
  }
   public function user()
    {
     return $this->belongsTo(User::class);
    }
}
