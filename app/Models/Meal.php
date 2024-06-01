<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Meal;
use App\Models\Food;
use App\Models\Photo;

class Meal extends Model
{
    //use HasFactory;
    public function validateRequest(Request $request)
    {
      $request->validate([
          'name'        => 'required',
          'sort'        => 'required',
          'status'      => 'required',
          'namirnica' => 'required',
          'identifikacija' => 'required',
          'kolicina'  => 'required',
        ]);    
      $this->setRequest($request);    
      return $this;
    }
    public static function storeData($request)
{   
    $ingredients = "";
    $food = $request->namirnica;
    $food_id =$request->identifikacija;
    $quantity = $request->kolicina;
    
    $proteins = 0;
    $carbs = 0;
    $sugars = 0;
    $fibers = 0;
    $fats = 0;
    $saturated_fats = 0;    
    $calories = 0;
 
    foreach($food as $key => $namirnica)
    {
        $kolicina = $quantity[$key];
        $id_namirnica = $food_id[$key];
      
      
        $food_details = Food::find($id_namirnica);

        if ($food_details) {

        $proteins = $proteins + $food_details->proteins * $kolicina / 100;
        $carbs = $carbs + $food_details->carbs * $kolicina / 100;
        $sugars = $sugars + $food_details->sugars * $kolicina / 100;
        $fibers = $fibers + $food_details->fibers * $kolicina / 100;
        $fats = $fats + $food_details->fats * $kolicina / 100;
        $saturated_fats = $saturated_fats + $food_details->getAttribute('saturated-fats') * $kolicina / 100;
        $calories = $calories + $food_details->calories * $kolicina / 100;
        }
             
        $ingredients = $ingredients.$id_namirnica.'-'.$kolicina.',';        
    }
    $ingredients = rtrim($ingredients, ',');


    return self::insertGetId([
        'user_id'         =>  auth()->user()->id,
        'name'            =>  $request->name,
        'sort'            =>  $request->sort,
        'status'          =>  $request->status,
        'ingredients'     =>  $ingredients,
        'proteins'        =>  $proteins,
        'carbs'           =>  $carbs,
        'sugars'          =>  $sugars,
        'fibers'          =>  $fibers,
        'fats'            =>  $fats,
        'saturated-fats'  =>  $saturated_fats,
        'calories'        =>  $calories,
        'created_at'    =>  Carbon::now(),
        'updated_at'    =>  Carbon::now()
    ]);
}
private function setRequest($request)
  {
      $this->request = $request;
  }
  public function updateImagePath($id, $path)
  {
      return Meal::where('id', $id)->update([
          'photo' => $path
      ]);
  }
  public static function updateData($request, $meal_id)
  {
    $ingredients = "";
    $food = $request->namirnica;

    $food_id =$request->identifikacija;
    $quantity = $request->kolicina;

    $proteins = 0;
    $carbs = 0;
    $sugars = 0;
    $fibers = 0;
    $fats = 0;
    $saturated_fats = 0;    
    $calories = 0;

    foreach($food as $key => $namirnica)
    {
        $kolicina = $quantity[$key];
        $id_namirnica = $food_id[$key];
        $food_details = Food::find($id_namirnica);

        if ($food_details) {

        $proteins = $proteins + $food_details->proteins * $kolicina / 100;
        $carbs = $carbs + $food_details->carbs * $kolicina / 100;
        $sugars = $sugars + $food_details->sugars * $kolicina / 100;
        $fibers = $fibers + $food_details->fibers * $kolicina / 100;
        $fats = $fats + $food_details->fats * $kolicina / 100;
        $saturated_fats = $saturated_fats + $food_details->getAttribute('saturated-fats') * $kolicina / 100;
        $calories = $calories + $food_details->calories * $kolicina / 100;
        }
       
        $ingredients = $ingredients.$id_namirnica.'-'.$kolicina.',';
        
    }
    $ingredients = rtrim($ingredients, ',');
      return self::where('id', $meal_id)->update([
        'user_id'         =>  auth()->user()->id,
        'name'            =>  $request->name,
        'sort'            =>  $request->sort,
        'status'          =>  $request->status,
        'ingredients'     =>  $ingredients,
        'proteins'        =>  $proteins,
        'carbs'           =>  $carbs,
        'sugars'          =>  $sugars,
        'fibers'          =>  $fibers,
        'fats'            =>  $fats,
        'saturated-fats'  =>  $saturated_fats,
        'calories'        =>  $calories,
        'updated_at' => Carbon::now()
      ]);
  }
    public function user()
    {
     return $this->belongsTo(User::class);
    }
}
