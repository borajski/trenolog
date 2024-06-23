@extends('layouts.back_layouts.back-master')
@section('css_before')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h4 class="pb-4 pt-2">
                <span class="float-start"><b>My food database</b></span>
                <span class="float-end">
                    <span style="font-size: 0.8rem;">Add new food</span>
                    <a href="#" type="button" onclick="newFood()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-plus-square" viewBox="0 0 16 16">
                            <path
                                d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z" />
                            <path
                                d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
                        </svg></a>
                </span>
            </h4>
            <div class="input-group mb-3" id="pretraga">
                <input type="text" class="form-control me-2" placeholder="Search my food.." aria-label="pretraga"
                    aria-describedby="pretraga" id="myfood-search" name="moja_pretraga">
                <div class="input-group-append">
                    <button class="btn btn-secondary" type="button" id="mysearch-button">Search</button>
                </div>

            </div>
            <div class="search-myresults"></div>
            <div id="moje_pretrazivanje" style="display:none;">
                <div class="table-responsive-sm mt-4">
                    <table class="table table-hover bg-light shadow">
                        <thead class="thead t-head">
                            <tr>
                                <th>Name</th>
                                <th>Proteins</th>
                                <th>Carbs</th>
                                <th>Fats</th>
                                <th>Calories</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody id="rezultat-moje_pretrage">
                            <!-- Results will be appended here -->
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Div za unos nove namirnice-->
            <div id="noviUnos" style="display:none;">

                <!-- form start -->
                <form action="{{ route('foods.store') }}" method="POST">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="name"><b>Name:</b></label>
                                <input type="text" class="form-control" name="name">
                            </div>
                            <div class="form-group">
                                <label for="producer"><b>Producer:</b></label>
                                <textarea class="form-control" rows="1" name="producer" style="width: 100%"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="sort"><b>Sort:</b></label>
                                <textarea class="form-control" rows="1" name="sort" style="width: 100%"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="status"><b>Status:</b></label>
                                <select name="status" class="form-control">
                                    <option value="private" selected>Private</option>
                                    <option value="public">Public</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-6">

                            <div class="form-group">
                                <label for="proteins"><b>Proteins:</b></label>
                                <textarea class="form-control" rows="1" name="proteins" style="width: 100%"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="carbs"><b>Carbohydrates:</b></label>
                                <textarea class="form-control" rows="1" name="carbs" style="width: 100%"></textarea>
                                <label for="sugars">Sugars:</label>
                                <textarea class="form-control" rows="1" name="sugars" style="width: 60%"></textarea>
                                <label for="fibers">Fibers:</label>
                                <textarea class="form-control" rows="1" name="fibers" style="width: 60%"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="fats"><b>Fats:</b></label>
                                <input type="text" class="form-control" name="fats">
                                <label for="saturated fats">Saturated fats:</label>
                                <textarea class="form-control" rows="1" name="saturated_fats"
                                    style="width: 60%"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="calories"><b>Calories:</b></label>
                                <input type="text" class="form-control" name="calories">
                            </div>

                        </div>
                    </div>
                    <div class="text-end pt-3 pb-2">
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                </form>
            </div>
            <!-- Div za editiranje namirnice-->
            <div id="editFood" style="display:none;">
                <!-- form start -->
                <form id="edit_forma" action="" method="POST">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name"><b>Name:</b></label>
                                <input type="text" class="form-control" name="name" id="name">
                            </div>
                            <div class="form-group">
                                <label for="producer"><b>Producer:</b></label>
                                <textarea class="form-control" rows="2" name="producer" id="producer"
                                    style="width: 100%"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="sort"><b>Sort:</b></label>
                                <textarea class="form-control" rows="2" name="sort" id="sort"
                                    style="width: 100%"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="status"><b>Status:</b></label>
                                <select class="form-select" name="status" id="status">
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="proteins"><b>Proteins:</b></label>
                                <textarea class="form-control" rows="2" name="proteins" id="proteins"
                                    style="width: 100%"></textarea>
                            </div>

                            <div class="form-group">
                                <label for="carbs"><b>Carbohydrates:</b></label>
                                <input type="text" class="form-control" name="carbs" id="carbs">
                                <label for="fibers">Fibers:</label>
                                <input type="text" class="form-control" name="fibers" id="fibers">
                                <label for="sugars">Sugars:</label>
                                <input type="text" class="form-control" name="sugars" id="sugars">
                            </div>
                            <div class="form-group">
                                <label for="fats"><b>Fats:</b></label>
                                <input type="text" class="form-control" name="fats" id="fats">
                                <label for="saturated_fats">Saturated fats:</label>
                                <input type="text" class="form-control" name="saturated_fats" id="saturated-fats">
                            </div>
                            <div class="form-group">
                                <label for="calories"><b>Calories:</b></label>
                                <input type="text" class="form-control" name="calories" id="calories">
                            </div>
                        </div>
                    </div>
                    <div class="text-end pt-3 pb-2">
                        <button type="submit" class="btn btn-primary">Edit</button>
                    </div>
                </form>
            </div>
            <!--kraj diva za editiranje namirnice -->
            <!-- ispis tablice namirnica -->
            <div id="ispis-mojih-namirnica">
                @if (count($moje_namirnice) > 0)
                <p class="me-auto"><b> My food informations</b></p>
                <div class="table-responsive-sm mt-4">
                    <table class="table table-hover bg-light shadow">
                        <thead class="thead t-head">
                            <tr>
                                <th>Name</th>
                                <th>Proteins</th>
                                <th>Carbs</th>
                                <th>Fats</th>
                                <th>Calories</th>
                                <th>Edit</th>
                                <th>Delete</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach($moje_namirnice as $namirnica)
                            <tr>
                                <td>{{$namirnica->name}}</td>
                                <td>{{$namirnica->proteins}}</td>
                                <td> {{$namirnica->carbs}}</td>
                                <td> {{$namirnica->fats}}</td>
                                <td> {{$namirnica->calories}}</td>

                                <td> <a href="#" type="button" onclick="editFood({{$namirnica->id}})"><svg
                                            xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 116">
                                            <path
                                                d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z" />
                                        </svg></a>

                                </td>

                                <td><a href="del_food/{{ $namirnica->id }}"
                                        onclick="return confirm('Are you sure you want to Remove?');"><svg
                                            xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                            <path
                                                d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                                            <path fill-rule="evenodd"
                                                d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                                        </svg></a></td>

                            </tr>

                            @endforeach

                        </tbody>
                    </table>
                </div>
                <div class="pt-2">
                    <div class="d-flex justify-content-center">
                        {{$moje_namirnice->links()}}
                    </div>
                </div>

                @else
                <p>You have no foods in your database!</p>
                @endif
            </div>
        </div>
        <!--kraj ispisa namirnica -->
        <h4><span class="me-auto"><b>Public food database</b></span> </h4>
        <div class="input-group mb-3" id="pretraga">
            <input type="text" class="form-control me-2" placeholder="Search food.." aria-label="pretraga"
                aria-describedby="pretraga" id="food-search" name="pretraga">
            <div class="input-group-append">
                <button class="btn btn-secondary" type="button" id="search-button">Search</button>
            </div>

        </div>
        <div class="search-results"></div>
        <div id="pretrazivanje" style="display:none;">
            <div class="table-responsive-sm mt-4">
                <table class="table table-hover bg-light shadow">
                    <thead class="thead t-head">
                        <tr>
                            <th>Name</th>
                            <th>Proteins</th>
                            <th>Carbs</th>
                            <th>Fats</th>
                            <th>Calories</th>
                            <th>Make my</th>

                        </tr>
                    </thead>
                    <tbody id="rezultat-pretrage">
                        <!-- Results will be appended here -->
                    </tbody>
                </table>
            </div>
        </div>
        <!-- ispis tablice javnih namirnica -->
        <div id="ispis-namirnica">
            @if (count($namirnice) > 0)
            <span class="float-start"><b> Public food informations</b> </span>
            <div class="table-responsive-sm mt-4">
                <table class="table table-hover bg-light shadow">
                    <thead class="thead t-head">
                        <tr>
                            <th>Name</th>
                            <th>Proteins</th>
                            <th>Carbs</th>
                            <th>Fats</th>
                            <th>Calories</th>
                            <th>Make my</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($namirnice as $namirnica)
                        <tr>
                            <td>{{$namirnica->name}}</td>
                            <td>{{$namirnica->proteins}}</td>
                            <td> {{$namirnica->carbs}}</td>
                            <td> {{$namirnica->fats}}</td>
                            <td> {{$namirnica->calories}}</td>

                            <td> <a href="#" type="button" onclick="takeFood({{$namirnica->id}})"><svg
                                        xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                        class="bi bi-cloud-arrow-down-fill" viewBox="0 0 16 16">
                                        <path
                                            d="M8 2a5.53 5.53 0 0 0-3.594 1.342c-.766.66-1.321 1.52-1.464 2.383C1.266 6.095 0 7.555 0 9.318 0 11.366 1.708 13 3.781 13h8.906C14.502 13 16 11.57 16 9.773c0-1.636-1.242-2.969-2.834-3.194C12.923 3.999 10.69 2 8 2m2.354 6.854-2 2a.5.5 0 0 1-.708 0l-2-2a.5.5 0 1 1 .708-.708L7.5 9.293V5.5a.5.5 0 0 1 1 0v3.793l1.146-1.147a.5.5 0 0 1 .708.708" />
                                    </svg></a>
            </div>
            </td>
            </tr>

            @endforeach

            </tbody>
            </table>
            <div class="pt-2">
                <div class="d-flex justify-content-center">
                    {{$namirnice->links()}}
                </div>
            </div>
        </div>
        @else
        <p>There is no food informations from other users yet</p>
        @endif
    </div>
    <!--kraj ispisa namirnica -->
