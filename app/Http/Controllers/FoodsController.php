<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Models\Food;
use App\Models\Menu;
use App\Models\Meal;



class FoodsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = auth()->user()->id;
    
        // Sve namirnice osim onih koje pripadaju trenutnom korisniku
        $namirnice = Food::where('user_id', '!=', $user_id)->where('status','public')->orderBy('name')->paginate(10);
    
        // Namirnice koje pripadaju trenutnom korisniku
        $moje_namirnice = Food::where('user_id', $user_id)->orderBy('name')->paginate(10);
    
        return view('layouts.back_layouts.food.index', compact('namirnice', 'moje_namirnice'));
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
    public function copyFood(Request $request)
{
    $user_id = auth()->user()->id;
    $namirnica_id = $request->input('namirnica_id');

    // Pronađi originalnu namirnicu
    $originalFood = Food::find($namirnica_id);

    if ($originalFood) {
        // Kreiraj kopiju namirnice za trenutnog korisnika
        $newFood = $originalFood->replicate();
        $newFood->user_id = $user_id;
        $newFood->status = $originalFood->user_id;
        $newFood->save();
        return response()->json(['success' => true]);
    }

    return response()->json(['success' => false]);
}

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
    $user_id = auth()->user()->id;
    $foods = Food::where('name', 'LIKE', "%{$query}%")->where('user_id', '!=', $user_id)->where('status','public')->get();
    return response()->json($foods);
}
public function mysearch(Request $request)
{
    $query = $request->get('query');
    $user_id = auth()->user()->id;
    $foods = Food::where('name', 'LIKE', "%{$query}%")->where('user_id',$user_id)->get();
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
    public function consumption()
    {
        return view('layouts.back_layouts.food.consumption');
    }
    public function getFoodConsumptionReport(Request $request)
    {
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
    
        $user_id = auth()->user()->id;
    
        $menus = Menu::where('user_id', $user_id)
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->get();
    
        $foodConsumption = [];
    
        foreach ($menus as $menu) {
            $ingredients = explode(',', $menu->ingredients);
            $meals = explode(',', $menu->meals);
    
            foreach ($ingredients as $item) {
                list($foodId, $quantity) = explode('-', $item);
                $foodId = (int)$foodId;
                $quantity = (float)$quantity;
    
                if (isset($foodConsumption[$foodId])) {
                    $foodConsumption[$foodId] += $quantity;
                } else {
                    $foodConsumption[$foodId] = $quantity;
                }
            }
    
            foreach ($meals as $obrok) {
                if ($obrok != '-') {
                    list($mealId, $porcije) = explode('-', $obrok);
                    $mealId = (int)$mealId;
                    $porcije = (float)$porcije;
    
                    $obrok_detalji = Meal::find($mealId);
    
                    $ingredients = explode(',', $obrok_detalji->ingredients);
                    foreach ($ingredients as $item) {
                        list($foodId, $quantity) = explode('-', $item);
                        $foodId = (int)$foodId;
                        $quantity = (float)$quantity * $porcije;
                        $quantity = number_format($quantity, 2, '.', '');
    
                        if (isset($foodConsumption[$foodId])) {
                            $foodConsumption[$foodId] += $quantity;
                        } else {
                            $foodConsumption[$foodId] = $quantity;
                        }
                    }
                }
            }
        }
    
        $groupedReport = [];
    
        foreach ($foodConsumption as $foodId => $quantity) {
            $foodItem = Food::find($foodId);
    
            if (!$foodItem) {
                continue;
            }
    
            $foodSort = $foodItem->sort;
            $foodName = $foodItem->name;
    
            if (!isset($groupedReport[$foodSort])) {
                $groupedReport[$foodSort] = [];
            }
    
            $groupedReport[$foodSort][] = [
                'food_name' => $foodName,
                'quantity' => $quantity,
            ];
        }
    
       return view('layouts.back_layouts.food.consumption', compact('groupedReport'));
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
