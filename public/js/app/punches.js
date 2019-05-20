columnsDataTable = [
    {data: 'date'},
    {data: 'client.full_name'},
];

$(function(){
    setInterval(() => {
        console.log('ok');
        createRow();
    }, 5000);
});