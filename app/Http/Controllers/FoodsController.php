<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Food;


class FoodsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = (new Food())->newQuery();
        $namirnice = $query->orderBy('name')->get();
        return view('layouts.back_layouts.food.index')->with('namirnice',$namirnice); 
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
        $food = new Food();
        $stored = $food->validateRequest($request)->storeData($request); // gives food id
        if ($stored)
        {
          return redirect('/foods')->with(['success' => 'Food added successfully!']);
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
    public function getFood($id)
{
    $food = Food::find($id);
    if (!$food) {
        return response()->json(['error' => 'food not found'], 404);
    }

    return response()->json($food);
}
public function search(Request $request)
{
    $query = $request->get('query');
    $foods = Food::where('name', 'LIKE', "%{$query}%")->get();

    return response()->json($foods);
}
    public function update(Request $request, $id)
    {
        $food = Food::find($id);
        $updated = $food->validateRequest($request)->updateData($request,$id);
        if ($updated)
        {
          return redirect('/foods')->with(['success' => 'Food updated successfully!']);
    }
    else {
       return redirect()->back()->with(['error' => 'Oops! Some errors occured!']);
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
        $food = Food::find($id);
     
        $food->delete();
        return redirect('/foods')->with(['success' => 'Food deleted successfully!']);
    }
}
