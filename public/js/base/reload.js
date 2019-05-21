let auto_reload_input = $('#auto_reload_input');
let auto_reload_switch = $('#auto_reload_switch');
let interval;

$(createInterval());

function createInterval () {
    clearInterval(interval);

    if(auto_reload_switch.is(':checked')) {
        interval = setInterval(() => {
            createRow();
        }, (auto_reload_input.val() * 1000));
    }
}

auto_reload_input.change(function () {
    let value = auto_reload_input.val();

    if (value > 60) auto_reload_input.val(60);
    else if (value < 3) auto_reload_input.val(3);

    createInterval();
});

auto_reload_switch.on('switchChange.bootstrapSwitch', createInterval);