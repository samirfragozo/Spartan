columnsDataTable = [
    {data: 'document'},
    {data: 'name'},
    {data: 'last_name'},
    {data: 'end'},
    {data: 'active', searchable: false, className: 'dt-center', customValue: true},
    {data: 'actions', searchable: false, className: 'dt-center', customValue: true},
];

/**
 * Custom value for status column
 *
 * @param {Number} column - The column number, starting on zero.
 * @param {String} value - The custom value.
 *
 * @returns {String} The HTML string with the status
 */
function getStatus(column, value) {
    if (column === 4) {
        return (value ? '<span class="m-badge m-badge--success">' : '<span class="m-badge m-badge--danger">') + Lang.get('base/base.enabled.' + value) + '</span>'
    } else if (column === 5) {
        let actions = '';

        if (value['active']) actions =  (
            '<a onclick="state(' + value['id'] + ',' + value['active'] + ')" class="m-portlet__nav-link btn m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--hover-danger" title="Desactivar">' +
                '<i class="fa fa-window-close"></i>' +
            '</a>'
        );
        else actions =  (
            '<a onclick="state(' + value['id'] + ',' + value['active'] + ')" class="m-portlet__nav-link btn m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--hover-success" title="Activar">' +
                '<i class="fa fa-check-square"></i>' +
            '</a>'
        );

        let _class = value['fingerprint'] ? 'm--font-brand' : '';

        actions += (
            '<a href="orion:@' + value['id'] + '@' + window.location.origin + '@' + value['id'] + '" class="m-portlet__nav-link btn m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--hover-primary" title="Huella">' +
                '<i class="fa fa-fingerprint ' + _class + '"></i>' +
            '</a>'
        );

        return actions;
    }
}