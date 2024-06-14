<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Meal;
use App\Models\Photo;
use App\Models\Food;

class MealsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = (new Meal())->newQuery();
        $user_id = auth()->user()->id;

        $obroci = $query->orderBy('name')->get();
         // Svi obroci osim onih koje pripadaju trenutnom korisniku
         $obroci = Meal::where('user_id', '!=', $user_id)->where('status','public')->orderBy('name')->paginate(10);
        // Obroci koji pripadaju trenutnom korisniku
        $moji_obroci = Meal::where('user_id', $user_id)->orderBy('name')->paginate(10);

       return view('layouts.back_layouts.meal.index', compact('obroci', 'moji_obroci'));

        
    
       
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $obrok = new Meal();
        $stored = $obrok->validateRequest($request)->storeData($request); // gives meal id
        if ($stored)
        {
          if ($request->hasFile('photo')) {
            $path = Photo::imageUpload($request->file('photo'), Meal::find($stored), 'meals', 'photo');
            $obrok->updateImagePath($stored, $path);
        }
                return redirect('/meals')->with(['success' => 'Meal created successfully!']);
        }
        else {
           return redirect()->back()->with(['error' => 'Oops! Some errors occured!']);
        }
    
    }
    public function search(Request $request)
{
    $query = $request->get('query');
    $meals = Meal::where('name', 'LIKE', "%{$query}%")->get();
    return response()->json($meals);
}
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $obrok = Meal::find($id);
      $foodItems = Food::all();
      return view('layouts.back_layouts.meal.obrok', compact('obrok', 'foodItems'));
      //return view('layouts.back_layouts.meal.obrok')->with('obrok',$obrok);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $meal = Meal::find($id);
        $updated = $meal->validateRequest($request)->updateData($request,$id);
        if ($updated)
        {
          if ($request->hasFile('photo')) {
            $path = Photo::imageUpload($request->file('photo'), $meal, 'meals', 'photo');
            $meal->updateImagePath($id, $path);
        }
      
      return redirect()->route('meals.show', [$meal])->with(['success' => 'Meal successfully edited!']);
        }
        else {
           return redirect()->back()->with(['error' => 'Uf! Došlo je do pogreške u spremanju podataka!']);
        }
    }
    public function copyMeal(Request $request)
{
    $user_id = auth()->user()->id;
    $obrok_id = $request->input('obrok_id');

    // Pronađi originalnu namirnicu
    $originalMeal = Meal::find($obrok_id);

    if ($originalMeal) {
        // Kreiraj kopiju obroka za trenutnog korisnika
        $newMeal = $originalMeal->replicate();
        $newMeal->user_id = $user_id;
        $newMeal->status = $originalMeal->user_id;
        $newMeal->save();

        return response()->json(['success' => true]);
    }

    return response()->json(['success' => false]);
}
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {       
        $obrok = Meal::find($id);
        if ($obrok->photo != NULL)
        {
          Photo::imageDelete($obrok, 'meals', 'photo');
            }
          
        $obrok->delete();
        return redirect('/meals')->with(['success' => 'Meal deleted successfully!']);
    }
}
