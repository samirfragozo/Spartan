@extends('layouts.auth')

@php($crud = 'reset')

@section('content')
    <form class="m-login__form m-form" action="{{ route('password.update') }}" method="POST">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">

        <div class="form-group m-form__group">
            <label for="email"></label>
            <input id="email" name="email" type="email" class="form-control m-input @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="{{ __('base.attributes.email') }}" autocomplete="email" required autofocus>

            @error('email')
            <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group m-form__group">
            <label for="password"></label>
            <input id="password" name="password" type="password" class="form-control m-input @error('password') is-invalid @enderror" placeholder="{{ __('base.attributes.password') }}" autocomplete="new-password" required>

            @error('password')
            <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group m-form__group">
            <label for="password-confirm"></label>
            <input id="password-confirm" name="password_confirmation" type="password" class="form-control m-input m-login__form-input--last" placeholder="{{ __('base.attributes.password_confirmation') }}" autocomplete="new-password" required>
        </div>

        <div class="m-login__form-action">
            <button class="btn btn-primary m-btn m-btn--pill m-btn--custom m-btn--air" type="submit">{{__('base.buttons.submit')}}</button>&nbsp;&nbsp;

            <a href="{{ route('home') }}" class="btn btn-outline-primary m-btn m-btn--pill m-btn--custom">{{__('base.buttons.cancel')}}</a>
        </div>
    </form>
@endsection
