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
  
    $dnevni_unos = $query
        ->where('user_id', $user_id)
        ->whereRaw(
            "STR_TO_DATE(`date`, '%d/%m/%Y') >= ?",
            [now()->subDays(7)->format('Y-m-d')]
        )
        ->whereRaw(
            "STR_TO_DATE(`date`, '%d/%m/%Y') < ?",
            [now()->format('Y-m-d')]
        )
        ->get();
        
    $foodItems = Food::all();
    $mealItems = Meal::all();
    
    return view('home')->with(['foodItems' => $foodItems, 'mealItems' => $mealItems, 'menus' => $dnevni_unos]);
}

public function show(Request $request)
{
   $startDate = $request->input('startDate'); // 2025-12-26
$endDate   = $request->input('endDate');   // 2025-12-28

$startDMY = (new \DateTime($startDate))->format('d/m/Y');
$endDMY   = (new \DateTime($endDate))->format('d/m/Y');

$user_id = auth()->user()->id;

$dnevni_unos = Menu::where('user_id', $user_id)
    ->whereRaw("STR_TO_DATE(`date`, '%d/%m/%Y') >= STR_TO_DATE(?, '%d/%m/%Y')", [$startDMY])
    ->whereRaw("STR_TO_DATE(`date`, '%d/%m/%Y') <= STR_TO_DATE(?, '%d/%m/%Y')", [$endDMY])
    ->get();

    
    $foodItems = Food::all();
    $mealItems = Meal::all();

    return view('home')->with(['foodItems' => $foodItems, 'mealItems' => $mealItems, 'menus' => $dnevni_unos]);

    
}

}
