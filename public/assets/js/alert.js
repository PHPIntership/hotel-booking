function errorMesssage(title, message) {
    sweetAlert(title, message, "error");
}

function successMessage(title, message) {
    swal(title, message, "success");
}

function confirmMessage(title, text, confirm, cancel) {
    swal({
            title: title,
            text: text,
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: confirm,
            cancelButtonText: cancel,
            closeOnConfirm: true
        },
        function(isConfirm) {
            return true;
        });
}
