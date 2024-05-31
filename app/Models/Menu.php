<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Food;
use App\Models\Meal;

class Menu extends Model
{
    //use HasFactory;
    public function validateRequest(Request $request)
    {
      $request->validate([
          'date'        => 'required',
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

  $obroci = "";
  $obrok = $request->obrok;
  $porcija = $request->porcija;
  $obrok_id = $request->identobrok; 

  $proteins = 0;
  $carbs = 0;
  $sugars = 0;
  $fibers = 0;
  $fats = 0;
  $saturated_fats = 0;    
  $calories = 0;

  // pretraživanje detalja svake namirnice
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
      $saturated_fats = $saturated_fats + $food_details->saturated_fats * $kolicina / 100;
      $calories = $calories + $food_details->calories * $kolicina / 100;
      }
     
      $ingredients = $ingredients.$id_namirnica.'-'.$kolicina.',';
      
  }
  $ingredients = rtrim($ingredients, ',');

  //pretraživanje detalja svakog obroka
  foreach($obrok as $key => $obrok)
  {
      $kolicina = $porcija[$key];
      $id_obrok = $obrok_id[$key];
      $meal_details = Meal::find($id_obrok);

      if ($meal_details) {

      $proteins = $proteins + $meal_details->proteins * $kolicina;
      $carbs = $carbs + $meal_details->carbs * $kolicina;
      $sugars = $sugars + $meal_details->sugars * $kolicina;
      $fibers = $fibers + $meal_details->fibers * $kolicina;
      $fats = $fats + $meal_details->fats * $kolicina;
      $saturated_fats = $saturated_fats + $meal_details->saturated_fats * $kolicina;
      $calories = $calories + $meal_details->calories * $kolicina;
      }
     
      $obroci = $obroci.$id_obrok.'-'.$kolicina.',';
      
  }
  $obroci = rtrim($obroci, ',');
   
    return self::insertGetId([
        'user_id'         =>  auth()->user()->id,
        'date'            =>  $request->date,
        'ingredients'     =>  $ingredients,
        'proteins'        =>  $proteins,
        'carbs'           =>  $carbs,
        'sugars'          =>  $sugars,
        'fibers'          =>  $fibers,
        'fats'            =>  $fats,
        'saturated-fats'  =>  $saturated_fats,
        'calories'        =>  $calories,
        'meals'           =>  $obroci,
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
  $food_id =$request->identifikacija;
  $quantity = $request->kolicina;

  $obroci = "";
  $obrok = $request->obrok;
  $porcija = $request->porcija;
  $obrok_id = $request->identobrok; 

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
      $saturated_fats = $saturated_fats + $food_details->saturated_fats * $kolicina / 100;
      $calories = $calories + $food_details->calories * $kolicina / 100;
      }
     
      $ingredients = $ingredients.$id_namirnica.'-'.$kolicina.',';
      
  }
  $ingredients = rtrim($ingredients, ',');

    //pretraživanje detalja svakog obroka
    foreach($obrok as $key => $obrok)
    {
        $kolicina = $porcija[$key];
        $id_obrok = $obrok_id[$key];
        $meal_details = Meal::find($id_obrok);
  
        if ($meal_details) {
  
        $proteins = $proteins + $meal_details->proteins * $kolicina;
        $carbs = $carbs + $meal_details->carbs * $kolicina;
        $sugars = $sugars + $meal_details->sugars * $kolicina;
        $fibers = $fibers + $meal_details->fibers * $kolicina;
        $fats = $fats + $meal_details->fats * $kolicina;
        $saturated_fats = $saturated_fats + $meal_details->saturated_fats * $kolicina;
        $calories = $calories + $meal_details->calories * $kolicina;
        }
       
        $obroci = $obroci.$id_obrok.'-'.$kolicina.',';
        
    }
    $obroci = rtrim($obroci, ',');
      return self::where('id', $meal_id)->update([
        'user_id'         =>  auth()->user()->id,
        'date'            =>  $request->date,
        'ingredients'     =>  $ingredients,
        'proteins'        =>  $proteins,
        'carbs'           =>  $carbs,
        'sugars'          =>  $sugars,
        'fibers'          =>  $fibers,
        'fats'            =>  $fats,
        'saturated-fats'  =>  $saturated_fats,
        'calories'        =>  $calories,
        'meals'           =>  $obroci,
        'updated_at' => Carbon::now()
      ]);
  }
    public function user()
    {
     return $this->belongsTo(User::class);
    }
}
