@if($reload)
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
