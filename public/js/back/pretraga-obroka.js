/* search ajax my meals */
document.addEventListener('DOMContentLoaded', function() {
    var mealSearch = document.getElementById('meal-search');
    var searchResults = document.querySelector('.search-results-meals');
    var mealId = document.getElementById('meal-id');

    mealSearch.addEventListener('keyup', function() {
        var query = mealSearch.value;
        if (query.length > 0) {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', '/search-meal?query=' + encodeURIComponent(query), true);
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            xhr.onload = function() {
                if (xhr.status >= 200 && xhr.status < 400) {
                    var data = JSON.parse(xhr.responseText);
                    searchResults.innerHTML = '';
                    if (data.length > 0) {
                        data.forEach(function(meal) {
                            var resultDiv = document.createElement('div');
                            resultDiv.classList.add('search-result-item');

                            var mealName = document.createElement('span');
                            mealName.classList.add('search-result-name');
                            mealName.textContent = meal.name;

                            resultDiv.appendChild(mealName);
                            resultDiv.addEventListener('click', function() {
                                mealSearch.value = meal.name;
                                mealId.value = meal.id;
                                searchResults.innerHTML = '';
                            });

                            searchResults.appendChild(resultDiv);
                        });
                    } else {
                        var noResults = document.createElement('div');
                        noResults.classList.add('search-no-results');
                        noResults.textContent = 'No results found';
                        searchResults.appendChild(noResults);
                    }
                } else {
                    console.error('Server error: ', xhr.responseText);
                }
            };
            xhr.onerror = function() {
                console.error('Request error');
            };
            xhr.send();
        } else {
            searchResults.innerHTML = '';
        }
    });

    document.addEventListener('click', function(event) {
        if (!event.target.closest('#meal-search') && !event.target.closest('.search-results-meals')) {
            searchResults.innerHTML = '';
        }
    });
});
/* search ajax public meals - još nije definirano do kraja */
/*
document.addEventListener('DOMContentLoaded', function() {
    var mealSearch = document.getElementById('meal-search');
    var searchResults = document.querySelector('.search-results-meals');
     var mealId = document.getElementById('meal-id');
      mealSearch.addEventListener('keyup', function() {
        var query = mealSearch.value;
        if (query.length > 2) { // Počni pretraživanje nakon 3 unesena znaka
            var xhr = new XMLHttpRequest();
            xhr.open('GET', '/search-meal?query=' + encodeURIComponent(query), true);
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            xhr.onload = function() {
                if (xhr.status >= 200 && xhr.status < 400) {
                    var data = JSON.parse(xhr.responseText);
                    searchResults.innerHTML = '';
                    if (data.length > 0) {
                        data.forEach(function(meal) {
                            var div = document.createElement('div');
                            div.textContent = meal.name;
                            div.addEventListener('click', function() {
                                mealSearch.value = meal.name;
                               mealId.value = meal.id;
                                searchResults.innerHTML = '';
                            });
                            searchResults.appendChild(div);
                        });
                    } else {
                        var noResults = document.createElement('div');
                        noResults.textContent = 'No results found';
                        searchResults.appendChild(noResults);
                    }
                } else {
                    console.error('Server error: ', xhr.responseText);
                }
            };
            xhr.onerror = function() {
                console.error('Request error');
            };
            xhr.send();
        } else {
            searchResults.innerHTML = '';
        }
    });

    // Zatvori rezultate pretrage klikom bilo gdje izvan input polja
    document.addEventListener('click', function(event) {
        if (!event.target.closest('#meal-search') && !event.target.closest('.search-results-meal')) {
            searchResults.innerHTML = '';
        }
    });
}); */