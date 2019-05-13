@php
    $files = false;
    $numFields = 5;
    $valFields = array();
@endphp

@foreach($fields as $field)
    @if($field['type'] == 'checkbox')
        @php(array_push($valFields, count($field['value']) / 2))
    @elseif($field['type'] == 'file')
        @php(array_push($valFields, 1))
        @php($files = true)
    @elseif($field['type'] == 'hidden')
        @php(array_push($valFields, 0))
    @elseif($field['type'] == 'picture')
        @php(array_push($valFields, 3))
        @php($files = true)
    @elseif($field['type'] == 'textarea')
        @php(array_push($valFields, 2))
    @else
        @php(array_push($valFields, 1))
    @endif
@endforeach

@if($numFields == 1)
    @foreach (array_keys($valFields, 0) as $key)
        @unset($valFields[$key])
    @endforeach

    @php($steps = count($valFields))
@else
    @php($steps = ceil(array_sum($valFields) / $numFields))
@endif

@if($steps > 1)
    <div class="m-wizard m-wizard--2 m-wizard--brand" id="m_wizard">
        <div class="m-wizard__head" style="margin:2rem 0 0 0; padding: 0 2.2rem">
            <div class="m-wizard__progress">
                <div class="progress">
                    <div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>

            <div class="m-wizard__nav">
                <div class="m-wizard__steps">
                    @for($i = 1; $i <= $steps; $i++)
                        <div class="m-wizard__step @if($i == 1)m-wizard__step--current @endif" m-wizard-target="m_wizard_form_step_{{$i}}">
                            <a href="javascript:" class="m-wizard__step-number">
                                <span style="width: 3rem; height: 3rem; margin:-4.5rem auto 0 auto; color:#fff; font-weight:bold">{{$i}}</span>
                            </a>
                        </div>
                    @endfor
                </div>
            </div>
        </div>

        <div id="validations" class="m-portlet__padding-x m--hide">
            <div class="m-alert m-alert--outline alert alert-danger alert-dismissible fade show" role="alert">
                <strong>¡Alerta!</strong> Hay errores de validación en el formulario.
            </div>
        </div>

        <div class="m-wizard__form">
            {{Form::open(['class' => 'm-form', 'id' => 'form', 'files' => $files])}}

            {{Form::hidden('id', '0', ['id' => 'id_form'])}}

            <div class="m-portlet__body m--padding-10">
                @php($start = 0)
                @php($end = $numFields)

                @for($i = 1; $i <= $steps; $i++)
                    <div class="m-wizard__form-step @if($i == 1)m-wizard__form-step--current @endif" id="m_wizard_form_step_{{$i}}">
                        <div class="m-form__section m-form__section--first">
                            @php($stepFields = array_slice($valFields, $start, $end, true))

                            @while (array_sum($stepFields) > $numFields)
                                @if($end > 1)
                                    @php($stepFields = array_slice($valFields, $start, --$end, true))
                                @else
                                    @php($end = 1)
                                    @break
                                @endif
                            @endwhile

                            @component('components.fields', [
                                'crud' => $crud,
                                'fields' => array_slice($fields, $start, $end),
                                'suffix' => 'form'
                            ])@endcomponent

                            @php($start += $end)
                            @php($end = $numFields)
                        </div>
                    </div>
                @endfor
            </div>

            <div class="m-portlet__foot m-portlet__foot--fit">
                <div class="m-form__actions m-form__actions" style="padding: 15px;">
                    <div class="row align-items-center">
                        <div class="col-lg-8 m--align-left">
                            {{Form::button(__('base.buttons.create'), ['id' => 'formButton', 'class' => 'btn btn-primary', 'data-action' => 'create'])}}

                            {{Form::button(__('base.buttons.cancel'), ['id' => 'formReset', 'class' => 'btn btn-secondary'])}}
                        </div>

                        <div class="col-lg-4 m--align-right">
                            {{Form::button('<i class="fa fa-chevron-left"></i><span></span>', ['class' => 'btn btn-secondary', 'data-wizard-action' => 'prev'])}}

                            {{Form::button('<span></span><i class="fa fa-chevron-right"></i>', ['class' => 'btn btn-secondary', 'data-wizard-action' => 'next'])}}
                        </div>
                    </div>
                </div>
            </div>

            {{Form::close()}}
        </div>
    </div>
@else
    <div class="m-portlet__body m--padding-10">
        {{ Form::open(['id' => 'form', 'files' => $files]) }}

        {{ Form::hidden('id', '0', ['id' => 'id_form']) }}

        @component('components.fields', [
            'crud' => $crud,
            'fields' => $fields,
            'suffix' => 'form'
        ])@endcomponent

        {{ Form::close() }}
    </div>

    <div class="m-portlet__foot">
        <div class="row align-items-center">
            <div class="col-lg-12">
                {{ Form::button(__('base.buttons.create'), ['id' => 'formButton', 'class' => 'btn btn-primary', 'data-action' => 'create']) }}

                {{ Form::button(__('base.buttons.cancel'), ['id' => 'formReset', 'class' => 'btn btn-secondary']) }}
            </div>
        </div>
    </div>
@endif
