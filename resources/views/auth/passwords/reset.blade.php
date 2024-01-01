@extends('layouts.public')
@section('content')

<h2 class="intro-x font-bold text-2xl xl:text-3xl text-center xl:text-left">
    Reset Password
</h2>
<div class="intro-x mt-2 text-slate-400 xl:hidden text-center">A few more clicks to sign in to your account. Manage all your e-commerce accounts in one place</div>
<form method="POST" action="{{ route('password.update') }}">
    @csrf
    <input type="hidden" name="token" value="{{ $token }}">
    <div class="intro-x mt-8">
        <input  class="intro-x login__input form-control py-3 px-4 block @error('email') is-invalid @enderror" placeholder="Email Address" type="email" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" readonly>
        @error('email')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
        <input type="password" class="intro-x login__input form-control py-3 px-4 block mt-4" placeholder="Password" name="password" required autofocus>
        @error('password')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror

        <input type="password" class="intro-x login__input form-control py-3 px-4 block mt-4" placeholder="Confirm Password" name="password_confirmation" required>
        
    </div>
    
    <div class="intro-x mt-5 xl:mt-8 text-center xl:text-left">
        <button class="btn btn-primary py-3 px-4 w-full xl:mr-3 align-top">{{ __('Reset Password') }}</button>
    </div>
</form>
@endsection
