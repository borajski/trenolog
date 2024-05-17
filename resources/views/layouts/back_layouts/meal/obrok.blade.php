@extends('layouts.back_layouts.back-master')
@section('content')
<div class="container">
    <div class="row">
    <div class="card  shadow border-0">
   <div class="card-header  t-head">
      <h3 class="card-title">{{$obrok->name}}</h3>
   </div>
  <div class="card-body bg-light">
    <div class="row">
      <div class="col-md-6">
        <img class="align-center img-responsive img-thumbnail" name="slika" src="{{ asset($obrok->photo)}}" align="middle" width="250" alt="">
      </div>
      <div class="col-md-6">
        <h5>Sort:{{$obrok->sort}}</h5>
        <p></p>
        
        <h5>Ingredients:</h5>
        <p>      
@php
    $ingredients = explode(',', $obrok->ingredients);
    $proteins = 0;
    $carbs = 0;
    $fats = 0;
    $calories = 0;
@endphp
@foreach($ingredients as $ingredient)
    @php
        $parts = explode('-', $ingredient);
        if (count($parts) === 2) {
            $namirnica = $parts[0];
            $kolicina = $parts[1];
            $foodItem = $foodItems->where('name', $namirnica)->first();
            if (isset($foodItem)) {
                $proteins = $proteins + $foodItem->proteins*$kolicina/100;
                $carbs = $carbs + $foodItem->carbs*$kolicina/100;
                $fats = $fats + $foodItem->fats*$kolicina/100;
                $calories = $calories + $foodItem->calories*$kolicina/100;
            }
        }
    @endphp
   
    @if (isset($foodItem))
        {{ $namirnica }}  {{ $kolicina }}g<br>
        @endif
    
@endforeach
</p>
<h5>Total:</h5>
<p>Proteins: {{$proteins}}<br>Carbs:{{$carbs}}<br>Fats:{{$fats}}<br>Calories:{{$calories}}</p>

      </div>
    </div>
     </div>
 </div>
<!-- /.card-body -->

<div class="card-footer bg-light">
  <a href="#" class="btn btn-success btn-sm" type="button" data-toggle="modal" data-target="#urediGrupu">Uredi</a>
  <a href="#" class="btn btn-primary btn-sm" type="button" data-toggle="modal" data-target="#novaKategorija">Nova kategorija</a>
</div>

</div>
</div>
</div>
@endsection