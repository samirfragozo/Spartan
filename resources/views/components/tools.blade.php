@if($reload)
    <li class="m-portlet__nav-item">
        {{__('base.buttons.auto_reload')}}
    </li>
    <li class="m-portlet__nav-item">
        {{Form::checkbox('auto_reload_switch', 1, false, [
            'id' => 'auto_reload_switch',
            'class' => 'switch',
            'data-switch' => 'true',
            'data-on-text' => __('base.attributes.yes'), 'data-off-text' => __('base.attributes.no'),
        ])}}
    </li>
    <li class="m-portlet__nav-item" style="width: 100px">
        {{Form::number('auto_reload_input', 5, [
            'id' => 'auto_reload_input',
            'min' => 3,
            'max' => 60,
            'class' => 'form-control m-input',
        ])}}
    </li>
    <li class="m-portlet__nav-item">
        {{__('base.buttons.seconds')}}
    </li>
    <li class="m-portlet__nav-item">
        <a onclick="createRow()"
           data-toggle="m-tooltip" data-original-title="{{__('base.buttons.reload')}}"
           class="m-portlet__nav-link btn btn-lg btn-secondary m-btn m-btn--outline-2x m-btn--air m-btn--icon m-btn--icon-only m-btn--pill">
            <i class="fa fa-sync-alt m--font-brand"></i>
        </a>
    </li>
@endif

@if($export)
    <li class="m-portlet__nav-item">
        <a
            onclick="_download()"
            data-toggle="m-tooltip" data-original-title="{{__('base.buttons.export')}}"
            class="m-portlet__nav-link btn btn-lg btn-secondary m-btn m-btn--outline-2x m-btn--air m-btn--icon m-btn--icon-only m-btn--pill">
            <i class="fa fa-download m--font-brand"></i>
        </a>
    </li>
@endif

@if($create)
    <li class="m-portlet__nav-item">
        <a onclick="create()"
           data-toggle="m-tooltip" data-original-title="{{__('base.buttons.create')}}"
           class="m-portlet__nav-link btn btn-lg btn-secondary m-btn m-btn--outline-2x m-btn--air m-btn--icon m-btn--icon-only m-btn--pill">
            <i class="fa fa-plus m--font-brand"></i>
        </a>
    </li>
@endif
