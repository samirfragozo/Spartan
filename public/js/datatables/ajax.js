$(document).ready( function () {
    if (hasAjax) {
        let timeOut;

        table.on('preXhr.dt', function(e, settings, data){
            clearTimeout(timeOut);

            if(data.search.value === ''){
                mApp.blockPage({
                    overlayColor: '#000000',
                    type: 'loader',
                    message: 'Cargando...'
                });
            } else {
                timeOut = setTimeout(function() {
                    mApp.blockPage({
                        overlayColor: '#000000',
                        type: 'loader',
                        message: 'Cargando...'
                    });
                }, 1000);
            }
        }).on('xhr.dt', function(e, settings, data){
            clearTimeout(timeOut);
            mApp.unblockPage();
        });
    }
});