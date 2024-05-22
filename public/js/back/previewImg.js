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