</div>
</div>
</div>
@endsection



@section('js_after')
<script src="{{ asset('js/back/pretraga-ajax.js') }}"></script>
<script>
    function newFood() {
    if (document.getElementById('noviUnos').style.display == "none") {
        document.getElementById('noviUnos').style.display = "block";
        document.getElementById('pretraga').style.display = "none"
    }
    else {
        document.getElementById('noviUnos').style.display = "none";
        document.getElementById('pretraga').style.display = "flex"
    }
}
function editFood(namirnica) {
var statusHtml = '';
fetch("/food/" + namirnica) 
  .then(response => {
    if (!response.ok) {
      return response.text().then(text => { throw new Error(text) });
    }
    return response.json();
  })
  .then(data => {
    // Handle the response data and update the HTML

    if (document.getElementById('editFood').style.display == "none") {
      document.getElementById('editFood').style.display = "block"; 
    } 

    document.getElementById('name').value = data.name; 
    document.getElementById('producer').value = data.producer; 
    document.getElementById('sort').value = data.sort; 
    document.getElementById('proteins').value = data.proteins; 
    document.getElementById('carbs').value = data.carbs; 
    document.getElementById('fibers').value = data.fibers; 
    document.getElementById('sugars').value = data.sugars;
    document.getElementById('fats').value = data.fats; 
    document.getElementById('saturated-fats').value = data['saturated-fats'];
    document.getElementById('calories').value = data.calories;
    if (data.status == "private") {
            statusHtml = '<option value="private" selected>Private</option><option value="public">Public</option>';
        } else if (data.status == "public") {
            statusHtml = '<option value="public" selected>Public</option><option value="private">Private</option>';
        }
        else
        statusHtml = '<option value="'+data.status+'" selected>Copy</option>';
    document.getElementById('status').innerHTML = statusHtml;    
    document.getElementById('edit_forma').action = "/foods/" + data.id;
  })
  .catch(error => {
    console.error("Error:", error);
    document.getElementById('errorMessage').innerHTML = error.message;
  });
}
/* skripta za pretraživanje opće baze podataka*/
document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('search-button').addEventListener('click', function() {
                var query = document.getElementById('food-search').value;
                var xhr = new XMLHttpRequest();
                var pretragaDiv = document.getElementById('pretrazivanje');
                var ispisNamirnicaDiv = document.getElementById('ispis-namirnica');

                pretragaDiv.style.display = "block";
                ispisNamirnicaDiv.style.display = "none";
                xhr.open('GET', '{{ route("search.food") }}?query=' + query, true);
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        var response = JSON.parse(xhr.responseText);
                        var resultsTable = document.getElementById('rezultat-pretrage');
                        resultsTable.innerHTML = '';
                        if (response.length > 0) {
                            response.forEach(function(food) {
                                var row = '<tr>'+
                                    '<td>' + food.name + '</td>'+
                                    '<td>' + food.proteins + '</td>'+
                                    '<td>' + food.carbs + '</td>'+
                                    '<td>' + food.fats + '</td>'+
                                    '<td>' + food.calories + '</td>'+
                                    '<td><a href="#" type="button" onclick="takeFood('+food.id+')"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-cloud-arrow-down-fill" viewBox="0 0 16 16"><path d="M8 2a5.53 5.53 0 0 0-3.594 1.342c-.766.66-1.321 1.52-1.464 2.383C1.266 6.095 0 7.555 0 9.318 0 11.366 1.708 13 3.781 13h8.906C14.502 13 16 11.57 16 9.773c0-1.636-1.242-2.969-2.834-3.194C12.923 3.999 10.69 2 8 2m2.354 6.854-2 2a.5.5 0 0 1-.708 0l-2-2a.5.5 0 1 1 .708-.708L7.5 9.293V5.5a.5.5 0 0 1 1 0v3.793l1.146-1.147a.5.5 0 0 1 .708.708"/></svg></a></td>'+
                             '</tr>';
                                resultsTable.innerHTML += row;
                            });
                        } else {
                            resultsTable.innerHTML = '<tr><td colspan="7">No results found</td></tr>';
                        }
                    }
                };
                xhr.send();
            });
        });
