@extends('adminlte::auth.auth-page', ['authType' => 'login'])

@php
    $loginUrl = View::getSection('login_url') ?? config('adminlte.login_url', 'login');

    if (config('adminlte.use_route_url', false)) {
        $loginUrl = $loginUrl ? route($loginUrl) : '';
    } else {
        $loginUrl = $loginUrl ? url($loginUrl) : '';
    }
@endphp

@section('auth_header', __('adminlte::adminlte.login_message'))

@section('adminlte_css_pre')
    <style>
        .icheck-primary.custom-checkbox {
            display: flex;
            align-items: center;
        }
        .icheck-primary.custom-checkbox input[type="checkbox"] {
            margin: 0 6px 0 0;
            vertical-align: middle;
            position: static;
            opacity: 1;
        }
        .icheck-primary.custom-checkbox label {
            margin-bottom: 0;
            font-weight: 400;
        }
    </style>
@stop

@section('auth_body')
    <form action="{{ $loginUrl }}" method="post">
        @csrf

        {{-- Email field --}}
        <div class="input-group mb-3">
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                value="{{ old('email') }}" placeholder="{{ __('adminlte::adminlte.email') }}" autofocus>

            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-envelope {{ config('adminlte.classes_auth_icon', '') }}"></span>
                </div>
            </div>

            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        {{-- Password field --}}
        <div class="input-group mb-3">
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                placeholder="{{ __('adminlte::adminlte.password') }}">

            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-lock {{ config('adminlte.classes_auth_icon', '') }}"></span>
                </div>
            </div>

            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        {{-- Login field --}}
        <div class="row">
            <div class="col-7">
                <div class="icheck-primary custom-checkbox">
                    <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                    <label for="remember">
                        {{ __('adminlte::adminlte.remember_me') }}
                    </label>
                </div>
            </div>

            <div class="col-5">
                <button type="submit" class="btn btn-block {{ config('adminlte.classes_auth_btn', 'btn-flat btn-primary') }}">
                    <span class="fas fa-sign-in-alt"></span>
                    {{ __('adminlte::adminlte.sign_in') }}
                </button>
            </div>
        </div>
    </form>
@stop