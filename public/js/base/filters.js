function filters() {
    let active = table.find('th[name="active"]').length !== 0,
        actions = table.find('th[name="actions"]').length !== 0;

    if (active) {
        customFilters.push({
            'column': actions ? -2 : -1,
            'id': '#active_filter'
        });
    }

    for(let i = 0; i < customFilters.length; i++) {
        let c = customFilters[i].column;

        $(customFilters[i].id).on('change', function() {
            dataTable.column(c)
                .search($(this).val()).draw();
        });
    }
}
