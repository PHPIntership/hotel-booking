/**
 * Check the file is an image before display preview
 */
$("#image").change(function() {
    var fileExtension = ['jpeg', 'jpg', 'png', 'gif', 'bmp'];
    if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
        alert("Only formats are allowed : " + fileExtension.join(', '));
    } else {
        readURL(this);
    }
});

/**
 * Preview the image
 */
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('.userpic')
                .attr('src', e.target.result);
        };

        reader.readAsDataURL(input.files[0]);
    }
}
