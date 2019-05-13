<div id="filters_general">
    <div class="row">
        <div class="form-group @if($active)col-md-8 @else col-12 @endif ">
            {{Form::text('search', null, [
                'id' => 'search_filter',
                'class' => 'form-control',
                'placeholder' => __('base.attributes.search'),
                'autofocus' => true
            ])}}
        </div>

        @if($active)
            <div class="form-group col-md-4">
                {{Form::select('active', __('base.filters'), null, [
                    'id' => 'active_filter',
                    'class' => 'form-control m-bootstrap-select m_selectpicker',
                    'data-live-search' => 'true'
                ])}}
            </div>
        @endif
    </div>
</div>
