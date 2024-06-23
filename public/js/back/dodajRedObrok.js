document.querySelector('.add-mealrow').addEventListener('click', function(event) {
    event.preventDefault();

    const meal = document.querySelector('#meal-search').value;
    const servings = document.querySelector('input[name="porcija[]"]').value;
    const identobrok = document.querySelector('#meal-id').value;

    if (meal && servings) {
        const newRow = document.createElement('div');
        newRow.className = 'row mb-3 align-items-center';
        newRow.innerHTML = `
        
            <div class="col-md-6">
                <input type="text" class="form-control" name="obrok[]" value="${meal}" readonly>
                <input type="hidden" class="form-control " id="meal-id" name="identobrok[]" value="${identobrok}">
                   
            </div>
            <div class="col-md-4">
                <input type="number" step="0.0001" class="form-control" name="porcija[]" value="${servings}" >
            </div>
            <div class="col-md-2">
                <a role="button" class="remove-mealrow" href="#" style="color:red;"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                  <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                  <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                </svg></a>
            </div>
        `;

        document.querySelector('#new-rows-meals').appendChild(newRow);

        document.querySelector('#meal-search').value = '';
        document.querySelector('input[name="porcija[]"]').value = '';
        document.querySelector('#meal-id').value = '';
        newRow.querySelector('.remove-mealrow').addEventListener('click', function(event) {
            event.preventDefault();
            newRow.remove();
        });
    }
});
