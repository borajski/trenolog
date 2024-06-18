/* search ajax public database*/

document.addEventListener('DOMContentLoaded', function() {
    var foodSearch = document.getElementById('food-search');
    var searchResults = document.querySelector('.search-results');
     var foodId = document.getElementById('food-id');
      foodSearch.addEventListener('keyup', function() {
        var query = foodSearch.value;
        if (query.length > 0) { // Počni pretraživanje nakon 3 unesena znaka
            var xhr = new XMLHttpRequest();
            xhr.open('GET', '/search-food?query=' + encodeURIComponent(query), true);
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            xhr.onload = function() {
                if (xhr.status >= 200 && xhr.status < 400) {
                    var data = JSON.parse(xhr.responseText);
                    searchResults.innerHTML = '';
                    if (data.length > 0) {
                        data.forEach(function(food) {
                            var div = document.createElement('div');
                            div.textContent = food.name;
                            div.addEventListener('click', function() {
                                foodSearch.value = food.name;
                               foodId.value = food.id;
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
        if (!event.target.closest('#food-search') && !event.target.closest('.search-results')) {
            searchResults.innerHTML = '';
        }
    });
});

/* search ajax my database */
document.addEventListener('DOMContentLoaded', function() {
    var foodSearch = document.getElementById('myfood-search');
    var searchResults = document.querySelector('.search-myresults');
     var foodId = document.getElementById('food-id');
      foodSearch.addEventListener('keyup', function() {
        var query = foodSearch.value;
        if (query.length > 0) { // Počni pretraživanje nakon 3 unesena znaka
            var xhr = new XMLHttpRequest();
            xhr.open('GET', '/search-myfood?query=' + encodeURIComponent(query), true);
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            xhr.onload = function() {
                if (xhr.status >= 200 && xhr.status < 400) {
                    var data = JSON.parse(xhr.responseText);
                    searchResults.innerHTML = '';
                    if (data.length > 0) {
                        data.forEach(function(food) {
                            var div = document.createElement('div');
                            div.textContent = food.name;
                            div.addEventListener('click', function() {
                                foodSearch.value = food.name;
                               foodId.value = food.id;
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
        if (!event.target.closest('#myfood-search') && !event.target.closest('.search-myresults')) {
            searchResults.innerHTML = '';
        }
    });
});