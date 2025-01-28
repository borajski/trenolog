@extends('layouts.back_layouts.back-master')
@section('css_before')
<meta name="csrf-token" content="{{ csrf_token() }}">
 <link rel="stylesheet" href="{{asset('css/pretraga.css?v=').time()}}">
@endsection
@section('js_before')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection
@section('content')
<p>
@if (!(auth()->user()->details))
<h4 class="text-center"><strong>Za potpuno korištenje platforme molimo vas uredite <a href="/profile" style="color:blue;">vaše korisničke podatke</a>!</strong></h4>
@endif
</p>
@php
function postotak ($single,$value,$total)
{
    if ($total > 0) {
      $postotak = $single*$value*100/$total;
      return round($postotak,1);
    }
    else {
      return 0;
    }
   
}
        $dates = [];
        $calories = [];
        $proteins = [];
        $carbs = [];
        $fats = [];
      

        $kalorije = 0;
        $proteini = 0;
        $ugh = 0;
        $seceri=0;
        $vlakna=0;
        $masti = 0;
        $zasicene_masti=0;
        $i = 0;

        foreach ($menus as $menu) {
            $i++;
            $dates[] = $menu->created_at->format('d-m-Y');
            $calories[] = $menu->calories;
            $kalorije += $menu->calories;
            $proteins[] = $menu->proteins;
            $proteini += $menu->proteins;
            $carbs[] = $menu->carbs;
            $ugh += $menu->carbs;
            $fats[] = $menu->fats;
            $masti += $menu->fats;
            $sugars[]=$menu->sugars;
            $seceri+=$menu->sugars;
            $fibers[]=$menu->fibers;
            $vlakna+=$menu->fibers;
            $saturated_fats=$menu->getAttribute('saturated-fats');
            $zasicene_masti+=$menu->getAttribute('saturated-fats');
        }
        if ($i > 0) {
        $kalorije = round($kalorije/$i,1);
        $masti = round($masti/$i,1);
        $proteini = round($proteini/$i,1);
        $ugh = round($ugh/$i,1);
        $seceri=round($seceri/$i,1);
        $vlakna=round($vlakna/$i,1);
        $zasicene_masti=round($zasicene_masti/$i,1);
        }
    @endphp
<div class="container">
    <div class="row">
        <div class="col-md-4">

            <h4><b>Trenutni unos namirnica</b></h4>
            <div class="daily-menu"></div>
            <div id="noviUnos" style="display:none;">
                <!-- form start -->
                <form method="POST" id="unos-forma">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="date"><b>Date:</b></label>
                                <input type="text" class="form-control" name="date" id="date" readonly>
                            </div>
                        </div>
                    </div>
                    <!-- unos namirnica -->
                    <div class="row mb-3 align-items-center">
                        <label for="ingredients"><b>Single ingredients:</b></label>
                        <div class="col-md-6">                            
                            <input type="text" class="form-control" placeholder="Food" id="myfood-search" name="namirnica[]" autocomplete="off">
                        </div>
                        <div class="col-md-4">
                            <input type="number" class="form-control" placeholder="Quantity (g)" name="kolicina[]">
                            <input type="hidden" class="form-control" id="food-id" name="identifikacija[]">
                        </div>
                        <div class="col-md-2">
                            <a role="button" class="add-row" href="#">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4" />
                                </svg>
                            </a>
                        </div>
                    </div> <!-- kraj unosa namirnica -->
                    <div class="search-myresults"></div> <!--ispis rezultata pretrage -->
                    <div id="new-rows"></div>
                    <!-- unos pojedinačnih obroka -->
                    <div class="row mb-3 align-items-center">
                        <label for="ingredients"><b>Meals intake:</b></label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" placeholder="Meal" id="meal-search" name="obrok[]" autocomplete="off">
                        </div>
                        <div class="col-md-4">
                            <input type="number" class="form-control" placeholder="Servings (n)" name="porcija[]">
                            <input type="hidden" class="form-control" id="meal-id" name="identobrok[]">
                        </div>
                        <div class="col-md-2">
                            <a role="button" class="add-mealrow" href="#">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4" />
                                </svg>
                            </a>
                        </div>
                    </div> <!-- kraj unosa obroka -->
                    <div class="search-results-meals"></div> <!--ispis rezultata pretrage -->
                    <div id="new-rows-meals"></div>
                    <div class="text-end pt-3 pb-2">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
                
            </div> <!-- kraj id="noviUnos" -->
        </div> <!-- kraj col-md-6 -->

        <div class="col-md-4">
            <h4><b>Trenutni odnos makrosa</b></h4>
            <canvas class="p-3" id="makrosChart"></canvas>
        </div>
      <div class="col-md-4">
      <div id="total-info"></div>
