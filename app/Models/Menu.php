<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Menu;

class Menu extends Model
{
    //use HasFactory;
    public function validateRequest(Request $request)
    {
      $request->validate([
          'date'        => 'required',
          'namirnica' => 'required',
          'kolicina'  => 'required',
        ]);    
      $this->setRequest($request);    
      return $this;
    }
    public static function storeData($request)
{   
    $ingredients = "";
    $food = $request->namirnica;
    $quantity = $request->kolicina;
    foreach($food as $key => $namirnica)
    {
        $kolicina = $quantity[$key];
        $ingredients = $ingredients.$namirnica.'-'.$kolicina.',';
    }
   
    return self::insertGetId([
        'user_id'         =>  auth()->user()->id,
        'date'            =>  $request->date,
        'ingredients'     =>  $ingredients,
        'created_at'    =>  Carbon::now(),
        'updated_at'    =>  Carbon::now()
    ]);
}
private function setRequest($request)
  {
      $this->request = $request;
  }

  public static function updateData($request, $meal_id)
  {
    $ingredients = "";
    $food = $request->namirnica;
    $quantity = $request->kolicina;
    foreach($food as $key => $namirnica)
    {
        $kolicina = $quantity[$key];
        $ingredients = $ingredients.$namirnica.'-'.$kolicina.',';
    }
      return self::where('id', $meal_id)->update([
        'user_id'         =>  auth()->user()->id,
        'date'            =>  $request->date,
        'ingredients'     =>  $ingredients,
        'updated_at' => Carbon::now()
      ]);
  }
    public function user()
    {
     return $this->belongsTo(User::class);
    }
}
