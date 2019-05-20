@extends((!empty($form ?? []) and !empty($table ?? [])) ? 'layouts.crud': (!empty($table ?? []) ? 'layouts.table' : (!empty($form ?? []) ? 'layouts.form' : 'layouts.app')))

@section('title', $title)

@section('subtitle', $subtitle ?? null)

@section('subtitle_form', $subtitle_form ?? null)

@section('tools')
    @component('components.tools', [
        'crud' => $crud,
        'create' => $tools['create'] ?? false and !empty($form),
        'reload' => $tools['reload'] ?? false,
        'export' => $tools['export'] ?? false,
    ])@endcomponent
@endsection

@section('filters')
    @component('components.filters', [
        'crud' => $crud,
        'active' => $table['active'] ?? false,
        'fields' => $filters ?? [],
    ])@endcomponent
@endsection

@section('table')
    @component('components.table', [
        'check' => $table['check'] ?? false,
        'fields' => $table['fields'] ?? [],
        'active' => $table['active'] ?? false,
        'actions' => $table['actions'] ?? false,
    ])@endcomponent
@endsection

@section('form')
    @component('components.wizard', [
        'crud' => $crud,
        'edit' => $tools['edit'] ?? false,
        'fields' => $form ?? [],
    ])@endcomponent
@endsection

@push('scripts')
    @include('includes.scripts')
    @if ($tools['reload'])
        <script type="text/javascript" src="{{ asset('js/base/reload.js') }}" defer></script>
    @endif
    @if (file_exists('js/app/' . $crud . '.js'))
        <script type="text/javascript" src="{{ asset('js/app/' . $crud . '.js') }}" defer></script>
    @endif
@endpush