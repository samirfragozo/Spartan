function appendMassive(formData) {
    $('.m-checkable:checked').each(function() {
        formData.append('massive[]', $(this).val());
    });

    return formData;
}

function changeStatus(status) {
    let formData = new FormData();

    formData.append('status', status.toString());
    formData = appendMassive(formData);
    ajaxRequest(routes.status.url, formData , routes.status.method, createRow, tablePortlet);
}

function openMassive(callback, parameters) {
    if ($('.m-checkable:checked').length > 0) {
        callback(parameters);
    } else {
        showMessage(Lang.get('base/base.messages.massive'), true);
    }
}