/* skripta za pretraživanje korisnikove baze */
document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('mysearch-button').addEventListener('click', function() {
                var query = document.getElementById('myfood-search').value;
                var xhr = new XMLHttpRequest();
                var pretragaDiv = document.getElementById('moje_pretrazivanje');
                var ispisNamirnicaDiv = document.getElementById('ispis-mojih-namirnica');

                pretragaDiv.style.display = "block";
                ispisNamirnicaDiv.style.display = "none";
                xhr.open('GET', '{{ route("search.myfood") }}?query=' + query, true);
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        var response = JSON.parse(xhr.responseText);
                        var resultsTable = document.getElementById('rezultat-moje_pretrage');
                        resultsTable.innerHTML = '';
                        if (response.length > 0) {
                            response.forEach(function(food) {
                                var row = '<tr>'+
                                    '<td>' + food.name + '</td>'+
                                    '<td>' + food.proteins + '</td>'+
                                    '<td>' + food.carbs + '</td>'+
                                    '<td>' + food.fats + '</td>'+
                                    '<td>' + food.calories + '</td>'+
                                    '<td><a href="#" type="button" onclick="editFood('+food.id+')"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16"><path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"/></svg></a></td>'+
                                    '<td><a href="del_food/' + food.id + '" onclick="return confirm(\'Are you sure you want to Remove?\');"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16"><path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/><path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/></svg></a></td>'+
                                '</tr>';
                                resultsTable.innerHTML += row;
                            });
                        } else {
                            resultsTable.innerHTML = '<tr><td colspan="7">No results found</td></tr>';
                        }
                    }
                };
                xhr.send();
            });
        });
function takeFood(namirnicaId) {
    fetch('/copy-food', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            namirnica_id: namirnicaId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();  // Osvježava stranicu nakon uspjeha
        } else {
            alert('Došlo je do greške prilikom kopiranja namirnice.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Došlo je do greške prilikom kopiranja namirnice.');
    });
}
</script>
@endsection