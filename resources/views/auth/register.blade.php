@extends('layouts.app')

@section('content')
<div class="flex flex-dir-col justify-center flex-items-center vh-100 black-bg white-txt">
    <form method="POST" action="{{ route('register') }}" class="align-right">
        @csrf
        <h1 class="align-left"><span class="danger-txt">{{ config('app.name') }}</span> Register:</h1>
        <div class="mt-10">
            <label for="name" class="mr-5">{{ __('Name') }}</label>
            <input
            id="name"
            type="text"
            class="field w-256 @error('name') is-invalid @enderror"
            name="name"
            value="{{ old('name') }}"
            autocomplete="name"
            placeholder="..."
            required
            autofocus>

            @error('name')
            <div class="danger-txt my-5" role="alert">
                {{ $message }}
            </div>
            @enderror
        </div>

        <div class="mt-20">
            <label for="email" class="mr-5">E-Mail</label>
            <input
            id="email"
            type="email"
            class="field w-256 @error('email') is-invalid @enderror"
            name="email"
            value="{{ old('email') }}"
            autocomplete="email"
            placeholder="..."
            required
            autofocus>
            @error('email')
            <div class="danger-txt my-5" role="alert">
                {{ $message }}
            </div>
            @enderror
        </div>

        <div class="mt-20">
            <label for="password" class="mr-5">Password</label>
            <input
            id="password"
            type="password"
            class="field w-256 @error('password') is-invalid @enderror"
            name="password"
            autocomplete="current-password"
            placeholder="●●●●●"
            required>
            @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        <div class="my-20">
            <label for="password-confirm" class="mr-5">{{ __('Confirm Password') }}</label>

            <input
            id="password-confirm"
            type="password"
            class="field w-256"
            name="password_confirmation"
            autocomplete="new-password"
            placeholder="●●●●●"
            required>
        </div>
        <a class="dark-txt text-bold mr-10 hover-underline hover-danger-txt" href="{{ url('/login') }}">Login</a>
        <button type="submit" class="btn btn-lg danger-bg white-txt">{{ __('Register') }}</button>
    </form>
</div>
@endsection
