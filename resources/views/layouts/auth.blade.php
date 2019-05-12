@extends('layouts.base')

@section('title', __('base.titles.' . $crud))

@section('body')
    <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-grid--tablet-and-mobile m-grid--hor-tablet-and-mobile m-login m-login--1 m-login--signin">
        <div class="m-grid__item m-grid__item--order-tablet-and-mobile-2 m-login__aside">
            <div class="m-stack m-stack--hor m-stack--desktop">
                <div class="m-stack__item m-stack__item--fluid">
                    <div class="m-login__wrapper">
                        <div class="m-login__logo">
                            <a href="{{ route('home') }}">
                                @if(file_exists('img/logo.png'))
                                    <img src="{{ asset('img/logo.png') }}" alt="{{ config('app.name') }}">
                                @else
                                    <h1>{{ config('app.name') }}</h1>
                                @endif
                            </a>
                        </div>

                        <div class="m-login__signin">
                            <div class="m-login__head">
                                <h3 class="m-login__title">{{ __('base.titles.' . $crud) }}</h3>
                                <div class="m-login__desc">{{ __('base.subtitles.' . $crud) }}</div>
                            </div>

                            @yield('content')
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="m-grid__item m-grid__item--fluid m-grid m-grid--center m-grid--hor m-grid__item--order-tablet-and-mobile-1 m-login__content m-grid-item--center"
             style="background-image: url({{ asset('img/bg-auth.png') }})">
        </div>
    </div>
@endsection
