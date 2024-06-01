<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class Food extends Model
{
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

    private static function decBroj($broj) {
        // Zamijeniti sve zareze u stringu s točkama
        return str_replace(',', '.', $broj);
    }

    public static function storeData($request)
    {
        $proteins = self::decBroj($request->proteins);
        $carbs = self::decBroj($request->carbs);
        $sugars = self::decBroj($request->sugars);
        $fibers = self::decBroj($request->fibers);
        $fats = self::decBroj($request->fats);
        $saturated_fats = self::decBroj($request->saturated_fats);
        $calories = self::decBroj($request->calories);
        
        return self::insertGetId([
            'user_id'         =>  auth()->user()->id,
            'name'            =>  $request->name,
            'producer'        =>  $request->producer,
            'sort'            =>  $request->sort,
            'proteins'        =>  $proteins,
            'carbs'           =>  $carbs,
            'sugars'          =>  $sugars,
            'fibers'          =>  $fibers,
            'fats'            =>  $fats,
            'saturated-fats'  =>  $saturated_fats,
            'calories'        =>  $calories,
            'status'          =>  $request->status,
            'created_at'      =>  Carbon::now(),
            'updated_at'      =>  Carbon::now()
        ]);
    }

    private function setRequest($request)
    {
        $this->request = $request;
    }

    public static function updateData($request, $food_id)
    {    
        $proteins = self::decBroj($request->proteins);
        $carbs = self::decBroj($request->carbs);
        $sugars = self::decBroj($request->sugars);
        $fibers = self::decBroj($request->fibers);
        $fats = self::decBroj($request->fats);
        $saturated_fats = self::decBroj($request->saturated_fats);
        $calories = self::decBroj($request->calories);

        return self::where('id', $food_id)->update([
            'user_id'         =>  auth()->user()->id,
            'name'            =>  $request->name,
            'producer'        =>  $request->producer,
            'sort'            =>  $request->sort,
            'proteins'        =>  $proteins,
            'carbs'           =>  $carbs,
            'sugars'          =>  $sugars,
            'fibers'          =>  $fibers,
            'fats'            =>  $fats,
            'saturated-fats'  =>  $saturated_fats,
            'calories'        =>  $calories,
            'status'          =>  $request->status,
            'updated_at'      =>  Carbon::now()
        ]);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
