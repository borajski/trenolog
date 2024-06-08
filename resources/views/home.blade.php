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
        $dates = [];
        $calories = [];

        $kalorije = 0;
        $proteini = 0;
        $ugh = 0;
        $masti = 0;

        foreach ($menus as $menu) {
            $dates[] = $menu->created_at->format('d-m-Y');
            $calories[] = $menu->calories;
            $kalorije += $menu->calories;
            $proteins[] = $menu->proteins;
            $proteini += $menu->proteins;
            $carbs[] = $menu->carbs;
            $ugh += $menu->carbs;
            $fats[] = $menu->fats;
            $masti += $menu->fats;
        }
        $kalorije = round($kalorije/8,1);
        $masti = round($masti/8,1);
        $proteini = round($proteini/8,1);
        $ugh = round($ugh/8,1);
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
                        <div class="col-md-6">
                            <label for="ingredients"><b>Single ingredients:</b></label>
                            <input type="text" class="form-control" placeholder="Food" id="food-search" name="namirnica[]">
                            <div class="search-results"></div>
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
                    <div id="new-rows"></div>
                    <!-- unos pojedinačnih obroka -->
                    <div class="row mb-3 align-items-center">
                        <div class="col-md-6">
                            <label for="ingredients"><b>Meals intake:</b></label>
                            <input type="text" class="form-control" placeholder="Meal" id="meal-search" name="obrok[]">
                            <div class="search-results-meals"></div>
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
    <p>Proteins: {{$proteini}}<br>
    Carbs: {{$ugh}}<br>
    Fats: {{$masti}}<br>
    <b>Calories: {{$kalorije}}</b>
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
    var masti = <?php echo json_encode($masti); ?>;
    var ugh = <?php echo json_encode($ugh); ?>;
    var proteini = <?php echo json_encode($proteini); ?>;
    var kalorije = <?php echo json_encode($kalorije); ?>;

    

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
                    rowHtml += '<input type="number" class="form-control" name="porcija[]" value="' + porcija + '" >';
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
            infoHtml += '<p><span id="proteins">Proteins: ' + toFixedOrZero(data.proteins, 1) + '</span><br>';
            infoHtml += '<span id="carbs">Carbs: ' + toFixedOrZero(data.carbs, 1) + '</span><br>';
            infoHtml += '<span id="sugars">Sugars: ' + toFixedOrZero(data.sugars, 1) + '</span><br>';
            infoHtml += '<span id="fibers">Fibers: ' + toFixedOrZero(data.fibers, 1) + '</span><br>';
            infoHtml += '<span id="fats">Fats: ' + toFixedOrZero(data.fats, 1) + '</span><br>';
            infoHtml += '<span id="saturated_fats">Saturated fats: ' + toFixedOrZero(data.saturated_fats, 1) + '</span><br>';
            infoHtml += '<b><span id="calories">Calories: ' + toFixedOrZero(data.calories, 1) + '</span></b></p></div></div>';
            totalInfoDiv.insertAdjacentHTML('beforeend', infoHtml);
            chartMacros(data.proteins, data.fats, data.carbs, data.calories);
            energyData();
            proteinData();
            carbsData();
            fatsData();
            ratiosData(proteini, masti, ugh, kalorije);
        } else {
            form.action = '{{ route('menus.store') }}';
        }
    })
    .catch(error => console.error('Error:', error)); 
}

document.addEventListener('DOMContentLoaded', initializePage);

</script>
@endsection

