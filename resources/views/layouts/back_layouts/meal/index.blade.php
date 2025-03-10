@extends('layouts.back_layouts.back-master')
@section('css_before')
<link rel="stylesheet" href="{{asset('css/pretraga.css?v=').time()}}">
@endsection
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h4>
                <span class="float-start"> My meals </span>
                <br><br>
                <span class="float-start">
                    <a href="#" type="button" onclick="newMeal()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-plus-square" viewBox="0 0 16 16">
                            <path
                                d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z" />
                            <path
                                d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
                        </svg></a>
                </span> <span style="font-size:0.8rem;">&nbsp;&nbsp;Add new meal</span>              
            </h4>
                    <!-- Div za unos novog obroka-->
        <div id="noviUnos" style="display:none;">
            <!-- form start -->
            <form enctype="multipart/form-data" action="{{ route('meals.store') }}" method="POST">
                {{ csrf_field() }}
            <div class="row">
            <div class="col-6">
            <div class="row">
                <div class="col-6">
                <div class="form-group align-center">
                            <label for="meal">Meal photo</label>
                            <br>
                            <img class="align-center img-responsive img-thumbnail" id="previewImg" name="slika" src="https://via.placeholder.com/250" align="middle" width="250" alt="">
              <input type="file" class="form-control-file" name="photo" onchange="previewFile(this);">
                        </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                            <label for="name"><b>Name:</b></label>
                            <input type="text" class="form-control" name="name" autocomplete="off">
                        </div>
                           <div class="form-group">
                            <label for="sort"><b>Sort:</b></label>
                            <input type="text" class="form-control" name="sort" autocomplete="off">
                            </div>
                        <div class="form-group">
                        <label for="status"><b>Status:</b></label>
                        <select name="status" class="form-control">
                                <option value="private" selected>Private</option>                              
                                <option value="public">Public</option>                             
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
           
                          
                     
                    </div>
                </div> <!-- kraj unosa namirnica -->
                <div class="text-end pt-3 pb-2">
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </form>
        </div> <!-- kraj diva za novi obrok -->
            </div>
            </div>
            <!--ispis mojih obroka -->
            <div class="row">
            @if (count($moji_obroci) > 0)
               @foreach($moji_obroci as $obrok)
                <div class="col-md-3 mb-4">
                    <div class="card h-100">
                        <div class="card-header text-center">
                            {{ $obrok->name }}
                        </div>
                        <a href="{{ route('meals.show', $obrok->id)}}">
                        <img src="{{ asset($obrok->photo)}}" class="card-img-top" alt="{{ $obrok->name }}">
</a>
                        <div class="card-body">
                            <p class="card-text text-center">{{ $obrok->sort }}</p>

                        </div>
                    </div>
                </div>
            @endforeach
            @else
             <h4>You have no meals yet</h4>
             @endif
        </div>
                    <!--ispis javnih obroka -->
                    <div class="row">
                    <h4>Public meals</h4>
                    @if (count($obroci) > 0)
            @foreach($obroci as $obrok)
                <div class="col-md-3 mb-4">
                    <div class="card h-100">
                        <div class="card-header text-center">
                            {{ $obrok->name }}
                        </div>
                        <a href="{{ route('meals.show', $obrok->id)}}">
                        <img src="{{ asset($obrok->photo)}}" class="card-img-top" alt="{{ $obrok->name }}">
</a>
                        <div class="card-body">
                            <p class="card-text text-center">{{ $obrok->sort }}</p>

                        </div>
                    </div>
                </div>
            @endforeach
            @else
            <h4>There is no meals created by other users</h4>
            @endif
        </div>
</div>

@endsection
@section('js_after')
<script src="{{ asset('js/back/previewImg.js') }}"></script>
<script src="{{ asset('js/back/pretraga-ajax.js') }}"></script>
<script src="{{ asset('js/back/dodajRed.js') }}"></script>
<script>
function newMeal() {
    if (document.getElementById('noviUnos').style.display == "none")
        document.getElementById('noviUnos').style.display = "block";
    else
        document.getElementById('noviUnos').style.display = "none";
}

</script>
@endsection