@extends('layouts.back_layouts.back-master')
@section('css_before')
<meta name="csrf-token" content="{{ csrf_token() }}">
 <link rel="stylesheet" href="{{asset('css/calendar.css?v=').time()}}">
 <link rel="stylesheet" href="{{asset('css/pretraga.css?v=').time()}}">
@endsection
@section('content')
<div class="container">
<h2 class="p-4">Menu maker</h2>
<div class="row">
<div class="col-md-6">
<div class="calendar">
      <div class="calendar-header">
        <span class="month-picker" id="month-picker"> May </span>
        <div class="year-picker" id="year-picker">
          <span class="year-change" id="pre-year">
            <pre><</pre>
          </span>
          <span id="year">2020 </span>
          <span class="year-change" id="next-year">
            <pre>></pre>
          </span>
        </div>
      </div>
      <div class="calendar-body">
        <div class="calendar-week-days">
          <div>Sun</div>
          <div>Mon</div>
          <div>Tue</div>
          <div>Wed</div>
          <div>Thu</div>
          <div>Fri</div>
          <div>Sat</div>
        </div>
        <div class="calendar-days">
        </div>
      </div>
      <div class="calendar-footer">
      </div>
      <!--
      <div class="date-time-formate">
        <div class="day-text-formate">TODAY</div>
        <div class="date-time-value">
          <div class="time-formate">01:41:20</div>
          <div class="date-formate">03 - march - 2022</div>
        </div>
      </div> -->
      <div class="month-list"></div>
    </div>
</div>
<div class="col-md-6">
<div class="daily-menu"></div>
<div id="noviUnos" style="display:none;">
 <!-- form start -->
 <form  method="POST" id="unos-forma">
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
   <div class="row  mb-3 align-items-center"> 
   <div class="col-md-6">     
                    <label for="ingredients"><b>Single ingredients:</b></label>               
                    <input type="text" class="form-control" placeholder="Food" id="food-search" name="namirnica[]">
                    <div class="search-results"></div>
                </div>
                <div class="col-md-4 ">
                    <input type="number" class="form-control" placeholder="Quantity (g)" name="kolicina[]">
                    <input type="hidden" class="form-control " id="food-id" name="identifikacija[]"> 
                  </div>
                <div class="col-md-2">
                    <a role="button" class="add-row" href="#"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
  <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
  <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
</svg></a>
                </div>
</div> <!-- kraj unosa namirnica -->
<div id="new-rows"></div>
<!--unos pojedinačnih obroka -->
<div class="row  mb-3 align-items-center"> 
   <div class="col-md-6">     
                    <label for="ingredients"><b>Meals intake:</b></label>               
                    <input type="text" class="form-control" placeholder="Meal" id="meal-search" name="obrok[]">
                    <div class="search-results-meals"></div>
                </div>
                <div class="col-md-4">
                    <input type="number" class="form-control" placeholder="Servings (n)" name="porcija[]">
                    <input type="hidden" class="form-control " id="meal-id" name="identobrok[]"> 
                  </div>
                <div class="col-md-2">
                    <a role="button" class="add-mealrow" href="#"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
  <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
  <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
</svg></a>
                </div>
</div>
<!--kraj unosa obroka-->
<div id="new-rows-meals"></div>
<div class="text-end pt-3 pb-2">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
</form>
<div id="total-info"></div>
</div>

</div>

</div>
</div>
@endsection
@section('js_after')
<script src="{{ asset('js/back/pretraga-ajax.js') }}"></script>
<script src="{{ asset('js/back/pretraga-obroka.js') }}"></script>
<script src="{{ asset('js/back/dodajRed.js') }}"></script>
<script src="{{ asset('js/back/dodajRedObrok.js') }}"></script>
<script>
    const isLeapYear = (year) => {
  return (
    (year % 4 === 0 && year % 100 !== 0 && year % 400 !== 0) ||
    (year % 100 === 0 && year % 400 === 0)
  );
};
const getFebDays = (year) => {
  return isLeapYear(year) ? 29 : 28;
};
let calendar = document.querySelector('.calendar');
const month_names = [
    'January',
    'February',
    'March',
    'April',
    'May',
    'June',
    'July',
    'August',
    'September',
    'October',
    'November',
    'December',
  ];
let month_picker = document.querySelector('#month-picker');
const dayTextFormate = document.querySelector('.day-text-formate');
const timeFormate = document.querySelector('.time-formate');
const dateFormate = document.querySelector('.date-formate');
const dailyMenuDiv = document.querySelector('.daily-menu');

month_picker.onclick = () => {
  month_list.classList.remove('hideonce');
  month_list.classList.remove('hide');
  month_list.classList.add('show');
  dayTextFormate.classList.remove('showtime');
  dayTextFormate.classList.add('hidetime');
  timeFormate.classList.remove('showtime');
  timeFormate.classList.add('hideTime');
  dateFormate.classList.remove('showtime');
  dateFormate.classList.add('hideTime');
};

