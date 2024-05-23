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
        $obroci = $query->orderBy('name')->get();
        return view('layouts.back_layouts.meal.index')->with('obroci',$obroci);
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
