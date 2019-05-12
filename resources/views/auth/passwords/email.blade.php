@extends('layouts.auth')

@php($crud = 'email')

@section('content')
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <form class="m-login__form m-form" action="{{ route('password.email') }}" method="POST">
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

        <div class="m-login__form-action">
            <button class="btn btn-primary m-btn m-btn--pill m-btn--custom m-btn--air" type="submit">{{__('base.buttons.submit')}}</button>&nbsp;&nbsp;

            <a href="{{ route('home') }}" class="btn btn-outline-primary m-btn m-btn--pill m-btn--custom">{{__('base.buttons.cancel')}}</a>
        </div>
    </form>
@endsection
