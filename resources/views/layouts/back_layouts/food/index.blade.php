@extends('layouts.back_layouts.back-master')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h4>
                <span class="float-start"> Food informations </span>
                
                <span class="float-end">
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
            <!-- ispis tablice -->
            <div class="table-responsive-sm mt-4" >
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
                        @foreach($namirnice as $namirnica)
                        <tr>
                            <td>{{$namirnica->name}}</td>
                            <td>{{$namirnica->proteins}}</td>
                            <td> {{$namirnica->carbs}}</td>
                            <td> {{$namirnica->fats}}</td>
                            <td> {{$namirnica->calories}}</td>
                            
                            <td> <a href="#" type="button" onclick="editFood({{$namirnica->id}})"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                    class="bi bi-pencil-fill" viewBox="0 0 116">                                  <path
                                        d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z" />
                                </svg></a>
            </div>
            </td>

            <td><a href="del_food/{{ $namirnica->id }}" onclick="return confirm('Are you sure you want to Remove?');"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
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
                            <textarea class="form-control" rows="1" name="proteins"
                                style="width: 100%"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="carbs"><b>Carbohydrates:</b></label>
                            <textarea class="form-control" rows="1" name="carbs"
                                style="width: 100%"></textarea>
                                <label for="sugars">Sugars:</label>
                            <textarea class="form-control" rows="1" name="sugars"
                                style="width: 60%"></textarea>
                                <label for="fibers">Fibers:</label>
                            <textarea class="form-control" rows="1" name="fibers"
                                style="width: 60%"></textarea>
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
                            <textarea class="form-control" rows="2" name="producer" id="producer" style="width: 100%"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="sort"><b>Sort:</b></label>
                            <textarea class="form-control" rows="2" name="sort" id="sort" style="width: 100%"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="status"><b>Status:</b></label>
                            <select class="form-select" name="status">
                            <option selected id="status"></option>
  <option value="private">Private</option>
  <option value="public">Public</option>

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
                            <label for="saturated-fats">Saturated fats:</label>
                            <input type="text" class="form-control" name="saturated-fats" id="saturated-fats">
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
    </div>
</div>
</div>
@endsection
@section('js_after')
<script>
function newFood() {
    if (document.getElementById('noviUnos').style.display == "none")
        document.getElementById('noviUnos').style.display = "block";
    else
        document.getElementById('noviUnos').style.display = "none";
}
function editFood(namirnica) {

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
    document.getElementById('status').value = data.status;     
    document.getElementById('edit_forma').action = "/foods/" + data.id;
  })
  .catch(error => {
    console.error("Error:", error);
    document.getElementById('errorMessage').innerHTML = error.message;
  });
}
</script>
@endsection