</div>
    </div> <!-- kraj row -->
    <div class="row">
        <h4><b>Macros intake last 7 days</b></h4>
        <p><i>or<br>more statistics...</i></p>
        <div class="date-picker">
        <form action="/" method="POST">
        @csrf 
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label for="startDate">Start Date</label>
          <input type="date" class="form-control" name="startDate" id="startDate">
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="endDate">End Date</label>
          <input type="date" class="form-control"  name="endDate" id="endDate">
        </div> 
        <div class="col-md-12 d-flex justify-content-end">
                <button type="submit" class="btn btn-primary mt-2">Submit</button>       
            </div>     
      </div>
    
    </div>
    
   </form>

</div>


<div class="col-md-6">
<canvas id="energyData"></canvas>
</div>
<div class="col-md-6">
<canvas id="proteinData"></canvas>
</div>
</div><!-- kraj row -->
<div class="row">
    <div class="col-md-6">
    <canvas id="carbsData"></canvas>
</div>
<div class="col-md-6">
<canvas id="fatsData"></canvas>
</div>
    </div><!-- kraj row -->
    <div class="row">
<div class="col-md-6">
<canvas id="ratiosData" class="p-4 m-4"></canvas>
</div>
<div class="col-md-6">
    <p class="pt-5"><b>Average intake:</b></p>
    <p>Proteins: {{$proteini}}g ({{postotak($proteini,4,$kalorije)}} %)<br>
    Carbs: {{$ugh}}g ({{postotak($ugh,4,$kalorije)}} %)<br>
    <i>Sugars</i>: {{$seceri}}g ({{postotak($seceri,4,$kalorije)}} %)<br>
    <i>Fibers</i>: {{$vlakna}}g<br>
    Fats: {{$masti}}g ({{postotak($masti,9,$kalorije)}} %)<br>
    <i>Saturated fats</i>: {{$zasicene_masti}}g ({{postotak($zasicene_masti,9,$kalorije)}} %)<br>
    <b>Calories: {{$kalorije}}kcal</b>
    </p>
    </div>
</div><!-- kraj row -->


</div> <!-- kraj container -->

