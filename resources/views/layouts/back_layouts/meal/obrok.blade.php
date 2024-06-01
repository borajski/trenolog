@extends('layouts.back_layouts.back-master')
@section('content')
<div class="container">
    <div class="row">
  <div id="viewMeal">
    <div class="card shadow border-0">
   <div class="card-header t-head">
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
   /* $proteins = 0;
    $carbs = 0;
    $fats = 0;
    $calories = 0;
    */
@endphp
@foreach($ingredients as $ingredient)
    @php
        $parts = explode('-', $ingredient);
        $foodItem = null; // Resetovanje $foodItem na početku svake iteracije
        if (count($parts) === 2) {
            $namirnica = $parts[0];
            $kolicina = $parts[1];
            $foodItem = $foodItems->where('id', $namirnica)->first();
          
        }
    @endphp
   
    @if (isset($foodItem))
        {{ $foodItem->name }}  {{ $kolicina }}g<br>
    @endif
    
@endforeach
</p>
<h5><b>Total:</b></h5>
<p>Proteins: {{round($obrok->proteins,1)}}<br>Carbs:{{round($obrok->carbs)}}<br>Sugars:{{round($obrok->sugars)}}<br>Fibers:{{round($obrok->fibers)}}<br>Fats:{{round($obrok->fats)}}<br>Saturated fats:{{round($obrok->getAttribute('saturated-fats'))}}<br>Calories:{{round($obrok->calories)}}</p>

      </div>
    </div>
     </div>
 </div>
<!-- /.card-body -->

<div class="card-footer bg-light">
  <a  href ="#" class="btn btn-success btn-sm" type="button" onclick="urediObrok()">Edit</a>
  <a href="del_meal/{{ $obrok->id }}" class="btn btn-danger btn-sm" type="button"  onclick="return confirm('Are you sure you want to Remove?');">Delete</a>
</div>


</div>

</div>
  </div>
  <div id="editMeal" style="display:none;">
  <div class="col-10 offset-1">
            <!-- form start -->
            <form enctype="multipart/form-data" action="{{ route('meal.update', ['id' => $obrok->id]) }}" method="POST">
                {{ csrf_field() }}
            <div class="row">
            <div class="col-6">
            <div class="row">
                <div class="col-6">
                <div class="form-group align-center">
                            <label for="meal">Meal photo</label>
                            <br>
                            <img class="align-center img-responsive img-thumbnail" id="previewImg"name="slika" src="{{ asset($obrok->photo)}}"  align="middle" width="250" alt="">
              <input type="file" class="form-control-file" name="photo" onchange="previewFile(this);">
                        </div>
                    </div>
                    <div class="col-6">
                      <div class="form-group">
                            <label for="name"><b>Name:</b></label>
                            <input type="text" class="form-control" name="name" value="{{$obrok->name}}">
                        </div>
                           <div class="form-group">
                            <label for="sort"><b>Sort:</b></label>
                            <input type="text" class="form-control" name="sort" value="{{$obrok->sort}}">
                        </div>
                        <div class="form-group">
                        <label for="status"><b>Status:</b></label>
                        <select name="status" class="form-control">
                                @if ($obrok->status == "private")  
                                 <option value="private" selected>Private</option>                            
                                 <option value="public">Public</option>
                                @else
                                <option value="public" selected>Public</option> 
                                <option value="private">Private</option> 
                                @endif                        
                            </select>
                    </div>
</div>
</div>
                </div>               
                    <div class="col-6"><!-- unos namirnica -->
                     
                    <label for="ingredients"><b>Ingredients:</b></label>
                   
            <div class="row mb-3 align-items-center">
                <div class="col-md-6">
                    <input type="text" class="form-control" placeholder="Food" id="food-search" name="namirnica[]">
                    <div class="search-results"></div>
                    <input type="hidden" class="form-control " id="food-id" name="identifikacija[]"> 
                </div>
                <div class="col-md-4">
                    <input type="number" class="form-control" placeholder="Quantity" name="kolicina[]">
                </div>
                <div class="col-md-2">
                    <a role="button" class="add-row" href="#"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
  <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
  <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
</svg></a>
                </div>

            </div>
            <div id="new-rows"></div>
           <!--ispis postojećih namirnica-->
           @php 
           $ingredient = explode(',', $obrok->ingredients);
           @endphp
           @foreach($ingredients as $ingredient)
    @php
        $parts = explode('-', $ingredient);
        $foodItem = null; // Resetovanje $foodItem na početku svake iteracije
        if (count($parts) === 2) {
            $namirnica = $parts[0];
            $kolicina = $parts[1];
            $foodItem = $foodItems->where('id', $namirnica)->first();
            }
    @endphp
   
    @if (isset($foodItem))
    <div class="row mb-3 align-items-center">
                <div class="col-md-6">
                    <input type="text" class="form-control" name="namirnica[]" value="{{$foodItem->name}}" readonly>
                    <input type="hidden" class="form-control " id="food-id" name="identifikacija[]"  value="{{$foodItem->id}}"> 
                </div>
                <div class="col-md-4">
                    <input type="number" class="form-control" name="kolicina[]" value="{{$kolicina}}">
                </div>
                <div class="col-md-2">
    <a role="button" class="remove-row" href="#" style="color:red;"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                      <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                      <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                    </svg></a>
                </div>
    </div>
    @endif
    
@endforeach

                          
                     
                    </div>
                </div> <!-- kraj unosa namirnica -->
                
                <div class="text-end pt-3 pb-2">
                    <button type="submit" class="btn btn-primary">Edit</button>
                </div>
            </form>
            <h5>Total:</h5>
            <p>Proteins: {{round($obrok->proteins,1)}}<br>Carbs:{{round($obrok->carbs)}}<br>Sugars:{{round($obrok->sugars)}}<br>Fibers:{{round($obrok->fibers)}}<br>Fats:{{round($obrok->fats)}}<br>Saturated fats:{{round($obrok->getAttribute('saturated-fats'))}}<br>Calories:{{round($obrok->calories)}}</p>

      </div>

</div>
</div>
</div>
@endsection
@section('js_after')
<script src="{{ asset('js/back/previewImg.js') }}"></script>
<script src="{{ asset('js/back/pretraga-ajax.js') }}"></script>
<script src="{{ asset('js/back/dodajRed.js') }}"></script>
<script>
function urediObrok() {
    if (document.getElementById('editMeal').style.display == "none") {
      document.getElementById('viewMeal').style.display = "none";
      document.getElementById('editMeal').style.display = "block";
    }
        
    else {
      document.getElementById('editMeal').style.display = "none";
      document.getElementById('viewMeal').style.display = "block";
    }
        
}

/* brisanje starog retka namirnice */
        document.addEventListener('DOMContentLoaded', function () {
    // Select all elements with the class 'remove-row'
    var removeButtons = document.querySelectorAll('.remove-row');
    
    // Add click event listener to each button
    removeButtons.forEach(function (button) {
        button.addEventListener('click', function (event) {
            event.preventDefault(); // Prevent the default action of the anchor tag
            
            // Find the closest parent with the class 'row' and remove it
            var row = button.closest('.row');
            if (row) {
                row.remove();
            }
        });
    });
});

</script>
@endsection
