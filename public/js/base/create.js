function active(id, active) {
    let formData = new FormData();
    let url = routes.active.url.replace(':id', id);

    formData.append('active', active);
    ajaxRequest(url, formData, routes.active.method, createRow, formPortlet);
}

function create() {
    resetForm();
    $('#form .form-group:first .form-control').focus();
    dataTable.rows().deselect();
}

function createRow(results) {
    if (results === undefined) results = {};

    if (table.length !== 0) dataTable.ajax.reload();

    if (form.length !== 0) {
        if (results.data) showEntity(results.data);
        else resetForm('creating');
    }

    if (results.message) showMessage(results.message, !!results.error);

    if (results.reload) location.reload();
}