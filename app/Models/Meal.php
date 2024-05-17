<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Meal;
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
        $ingredients = $ingredients.$namirnica.','.$kolicina;
    }
   
    return self::insertGetId([
        'user_id'         =>  auth()->user()->id,
        'name'            =>  $request->name,
        'sort'            =>  $request->sort,
        'status'          =>  $request->status,
        'ingredients'     =>  $ingredients,
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
  public static function updateData($request, $fed_id)
  {

      return self::where('id', $fed_id)->update([
        'user_id'         =>  auth()->user()->id,
        'name'            =>  $request->name,
        'wm_categories'   =>  $request->wm_categories,
        'wf_categories'   =>  $request->wf_categories,
        'age_categories'  =>  $request->age_categories,
        'points_system'    =>  $request->points_system,
        'divisions'    =>  $request->divisions,
        'disciplines'    =>  $request->disciplines,
        'updated_at' => Carbon::now()
      ]);
  }
    public function user()
    {
     return $this->belongsTo(User::class);
    }
}
