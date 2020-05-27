function loading(message) {
    swal({
        title: '',
        text: message,
        timer: 0,
        onOpen: function () {
            swal.showLoading();
        },
        customClass: 'loading',
        allowOutsideClick: false
    });
}

function loadingClose() {
    swal.close();
}

function alertDialog(message, type, redirect) {
    switch (type) {
        case 'error':
        case 'warning':
            swal({
                type: 'error',
                title: false,
                text: message,
                showCloseButton: true
            }).then(() => {
                if (redirect !== undefined) {
                    window.location.href = redirect;
                }
            });
            break;

        case 'success':
            swal({
                type: 'success',
                title: message,
                showCloseButton: true
            }).then(() => {
                if (redirect !== undefined) {
                    window.location.href = redirect;
                }
            });
            break;

        default:
            swal({
                type: 'info',
                title: message,
                showCloseButton: true
            }).then(() => {
                if (redirect !== undefined) {
                    window.location.href = redirect;
                }
            });
            break;
    }
}