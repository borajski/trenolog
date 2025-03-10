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
    $user_id = auth()->user()->id;
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
<p>Proteins: {{round($obrok->proteins,1)}}<br>Carbs:{{round($obrok->carbs,1)}}<br>Sugars:{{round($obrok->sugars,1)}}<br>Fibers:{{round($obrok->fibers,1)}}<br>Fats:{{round($obrok->fats,1)}}<br>Saturated fats:{{round($obrok->getAttribute('saturated-fats'),1)}}<br>Calories:{{round($obrok->calories,1)}}</p>

      </div>
    </div>
     </div>
 </div>
<!-- /.card-body -->

<div class="card-footer bg-light">
  @if ($obrok->user_id == $user_id)
  <a  href ="#" class="btn btn-success btn-sm" type="button" onclick="urediObrok()">Edit</a>  
  <a href="del_meal/{{ $obrok->id }}" class="btn btn-danger btn-sm" type="button"  onclick="return confirm('Are you sure you want to Remove?');">Delete</a>
  @else
  <a href="#" type="button" onclick="takeMeal({{$obrok->id}})"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-cloud-arrow-down-fill" viewBox="0 0 16 16">
  <path d="M8 2a5.53 5.53 0 0 0-3.594 1.342c-.766.66-1.321 1.52-1.464 2.383C1.266 6.095 0 7.555 0 9.318 0 11.366 1.708 13 3.781 13h8.906C14.502 13 16 11.57 16 9.773c0-1.636-1.242-2.969-2.834-3.194C12.923 3.999 10.69 2 8 2m2.354 6.854-2 2a.5.5 0 0 1-.708 0l-2-2a.5.5 0 1 1 .708-.708L7.5 9.293V5.5a.5.5 0 0 1 1 0v3.793l1.146-1.147a.5.5 0 0 1 .708.708"/>
</svg>Take this meal</a>
 @endif
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
                    <div class="col-md-6">
                      <div class="form-group">
                            <label for="name"><b>Name:</b></label>
                            <input type="text" class="form-control" name="name" value="{{$obrok->name}}" autocomplete="off">
                        </div>
                           <div class="form-group">
                            <label for="sort"><b>Sort:</b></label>
                            <input type="text" class="form-control" name="sort" value="{{$obrok->sort}}" autocomplete="off">
                        </div>
                        <div class="form-group">
                        <label for="status"><b>Status:</b></label>
                        <select name="status" class="form-control">
                                @if ($obrok->status == "private")  
                                 <option value="private" selected>Private</option>                            
                                 <option value="public">Public</option>
                                @elseif ($obrok->status == "public")
                                <option value="public" selected>Public</option> 
                                <option value="private">Private</option> 
                                @else
                                <option value="{{$obrok->status}}" selected>Copy</option> 
                                @endif                        
                            </select>
                    </div>
</div>
</div>
                </div>               
                    <div class="col-md-6"><!-- unos namirnica -->
                     
                    <label for="ingredients"><b>Ingredients:</b></label>
                   
            <div class="row mb-3 align-items-center">
                <div class="col-md-6">
                    <input type="text" class="form-control" placeholder="Food" id="myfood-search" name="namirnica[]" autocomplete="off">
                    <div class="search-myresults"></div>
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
            <div id="total-info">
            <h5>Total:</h5>
            <p>Proteins: {{round($obrok->proteins,1)}}<br>Carbs:{{round($obrok->carbs,1)}}<br>Sugars:{{round($obrok->sugars,1)}}<br>Fibers:{{round($obrok->fibers,1)}}<br>Fats:{{round($obrok->fats,1)}}<br>Saturated fats:{{round($obrok->getAttribute('saturated-fats'),1)}}<br>Calories:{{round($obrok->calories,1)}}</p>
</div>
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
function takeMeal(obrokId) {
    fetch('/copy-meal', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            obrok_id: obrokId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.href = '/meals'; 
        } else {
            alert('Došlo je do greške prilikom kopiranja obroka.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Došlo je do greške prilikom kopiranja obroka.');
    });
}
</script>
@endsection
