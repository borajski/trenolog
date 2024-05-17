@extends('layouts.back_layouts.back-master')
@section('css_before')
<style>
/* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

/* Firefox */
input[type=number] {
  -moz-appearance: textfield;
}
</style>
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
                </span>               
            </h4>
                    <!-- Div za unos nove namirnice-->
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
                            <img class="align-center img-responsive img-thumbnail" id="previewImg"name="slika" src="https://via.placeholder.com/250" align="middle" width="250" alt="">
              <input type="file" class="form-control-file" name="photo" onchange="previewFile(this);">
                        </div>
                    </div>
                    <div class="col-6">
                      <div class="form-group">
                            <label for="name"><b>Name:</b></label>
                            <input type="text" class="form-control" name="name">
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
</div>
                </div>

               
                    <div class="col-6">
                     
                    <label for="ingredients"><b>Ingredients:</b></label>
                   
            <div class="row mb-3 align-items-center">
                <div class="col-md-4">
                    <input type="text" class="form-control" placeholder="Food" name="namirnica[]">
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
                <div class="col-md-2">
                    <a role="button" class="remove-row" href="#" style="color:red;"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
  <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
  <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
</svg></a>
                </div>
            </div>
            <div id="new-rows"></div>
           
                          
                     
                    </div>
                </div>
                <div class="text-end pt-3 pb-2">
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </form>
        </div>
            </div>
            </div>
            <!--ispis obroka -->
            <div class="row">
            @foreach($obroci as $obrok)
                <div class="col-md-3 mb-4">
                    <div class="card h-100">
                        <div class="card-header text-center">
                            {{ $obrok->name }}
                        </div>
                        <img src="{{ $obrok->photo }}" class="card-img-top" alt="{{ $obrok->name }}">
                        <div class="card-body">
                            <p class="card-text text-center">{{ $obrok->sort }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
</div>
@endsection
@section('js_after')
<script>
function newMeal() {
    if (document.getElementById('noviUnos').style.display == "none")
        document.getElementById('noviUnos').style.display = "block";
    else
        document.getElementById('noviUnos').style.display = "none";
}
document.addEventListener('DOMContentLoaded', (event) => {
            document.querySelector('.add-row').addEventListener('click', addRow);
            document.querySelector('.remove-row').addEventListener('click', removeRow);

            function addRow() {
                const newRow = document.createElement('div');
                newRow.className = 'row mb-3 align-items-center';
                newRow.innerHTML = `
                <div class="col-md-4">
                    <input type="text" class="form-control" placeholder="Food" name="namirnica[]">
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
                <div class="col-md-2">
                    <a role="button" class="remove-row" href="#" style="color:red;"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
  <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
  <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
</svg></a>
                </div>
                `;
                document.getElementById('new-rows').appendChild(newRow);

                // Bind event listeners to the new buttons
                newRow.querySelector('.add-row').addEventListener('click', addRow);
                newRow.querySelector('.remove-row').addEventListener('click', removeRow);
            }

            function removeRow(event) {
                if (event.currentTarget.parentElement.parentElement.parentElement.children.length > 1) {
                    event.currentTarget.parentElement.parentElement.remove();
                }
            }
        });
        function previewFile(input) {
    var file = input.files[0];
    if (file) {
        var reader = new FileReader();
        reader.onload = function() {
            var img = input.parentNode.querySelector("img#previewImg");
            if (img) {
                img.src = reader.result;
            }
        }
        reader.readAsDataURL(file);
    }
}

</script>
@endsection