@endsection
@section('js_after')
<script src="{{ asset('js/back/pretraga-ajax.js') }}"></script>
<script src="{{ asset('js/back/pretraga-obroka.js') }}"></script>
<script src="{{ asset('js/back/dodajRed.js') }}"></script>
<script src="{{ asset('js/back/dodajRedObrok.js') }}"></script>
<script>

    function toFixedOrZero(value, decimals) {
    var num = parseFloat(value);
    return isNaN(num) ? (0).toFixed(decimals) : num.toFixed(decimals);
}
function postotak (single,value,total)
{
    var percentage = single * value *100 / total;
    percentage = toFixedOrZero(percentage,1);
    return percentage;
}
function ratiosData(totalProtein, totalFats, totalCarbs, totalEnergy) {
    // Prikaz makronutrijenata u pie chartu
    // Izračun ukupne energije u kalorijama
   // var totalEnergy = (totalProtein * 4) + (totalCarbs * 4) + (totalFats * 9);

    // Izračun postotaka makronutrijenata
    var proteinPercentage = (totalProtein * 4 / totalEnergy) * 100;
    var fatsPercentage = (totalFats * 9 / totalEnergy) * 100;
    var carbsPercentage = (totalCarbs * 4 / totalEnergy) * 100;

    var ctx = document.getElementById('ratiosData').getContext('2d');
    var myPieChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Proteini', 'Masti', 'Ugljikohidrati'],
            datasets: [{
                label: 'Makronutrijenti',
                data: [proteinPercentage, fatsPercentage, carbsPercentage],
                backgroundColor: ['#36A2EB', '#FF6384', '#FFCD56']
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            return tooltipItem.label + ': ' + toFixedOrZero(tooltipItem.raw, 2) + ' %';
                        }
                    }
                }
            }
        }
    });
}
function chartMacros(totalProtein, totalFats, totalCarbs, totalEnergy) {
    // Prikaz makronutrijenata u pie chartu
    // Izračun ukupne energije u kalorijama
   // var totalEnergy = (totalProtein * 4) + (totalCarbs * 4) + (totalFats * 9);

    // Izračun postotaka makronutrijenata
    var proteinPercentage = (totalProtein * 4 / totalEnergy) * 100;
    var fatsPercentage = (totalFats * 9 / totalEnergy) * 100;
    var carbsPercentage = (totalCarbs * 4 / totalEnergy) * 100;

    var ctx = document.getElementById('makrosChart').getContext('2d');
    var myPieChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Proteini', 'Masti', 'Ugljikohidrati'],
            datasets: [{
                label: 'Makronutrijenti',
                data: [proteinPercentage, fatsPercentage, carbsPercentage],
                backgroundColor: ['#36A2EB', '#FF6384', '#FFCD56']
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            return tooltipItem.label + ': ' + toFixedOrZero(tooltipItem.raw, 2) + ' %';
                        }
                    }
                }
            }
        }
    });
}
function energyData() {
            var ctx = document.getElementById('energyData').getContext('2d');
            var energyChart = new Chart(ctx, {
                type: 'line', // ili 'bar' za bar grafikon
                data: {
                    labels: @json($dates),
                    datasets: [{
                        label: 'Calories',
                        data: @json($calories),
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderWidth: 1,
                        fill: false
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }
        function proteinData() {
            var ctx = document.getElementById('proteinData').getContext('2d');
            var energyChart = new Chart(ctx, {
                type: 'bar', // ili 'bar' za bar grafikon
                data: {
                    labels: @json($dates),
                    datasets: [{
                        label: 'Proteins',
                        data: @json($proteins),
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderWidth: 1,
                        fill: false
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }
        function carbsData() {
            var ctx = document.getElementById('carbsData').getContext('2d');
            var energyChart = new Chart(ctx, {
                type: 'bar', // ili 'bar' za bar grafikon
                data: {
                    labels: @json($dates),
                    datasets: [{
                        label: 'Carbs',
                        data: @json($carbs),
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderWidth: 1,
                        fill: false
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }
        function fatsData() {
            var ctx = document.getElementById('fatsData').getContext('2d');
            var energyChart = new Chart(ctx, {
                type: 'bar', // ili 'bar' za bar grafikon
                data: {
                    labels: @json($dates),
                    datasets: [{
                        label: 'Fats',
                        data: @json($fats),
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderWidth: 1,
                        fill: false
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }
    
function initializePage() {
    const today = new Date();
    const yyyy = today.getFullYear();
    const dailyMenuDiv = document.querySelector('.daily-menu');
    let mm = today.getMonth() + 1; // Months start at 0!
    let dd = today.getDate();
    const formattedToday = dd + '/' + mm + '/' + yyyy;  

    if (dailyMenuDiv) {
        dailyMenuDiv.innerHTML = '';
    } else {
        console.error('dailyMenuDiv not found');
    }

    const dateInput = document.getElementById('date');
    if (dateInput) {
        dateInput.value = formattedToday;
    } else {
        console.error('date input not found');
    }

    const noviUnosDiv = document.getElementById('noviUnos');
    if (noviUnosDiv && noviUnosDiv.style.display == "none") {
        noviUnosDiv.style.display = "block";
    } else {
        console.error('noviUnos div not found or already displayed');
    }

    var data = { date: formattedToday };
    var form = document.getElementById('unos-forma');
    var newRowsDiv = document.getElementById('new-rows');
    var newRowsMealsDiv = document.getElementById('new-rows-meals');
    var totalInfoDiv = document.getElementById('total-info');

    if (newRowsDiv) newRowsDiv.innerHTML = '';
    else console.error('newRowsDiv not found');

    if (newRowsMealsDiv) newRowsMealsDiv.innerHTML = '';
    else console.error('newRowsMealsDiv not found');

    if (totalInfoDiv) totalInfoDiv.innerHTML = '';
    else console.error('totalInfoDiv not found');

    // Pošaljite AJAX zahtjev
    fetch('/check-menu', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // Dodajte CSRF token
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.exists) {
            form.action = '{{ route('menu.update', ['id' => ':id']) }}'.replace(':id', data.id);

            var foodItems = @json($foodItems);
            var mealItems = @json($mealItems);

            // Iteriramo kroz sastojke obroka pojedinačne namirnice
            data.ingredients.forEach(function(ingredient) {
                var parts = ingredient.split('-');
                var foodItem = null; // Resetiranje foodItem na početku svake iteracije
                if (parts.length === 2) {
                    var id = +parts[0];
                    var kolicina = parts[1];
                    foodItem = foodItems.find(function(item) {
                        return item.id === id; // Promijenjena usporedba na ID
                    });
                }
                // Ako postoji foodItem, dodajemo HTML za prikaz sastojka u formi
                if (foodItem) {
                    var rowHtml = '<div class="row mb-3 align-items-center">';
                    rowHtml += '<div class="col-md-6">';
                    rowHtml += '<input type="text" class="form-control" name="namirnica[]" value="' + foodItem.name + '" readonly>';
                    rowHtml += '<input type="hidden" class="form-control" name="identifikacija[]" value="' + foodItem.id + '" >';
                    rowHtml += '</div>';
                    rowHtml += '<div class="col-md-4">';
                    rowHtml += '<input type="number" class="form-control" name="kolicina[]" value="' + kolicina + '" >';
                    rowHtml += '</div>';
                    rowHtml += '<div class="col-md-2">';
                    rowHtml += '<a role="button" class="remove-row" href="#" style="color:red;"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">';
                    rowHtml += '<path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>';
                    rowHtml += '<path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>';
                    rowHtml += '</svg></a>';
                    rowHtml += '</div>';
                    rowHtml += '</div>';

                    // Dodajemo HTML u formu
                    newRowsDiv.insertAdjacentHTML('beforeend', rowHtml);             
                }
            });

            // Iteriramo kroz sastojke menua pojedinačni obroci
            data.meals.forEach(function(meal) {
                var parts = meal.split('-');
                var mealItem = null; // Resetiranje mealItem na početku svake iteracije
                if (parts.length === 2) {
                    var id_meal = +parts[0];
                    var porcija = parts[1];
                    mealItem = mealItems.find(function(item) {
                        return item.id === id_meal; // Promijenjena usporedba na ID
                    });
                }
                // Ako postoji mealItem, dodajemo HTML za prikaz sastojka u formi
                if (mealItem) {
                    var rowHtml = '<div class="row mb-3 align-items-center">';
                    rowHtml += '<div class="col-md-6">';
                    rowHtml += '<input type="text" class="form-control" name="obrok[]" value="' + mealItem.name + '" readonly>';
                    rowHtml += '<input type="hidden" class="form-control" name="identobrok[]" value="' + mealItem.id + '" >';
                    rowHtml += '</div>';
                    rowHtml += '<div class="col-md-4">';
                    rowHtml += '<input type="number" step="0.0001" class="form-control" name="porcija[]" value="' + porcija + '" >';
                    rowHtml += '</div>';
                    rowHtml += '<div class="col-md-2">';
                    rowHtml += '<a role="button" class="remove-row-meals" href="#" style="color:red;"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">';
                    rowHtml += '<path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>';
                    rowHtml += '<path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>';
                    rowHtml += '</svg></a>';
                    rowHtml += '</div>';
                    rowHtml += '</div>';

                    // Dodajemo HTML u formu
                    newRowsMealsDiv.insertAdjacentHTML('beforeend', rowHtml);             
                }
            });

            var infoHtml = '<div class="row"><div class="col"><h4><b>Total</b></h4>';
            infoHtml += '<p><span id="proteins">Proteins: ' + toFixedOrZero(data.proteins, 1) + 'g</span> ('+postotak(data.proteins,4,data.calories)+'%)<br>';
            infoHtml += '<span id="carbs">Carbs: ' + toFixedOrZero(data.carbs, 1) + 'g</span> ('+postotak(data.carbs,4,data.calories)+'%)<br>';
            infoHtml += '<span id="sugars">Sugars: ' + toFixedOrZero(data.sugars, 1) + 'g</span> ('+postotak(data.sugars,4,data.calories)+'%)<br>';
            infoHtml += '<span id="fibers">Fibers: ' + toFixedOrZero(data.fibers, 1) + 'g</span><br>';
            infoHtml += '<span id="fats">Fats: ' + toFixedOrZero(data.fats, 1) + 'g</span> ('+postotak(data.fats,9,data.calories)+'%)<br>';
            infoHtml += '<span id="saturated_fats">Saturated fats: ' + toFixedOrZero(data.saturated_fats, 1) + 'g</span> ('+postotak(data.saturated_fats,9,data.calories)+'%)<br>';
            infoHtml += '<b><span id="calories">Calories: ' + toFixedOrZero(data.calories, 1) + 'kcal</span></b></p></div></div>';
            totalInfoDiv.insertAdjacentHTML('beforeend', infoHtml);
            chartMacros(data.proteins, data.fats, data.carbs, data.calories);
          /*  energyData();
            proteinData();
            carbsData();
            fatsData();
            ratiosData(proteini, masti, ugh, kalorije); */
        } else {
            form.action = '{{ route('menus.store') }}';
        }
    })
    .catch(error => console.error('Error:', error)); 
}
function consumeData () {
    var masti = <?php echo json_encode($masti); ?>;
    var ugh = <?php echo json_encode($ugh); ?>;
    var proteini = <?php echo json_encode($proteini); ?>;
    var kalorije = <?php echo json_encode($kalorije); ?>;
            energyData();
            proteinData();
            carbsData();
            fatsData();
            ratiosData(proteini, masti, ugh, kalorije); 
}

document.addEventListener('DOMContentLoaded', consumeData);
document.addEventListener('DOMContentLoaded', initializePage);
/* brisanje starog retka namirnice */
document.addEventListener('DOMContentLoaded', function () {
    var newRowsDiv = document.getElementById('new-rows');
    var newRowsMealsDiv = document.getElementById('new-rows-meals');

    // Delegirajte click događaj na newRowsDiv
    newRowsDiv.addEventListener('click', function (event) {
        // Provjerite je li kliknuti element ili njegov roditelj ima klasu 'remove-row'
        if (event.target.classList.contains('remove-row') || event.target.closest('.remove-row')) {
            event.preventDefault(); // Spriječite zadanu radnju

            // Pronađite najbliži roditeljski element s klasom 'row' i uklonite ga
            var row = event.target.closest('.row');
            if (row) {
                row.remove();
            }
        }
    });

    // Delegirajte click događaj na newRowsMealsDiv
    newRowsMealsDiv.addEventListener('click', function (event) {
        // Provjerite je li kliknuti element ili njegov roditelj ima klasu 'remove-row-meals'
        if (event.target.classList.contains('remove-row-meals') || event.target.closest('.remove-row-meals')) {
            event.preventDefault(); // Spriječite zadanu radnju

            // Pronađite najbliži roditeljski element s klasom 'row' i uklonite ga
            var row = event.target.closest('.row');
            if (row) {
                row.remove();
            }
        }
    });
});
  
document.addEventListener('DOMContentLoaded', function () {
    var newRowsDiv = document.getElementById('new-rows');
    var newRowsMealsDiv = document.getElementById('new-rows-meals');
    var totalInfoDiv = document.getElementById('total-info');
    
    // Funkcija za ažuriranje ukupnih vrijednosti
    function updateTotalInfo() {
        var proteins = 0;
        var carbs = 0;
        var sugars = 0;
        var fibers = 0;
        var fats = 0;
        var saturated_fats = 0;
        var calories = 0;
        var foodItems = @json($foodItems);
        var mealItems = @json($mealItems);
        
        newRowsDiv.querySelectorAll('.row').forEach(function(row) {
            var namirnicaInput = row.querySelector('input[name="namirnica[]"]');
            var kolicinaInput = row.querySelector('input[name="kolicina[]"]');
            var identInput = row.querySelector('input[name="identifikacija[]"]');

            if (namirnicaInput && kolicinaInput) {
                var namirnica = namirnicaInput.value;
                var kolicina = parseFloat(kolicinaInput.value) || 0;
                var namirnica_id = +identInput.value;
                
                var foodItem = foodItems.find(function(item) {
                    return item.id === namirnica_id;
                });
                
                if (foodItem) {
                    proteins += foodItem.proteins * kolicina / 100;
                    carbs += foodItem.carbs * kolicina / 100;
                    sugars += foodItem.sugars * kolicina / 100;
                    fibers += foodItem.fibers * kolicina / 100;
                    fats += foodItem.fats * kolicina / 100;
                    saturated_fats += foodItem['saturated-fats'] * kolicina / 100;
                    calories += foodItem.calories * kolicina / 100;
                }
            }
        });

        newRowsMealsDiv.querySelectorAll('.row').forEach(function(row) {
            var obrokInput = row.querySelector('input[name="obrok[]"]');
            var porcijaInput = row.querySelector('input[name="porcija[]"]');
            var identobrokInput = row.querySelector('input[name="identobrok[]"]');
            
            if (obrokInput && porcijaInput) {
                var obrok = obrokInput.value;
                var porcija = parseFloat(porcijaInput.value) || 0;
                var obrok_id = +identobrokInput.value;
                
                var mealItem = mealItems.find(function(item) {
                    return item.id === obrok_id;
                });
                
                if (mealItem) {
                    proteins += mealItem.proteins * porcija;
                    carbs += mealItem.carbs * porcija;
                    sugars += mealItem.sugars * porcija;
                    fibers += mealItem.fibers * porcija;
                    fats += mealItem.fats * porcija;
                    saturated_fats += mealItem['saturated-fats'] * porcija;
                    calories += mealItem.calories * porcija;
                }
            }
        });
        
        var infoHtml = '<div class="row"><div class="col"><h4><b>Total:</b></h4>';
        infoHtml += '<p><span id="proteins">Proteins: ' + proteins.toFixed(1) + 'g</span> ('+postotak(proteins,4,calories)+'%)<br>';
        infoHtml += '<span id="carbs">Carbs: ' + carbs.toFixed(1) + 'g</span> ('+postotak(carbs,4,calories)+'%)<br>';
        infoHtml += '<span id="sugars">Sugars: ' + sugars.toFixed(1) + 'g</span> ('+postotak(sugars,4,calories)+'%)<br>';
        infoHtml += '<span id="fibers">Fibers: ' + fibers.toFixed(1) + 'g</span><br>';
        infoHtml += '<span id="fats">Fats: ' + fats.toFixed(1) + 'g</span> ('+postotak(fats,9,calories)+'%)<br>';
        infoHtml += '<span id="saturated_fats">Saturated_fats: ' + saturated_fats.toFixed(1) + 'g</span> ('+postotak(saturated_fats,9,calories)+'%)<br>';
        infoHtml += '<b><span id="calories">Calories: ' + calories.toFixed(1) + 'kcal</span></b></p></div></div>';
        
        totalInfoDiv.innerHTML = infoHtml;
    }
    
    // Event listener za promjene u input poljima unutar new-rows
    newRowsDiv.addEventListener('input', function (event) {
        if (event.target.matches('input[name="namirnica[]"], input[name="kolicina[]"]')) {
            updateTotalInfo();
        }
    });

    // Event listener za promjene u input poljima unutar new-rows-meals
    newRowsMealsDiv.addEventListener('input', function (event) {
        if (event.target.matches('input[name="obrok[]"], input[name="porcija[]"]')) {
            updateTotalInfo();
        }
    });

    // Delegirajte click događaj na newRowsDiv
    newRowsDiv.addEventListener('click', function (event) {
        // Provjerite je li kliknuti element ili njegov roditelj ima klasu 'remove-row'
        if (event.target.classList.contains('remove-row') || event.target.closest('.remove-row')) {
            event.preventDefault(); // Spriječite zadanu radnju

            // Pronađite najbliži roditeljski element s klasom 'row' i uklonite ga
            var row = event.target.closest('.row');
            if (row) {
                row.remove();
                updateTotalInfo();
            }
        }
    });
    
    // Delegirajte click događaj na newRowsMealsDiv
    newRowsMealsDiv.addEventListener('click', function (event) {
        // Provjerite je li kliknuti element ili njegov roditelj ima klasu 'remove-row-meal'
        if (event.target.classList.contains('remove-row-meal') || event.target.closest('.remove-row-meal')) {
            event.preventDefault(); // Spriječite zadanu radnju

            // Pronađite najbliži roditeljski element s klasom 'row' i uklonite ga
            var row = event.target.closest('.row');
            if (row) {
                row.remove();
                updateTotalInfo();
            }
        }
    });
});

</script>
@endsection

