document.querySelector('.add-row').addEventListener('click', function(event) {
    event.preventDefault();

    const food = document.querySelector('#myfood-search').value;
    const quantity = document.querySelector('input[name="kolicina[]"]').value;
    const identifikacija = document.querySelector('#food-id').value;

    if (food && quantity) {
        const newRow = document.createElement('div');
        newRow.className = 'row mb-3 align-items-center';
        newRow.innerHTML = `
        
            <div class="col-md-6">
                <input type="text" class="form-control" name="namirnica[]" value="${food}" readonly>
                <input type="hidden" class="form-control " id="food-id" name="identifikacija[]" value="${identifikacija}">
                   
            </div>
            <div class="col-md-4">
                <input type="number" class="form-control" name="kolicina[]" value="${quantity}" >
            </div>
            <div class="col-md-2">
                <a role="button" class="remove-row" href="#" style="color:red;"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                  <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                  <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                </svg></a>
            </div>
        `;

        document.querySelector('#new-rows').appendChild(newRow);

        document.querySelector('#myfood-search').value = '';
        document.querySelector('input[name="kolicina[]"]').value = '';
        document.querySelector('#food-id').value = '';
        newRow.querySelector('.remove-row').addEventListener('click', function(event) {
            event.preventDefault();
            newRow.remove();
        });
    }
});
