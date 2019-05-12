@extends('layouts.auth')

@php($crud = 'login')

@section('content')
    <form class="m-login__form m-form" action="{{ route('login') }}" method="POST">
        @csrf

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
            <input id="password" name="password" type="password" class="form-control m-input @error('password') is-invalid @enderror" value="{{ old('password') }}" placeholder="{{ __('base.attributes.password') }}" autocomplete="current-password" required>

            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="row m-login__form-sub">
            <div class="col m--align-left">
                <label class="m-checkbox m-checkbox--primary">
                    <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>{{__('base.attributes.remember')}}
                    <span></span>
                </label>
            </div>

            @if (Route::has('password.request'))
                <div class="col m--align-right">
                    <a href="{{ route('password.request') }}" class="m-link">{{ __('base.buttons.forget_password') }}</a>
                </div>
            @endif
        </div>

        <div class="m-login__form-action">
            <button class="btn btn-primary m-btn m-btn--pill m-btn--custom m-btn--air" type="submit">{{ __('base.buttons.sign_in') }}</button>
        </div>
    </form>
@endsection