const generateCalendar = (month, year) => {
  let calendar_days = document.querySelector('.calendar-days');
  calendar_days.innerHTML = '';
  let calendar_header_year = document.querySelector('#year');
  let days_of_month = [
      31,
      getFebDays(year),
      31,
      30,
      31,
      30,
      31,
      31,
      30,
      31,
      30,
      31,
    ];

  let currentDate = new Date();

  month_picker.innerHTML = month_names[month];

  calendar_header_year.innerHTML = year;

  let first_day = new Date(year, month);


  for (let i = 0; i <= days_of_month[month] + first_day.getDay() - 1; i++) {

    let day = document.createElement('div');

    if (i >= first_day.getDay()) {
      let date = i - first_day.getDay() + 1;
      day.innerHTML = date;

      // Add click event listener to each date cell
      day.addEventListener('click', function() {
        const selectedDateString = `${month_names[month]} ${date}, ${year}`;
        const selectedDate = new Date(selectedDateString);
        const today = new Date();
        today.setHours(0, 0, 0, 0);    
              // Dohvatite mjesec, dan i godinu iz selectedDate
        const selectedMonth = selectedDate.getMonth() + 1; // Dodajte 1 jer je getMonth() 0-indeksiran
        const selectedDay = selectedDate.getDate();
        const selectedYear = selectedDate.getFullYear();    
        // Formatirajte datum kao string "MM/DD/YYYY"
       const formattedDate = `${selectedDay}/${selectedMonth}/${selectedYear}`;  

          dailyMenuDiv.innerHTML = '<h4>Menu</h4>';
          document.getElementById('date').value = formattedDate;
          if (document.getElementById('noviUnos').style.display == "none")
            document.getElementById('noviUnos').style.display = "block";
        
            var data = { date: formattedDate };
            var form = document.getElementById('unos-forma');
            var newRowsDiv = document.getElementById('new-rows');
            var newRowsMealsDiv = document.getElementById('new-rows-meals');
            var totalInfoDiv = document.getElementById('total-info');
            newRowsDiv.innerHTML = '';
            newRowsMealsDiv.innerHTML = '';
            totalInfoDiv.innerHTML = '';
        
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
    var proteins = 0;
    var carbs = 0;
    var fats = 0;
    var calories = 0;
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



    var infoHtml = '<div class="row"><div class="col"><h4>Total</h4>';
    infoHtml += '<p><span id="proteins">Proteins: '+data.proteins+'</span><br>';
    infoHtml += '<span id="carbs">Carbs: '+data.carbs+'</span><br>';
    infoHtml += '<span id="fats">Fats: '+data.fats+'</span><br>';
    infoHtml += '<span id="calories">Calories: '+data.calories+'</span></p></div></div>';
    totalInfoDiv.insertAdjacentHTML('beforeend', infoHtml);
} else {
    form.action = '{{ route('menus.store') }}';
}

    })
    .catch(error => console.error('Error:', error));
    
  
});

      if (date === currentDate.getDate() &&
        year === currentDate.getFullYear() &&
        month === currentDate.getMonth()
      ) {
        day.classList.add('current-date');
      }
    }
    calendar_days.appendChild(day);
  }
};

let month_list = calendar.querySelector('.month-list');
month_names.forEach((e, index) => {
  let month = document.createElement('div');
  month.innerHTML = `<div>${e}</div>`;

  month_list.append(month);
  month.onclick = () => {
    currentMonth.value = index;
    generateCalendar(currentMonth.value, currentYear.value);
    month_list.classList.replace('show', 'hide');
    dayTextFormate.classList.remove('hideTime');
    dayTextFormate.classList.add('showtime');
    timeFormate.classList.remove('hideTime');
    timeFormate.classList.add('showtime');
    dateFormate.classList.remove('hideTime');
    dateFormate.classList.add('showtime');
  };
});

(function() {
  month_list.classList.add('hideonce');
})();
document.querySelector('#pre-year').onclick = () => {
  --currentYear.value;
  generateCalendar(currentMonth.value, currentYear.value);
};
document.querySelector('#next-year').onclick = () => {
  ++currentYear.value;
  generateCalendar(currentMonth.value, currentYear.value);
};

let currentDate = new Date();
let currentMonth = { value: currentDate.getMonth() };
let currentYear = { value: currentDate.getFullYear() };
generateCalendar(currentMonth.value, currentYear.value);

const todayShowTime = document.querySelector('.time-formate');
const todayShowDate = document.querySelector('.date-formate');
/*
const currshowDate = new Date();
const showCurrentDateOption = {
  year: 'numeric',
  month: 'long',
  day: 'numeric',
  weekday: 'long',
};
const currentDateFormate = new Intl.DateTimeFormat(
  'en-US',
  showCurrentDateOption
).format(currshowDate);
todayShowDate.textContent = currentDateFormate;
setInterval(() => {
  const timer = new Date();
  const option = {
    hour: 'numeric',
    minute: 'numeric',
    second: 'numeric',
  };
  const formateTimer = new Intl.DateTimeFormat('en-us', option).format(timer);
  let time = `${`${timer.getHours()}`.padStart(
      2,
      '0'
    )}:${`${timer.getMinutes()}`.padStart(
      2,
      '0'
    )}: ${`${timer.getSeconds()}`.padStart(2, '0')}`;
  todayShowTime.textContent = formateTimer;
}, 1000);  
*/
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
        var fats = 0;
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
                    fats += foodItem.fats * kolicina / 100;
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
                    fats += mealItem.fats * porcija;
                    calories += mealItem.calories * porcija;
                }
            }
        });
        
        var infoHtml = '<div class="row"><div class="col"><h4>Total</h4>';
        infoHtml += '<p><span id="proteins">Proteins: ' + proteins.toFixed(2) + '</span><br>';
        infoHtml += '<span id="carbs">Carbs: ' + carbs.toFixed(2) + '</span><br>';
        infoHtml += '<span id="fats">Fats: ' + fats.toFixed(2) + '</span><br>';
        infoHtml += '<span id="calories">Calories: ' + calories.toFixed(2) + '</span></p></div></div>';
        
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