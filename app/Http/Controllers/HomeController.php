<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Food;
use App\Models\Meal;
use App\Models\Menu;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
{
    $user_id = auth()->user()->id;
    $query = (new Menu())->newQuery();

    $dnevni_unos = $query->where('user_id', $user_id)
                         ->whereDate('created_at', '>=', now()->subDays(7))
                         ->whereDate('created_at', '<', now())
                         ->get();
    
    $foodItems = Food::all();
    $mealItems = Meal::all();
    
    return view('home')->with(['foodItems' => $foodItems, 'mealItems' => $mealItems, 'menus' => $dnevni_unos]);
}

public function show(Request $request)
{
    $startDate = $request->input('startDate');
    $endDate = $request->input('endDate');

    $user_id = auth()->user()->id;
    $query = (new Menu())->newQuery();

    $dnevni_unos = $query->where('user_id', $user_id)
                         ->whereDate('created_at', '>=', $startDate)
                         ->whereDate('created_at', '<=', $endDate)
                         ->get();
    
    $foodItems = Food::all();
    $mealItems = Meal::all();

    return view('home')->with(['foodItems' => $foodItems, 'mealItems' => $mealItems, 'menus' => $dnevni_unos]);

    
}

}
