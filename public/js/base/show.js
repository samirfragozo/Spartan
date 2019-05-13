function show(id) {
    if (id !== 0) {
        let url = routes.show.url.replace(':id', id);
        ajaxRequest(url, null, routes.show.method, showEntity, formPortlet);
    } else create();
}

function showEntity(results) {
    resetForm('show', results['full_name']);

    if (results.picture) $('#preview').attr('src', results.picture);

    $.each(results, function(index, value) {
        let field = $('#' + index + '_form');

        if (field.prop('type') !== 'file'){
            field.val(value);
            if (field.prop('type') === 'checkbox') {
                if (field.hasClass('switch')) {
                    field.bootstrapSwitch('readonly', false);
                    if (value) {
                        field.bootstrapSwitch('state', true);
                    } else {
                        field.bootstrapSwitch('state', false);
                    }
                    field.bootstrapSwitch('readonly', true);
                } else {
                    if (value) {
                        field.prop('checked', true);
                    }
                }
            } else if (field.prop('type') === 'select-one') {
                field.selectpicker('refresh');
            }
        }
    });
}