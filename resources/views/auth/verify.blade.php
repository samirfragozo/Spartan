@extends('layouts.auth')

@php($crud = 'verify')

@section('content')
    @if (session('resent'))
        <div class="alert alert-success" role="alert">
            {{ __('A fresh verification link has been sent to your email address.') }}
        </div>
    @endif

    {{ __('Before proceeding, please check your email for a verification link.') }}
    {{ __('If you did not receive the email') }}, <a href="{{ route('verification.resend') }}">{{ __('click here to request another') }}</a>.

    <form class="m-login__form m-form" action="{{ route('logout') }}" method="POST">
        @csrf

        <div class="m-login__form-action">
            <button class="btn btn-primary m-btn m-btn--pill m-btn--custom m-btn--air" type="submit">{{ __('base.buttons.logout') }}</button>
        </div>
    </form>
@endsection
