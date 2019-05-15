<div id="filters_general">
    <div class="row">
        <div class="form-group col-12">
            <div class="m-input-icon m-input-icon--left">
                {{Form::text('search', null, [
                    'id' => 'search_filter',
                    'class' => 'form-control m-input',
                    'placeholder' => __('validation.attributes.search'),
                    'autofocus' => true
                ])}}
                <span class="m-input-icon__icon m-input-icon__icon--left">
                    <span><i class="la la-search"></i></span>
                </span>
            </div>
        </div>
    </div>
</div>
