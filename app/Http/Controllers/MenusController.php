<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Food;


class MenusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $query = (new Menu())->newQuery();
       // $menus = $query->orderBy('date')->get();
       $foodItems = Food::all();
        return view('layouts.back_layouts.menus.index')->with('foodItems', $foodItems);
        //->with('menus',$menus);
    }
    public function checkMenu(Request $request)
{
    $date = $request->input('date');
    
    // Provjerite postoji li meni za zadani datum
    $menuExists = Menu::where('date', $date)->exists();
    
    // Dohvatite sastojke menija ako meni postoji
    $ingredients = [];
    if ($menuExists) {
        $menu = Menu::where('date', $date)->first();
        $ingredients = explode(',', $menu->ingredients);
        $id = $menu->id;
        $proteins = $menu->proteins;
        $carbs = $menu->carbs;
        $sugars = $menu->sugars;
        $fibers = $menu->fibers;
        $fats = $menu->fats;
        $saturated_fats = $menu->getAttribute('saturated-fats');
        $calories = $menu->calories;

    }
    
    return response()->json(['exists' => $menuExists, 'ingredients' => $ingredients, 'id' => $id,
'proteins'=>$proteins,'carbs'=>$carbs,'sugars'=>$sugars,'fibers'=>$fibers,'fats'=>$fats,
'saturated_fats'=>$saturated_fats,'calories'=>$calories]);
}

    /*
    public function checkMenu(Request $request)
    {
        $date = $request->input('date');
        // Provjerite postoji li meni za zadani datum
        $menuExists = Menu::where('date', $date)->exists();
        
        return response()->json(['exists' => $menuExists]);
    }*/

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
        $menu = new Menu();
        $stored = $menu->validateRequest($request)->storeData($request); // gives meal id
        if ($stored)
        {
            return redirect('/menus')->with(['success' => 'Menu created successfully!']);
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
        //
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
        $menu = Menu::find($id);
        $updated = $menu->validateRequest($request)->updateData($request,$id);
        if ($updated)
        {
        
            return redirect()->back()->with(['success' => 'Menu successfully edited!']);
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
        //
    }
}
