function errorMesssage(title, message) {
    sweetAlert(title, message, "error");
}

function successMessage(title, message) {
    swal(title, message, "success");
}

function confirmMessage(title, text, confirm, cancel, buttonDOM) {
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
            if (isConfirm) {
                var form = buttonDOM.parent('form');
                form.submit();
            } else {
                return false;
            }
        });
}
