@php($route = 'validation.attributes.')

@foreach($fields as $field)
    @php( $only_view = (isset($field['only-view']) and $field['only-view']) ?  ' only-view' : '')
    @if($field['type'] == 'button')
        <div class="form-group {{$size ?? 'col-12'}}">
            {{
                Form::button($field['text'] ?? __($route . $field['name']), [
                    'id' => $field['name'] . '_' . $suffix,
                    'class' => 'btn btn-primary btn-block',
                ])
            }}
        </div>
    @elseif($field['type'] == 'hidden')
        {{Form::hidden($field['name'], '0', ['id' => $field['name'] . '_' . $suffix])}}
    @elseif($field['type'] == 'picture')
        <div class="form-group col-12">
            <div class="m-card-profile">
                <div class="m-card-profile__pic">
                    <div class="m-card-profile__pic-wrapper" style="margin: 0; width: 150px; min-height: 150px;">
                        <img id="preview" style="min-width: 130px; min-height: 130px; max-width: 130px; max-height: 130px;" src="{{ $field['default'] }}">
                    </div>
                </div>
            </div>
            {{Form::file('picture', [
                'id' => $field['name'] . '_' . $suffix,
                'class' => 'form-control',
                'accept' => '.jpg,.jpeg'
            ])}}
        </div>
    @elseif($field['type'] == 'position')
        <div class="row">
            <div class="col-10">
                <div class="form-group col-12">
                    {{ Form::label('latitude_' . $suffix, __($route . 'latitude')) }}
                    {{
                        Form::text('latitude', null, [
                            'id' => 'latitude_' . $suffix,
                            'class' => 'form-control m-input only-view',
                            'autocomplete' => 'off'
                        ])
                    }}
                </div>
                <div class="form-group col-12">
                    {{ Form::label('longitude_' . $suffix, __($route . 'longitude')) }}
                    {{
                        Form::text('longitude', null, [
                            'id' => 'longitude_' . $suffix,
                            'class' => 'form-control m-input only-view',
                            'autocomplete' => 'off'
                        ])
                    }}
                </div>
            </div>
            <div class="col-2 d-flex align-items-center" style="padding: 0">
                <button type="button" onclick="getMarker()" class="m-portlet__nav-link btn m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--hover-danger" title="Ubicación">
                    <i class="fa fa-map-marker-alt"></i>
                </button>
            </div>
        </div>
    @elseif($field['type'] == 'section')
        <div class="form-group m-form__group {{$size ?? 'col-12'}}">
            <h5>{{ __($field['value']) }}</h5>
        </div>
    @else
        <div class="form-group m-form__group {{$size ?? 'col-12'}}">
            @php($text = $field['text'] ?? __($route . $field['name']))
            {{Form::label($field['name'] . '_' . $suffix, $text)}}
            @if($field['type'] == 'checkbox')
                <div class="m-checkbox-list">
                    @foreach($field['value'] as $value)
                        <label class="m-checkbox m-checkbox--solid m-checkbox--brand">
                            {{Form::checkbox($value, 1, false, ['id' => $value . '_' . $suffix])}}{{__($route . $value)}}<span></span>
                        </label>
                    @endforeach
                </div>
            @elseif($field['type'] == 'date')
                @if(isset($field['format']))
                    @php($format = $field['format'])
                @else
                    @php($format = 'datepicker')
                @endif
                {{Form::text($field['name'], null, [
                    'id' => $field['name'] . '_' . $suffix,
                    'class' => 'form-control ' . $format,
                    'data-provide' => 'datepicker',
                    'style' => 'width: 100%',
                    'autocomplete' => 'off'
                ])}}
            @elseif($field['type'] == 'datetime')
                <input name="{{ $field['name'] }}" class="form-control m-input{{ $only_view }}" type="datetime-local" value="{{ date("yyyy-MM-dd'T'HH:mm:ss") }}" id="{{ $field['name'] . '_' . $suffix }}">
            @elseif($field['type'] == 'file')
                {{Form::file($field['name'], [
                    'id' => $field['name'] . '_' . $suffix,
                    'class' => 'form-control',
                    'accept' => $field['accept'] ?? '.pdf'
                ])}}
            @elseif($field['type'] == 'radio')
                <div class="m-radio-list">
                    @foreach($field['value'] as $value)
                        <label class="m-radio m-radio--solid m-radio--brand">
                            {{Form::radio($value, 1, false, ['name' => $field['name'] . '_' . $suffix])}}{{__($route . $value)}}<span></span>
                        </label>
                    @endforeach
                </div>
            @elseif($field['type'] == 'select')
                {{Form::select($field['name'], __($field['value']), null, [
                    'id' => $field['name'] . '_' . $suffix,
                    'class' => 'form-control m-bootstrap-select m_selectpicker',
                    'placeholder' => __('base.placeholder'),
                    'data-live-search' => 'true'
                ])}}
            @elseif($field['type'] == 'select_reload')
                <div class="input-group">
                    {{Form::select($field['name'], isset($field['value']) ? $field['value'] : [], null, [
                        'id' => $field['name'] . '_' . $suffix,
                        'class' => 'form-control m-bootstrap-select m_selectpicker' . $only_view,
                        'placeholder' => __('base.placeholder'),
                        'data-live-search' => 'true'
                    ])}}
                    <div class="input-group-append">
                        {{Form::button('<i class="fa fa-circle-notch"></i>', [
                            'class' => 'btn btn-secondary select-reload',
                        ])}}
                    </div>
                </div>
            @elseif($field['type'] == 'switch')
                <div class="col-12">
                    {{Form::checkbox($field['name'], 1, false, [
                        'id' => $field['name'] . '_' . $suffix,
                        'class' => 'switch',
                        'data-switch' => 'true',
                        'data-size' => 'small',
                        'data-on-text' => 'Sí', 'data-off-text' => 'No',
                    ])}}
                </div>
            @elseif($field['type'] == 'text')
                {{Form::text($field['name'], null, [
                    'id' => $field['name'] . '_' . $suffix,
                    'class' => 'form-control m-input' . $only_view,
                    'autocomplete' => 'off'
                ])}}
            @elseif($field['type'] == 'textarea')
                {{Form::textarea($field['name'], null, [
                    'id' => $field['name'] . '_' . $suffix,
                    'class' => 'form-control m-input' . $only_view,
                    'rows' => '5',
                    'autocomplete' => 'off'
                ])}}
            @elseif($field['type'] == 'time')
                {{Form::time($field['name'], null, [
                    'id' => $field['name'] . '_' . $suffix,
                    'class' => 'form-control m-input' . $only_view,
                    'autocomplete' => 'off'
                ])}}
            @endif
        </div>
    @endif
@endforeach
