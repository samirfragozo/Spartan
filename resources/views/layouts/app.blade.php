@extends('layouts.base')

@section('body')
    @include('includes.header')

    <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">
        {{ (new App\Utils\Base())->menu() }}

        <div class="m-grid__item m-grid__item--fluid m-wrapper">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <div class="m-content m--padding-15">
                @yield('content')
            </div>
        </div>
    </div>

    @include('includes.footer')
@endsection
