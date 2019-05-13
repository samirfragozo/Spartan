const keys = {
        keys: [ 38 /* up */, 40 /* down */, ],
    },
    language = {
        'sProcessing':     'Procesando...',
        'sLengthMenu':     'Mostrar _MENU_ registros',
        'sZeroRecords':    'No se encontraron resultados',
        'sEmptyTable':     'Ningún dato disponible en esta tabla',
        'sInfo':           'Mostrando del _START_ al _END_ de _TOTAL_ registros',
        'sInfoEmpty':      'Mostrando del 0 al 0 de 0 registros',
        'sInfoFiltered':   '(filtrado de _MAX_ registros)',
        'sInfoPostFix':    '',
        'sSearch':         'Buscar:',
        'sUrl':            '',
        'sInfoThousands':  ',',
        'sLoadingRecords': 'Cargando...',
        'oPaginate': {
            'sFirst':    '<i class="la la-angle-double-left"></i>',
            'sLast':     '<i class="la la-angle-double-right"></i>',
            'sNext':     '<i class="la la-angle-right"></i>',
            'sPrevious': '<i class="la la-angle-left"></i>'
        },
        'select': {
            'rows': ''
        },
        'oAria': {
            'sSortAscending':  ': Activar para ordenar la columna de manera ascendente',
            'sSortDescending': ': Activar para ordenar la columna de manera descendente'
        }
    };

let hasAjax = table.hasClass('ajax'),
    columnsDataTable = [],
    customFilters = [],
    dataTable;

$(document).ready(function () {
    dataTable = table.DataTable(
        optionsDataTable(table)
    ).on('key-focus', function (e, table, cell) {
        keyFocus(e, table, cell);
        if (form.length !== 0) show(table.$('tr.selected').attr('id'));
    }).on('change', '.m-group-checkable', function(){
        let a = $(this).closest('table').find('td:first-child .m-checkable'),
            t = $(this).is(':checked');
        $(a).each(function() {
            t?($(this).prop('checked', !0), dataTable.rows($(this).closest('tr')).select()): ($(this).prop('checked', !1), dataTable.rows($(this).closest('tr')).deselect())
        })
    });

    selectFirstRow();
});

$('#search_filter').tagEditor({
    delimiter: ', ',
    placeholder: Lang.get('base/base.fields.search'),
    onChange: function(field, editor, tags) {
        if (tags.length) {
            if( tags.length > 1 ) {
                dataTable.search(tags.join(' ')).draw();
            } else {
                dataTable.search( tags[0] ).draw();
            }
        }
        else {
            dataTable.search('').draw(true);
        }
    }
});

function aoColumnDefs(currentDataTable) {
    let check = currentDataTable.find('th[name="check"]').length !== 0,
        enabled = currentDataTable.find('th[name="enabled"]').length !== 0,
        actions = currentDataTable.find('th[name="actions"]').length !== 0,
        aoColumnDefs = [];

    for(let i = 0; i < columnsDataTable.length; i++) {
        if (columnsDataTable[i].customValue) {
            aoColumnDefs.push({
                'aTargets': [i],
                'mData': i,
                'mRender': function (data) {
                    return getStatus(i, data);
                }
            });
        }
    }

    if (check) {
        aoColumnDefs.push({
            'orderable': false,
            'width': '6%',
            'targets': 0,
            'sClass': 'dt-center'
        })
    }

    if (enabled && actions) {
        aoColumnDefs.push(
            {
                'width': '6%',
                'targets': -2,
                'sClass': 'dt-center'
            },
            {
                'orderable': false,
                'width': '12%',
                'targets': -1,
                'sClass': 'dt-center'
            }
        )
    } else if (enabled) {
        aoColumnDefs.push({
            'width': '6%',
            'targets': -1,
            'sClass': 'dt-center'
        })
    } else if (actions) {
        aoColumnDefs.push({
            'orderable': false,
            'width': '12%',
            'targets': -1,
            'sClass': 'dt-center'
        })
    }

    return aoColumnDefs
}

function keyFocus(e, table, cell) {
    let row = table.row(cell.index().row);

    table.$('tr.selected').removeClass('selected');
    $(row.node()).addClass('selected');
    $(cell.node()).removeClass('focus');
}

function selectFirstRow() {
    if (dataTable.rows().count() > 0){
        let row = dataTable.row(':eq(0)', { page: 'current' });
        let id = row.id();
        row.select();
        if (form.length !== 0) show(id);
    }
}

function optionsDataTable(currentDataTable) {
    let ajax = currentDataTable.hasClass('ajax'),
        options = {
            'aoColumnDefs' : aoColumnDefs(currentDataTable),
            'dom' : 'tlip',
            'drawCallback' : function() {
                $('[data-toggle="m-popover"]').popover();
            },
            'language' : language,
            'order' : [],
            initComplete : function() {
                filters();
                showTable();
            },
            keys : keys,
            processing : true,
            responsive : true,
            select : {
                style : 'multi',
                selector : 'td:first-child .m-checkable'
            }
        };

    if (ajax) {
        options.ajax = routes['data'].url.replace(':filters', '');
        options.columns = columnsDataTable;
        options.serverSide = true;
        options.ordering = false;
        options.rowId = 'id';
    } else {
        options.buttons = [
            'excel',
            'pdf',
            'print'
        ]
    }

    return options;
}

function showTable(){
    $(".table-loader").addClass("m--hide");
    $(".table-component").removeClass("m--hide");
    if (dataTable) {
        selectFirstRow()
    }
}