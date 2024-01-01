@extends('layouts.public')
@section('content')


<h2 class="intro-x font-bold text-2xl xl:text-3xl text-center xl:text-left">
    Reset Password
</h2>
@if (session('status'))
<div class="alert alert-success" role="alert">
    {{ session('status') }}
</div>
@endif
<!-- <div class="intro-x mt-2 text-slate-400 xl:hidden text-center">A few more clicks to sign in to your account. Manage all your e-commerce accounts in one place</div> -->
<form method="POST" action="{{ route('password.email') }}">
    @csrf
    <div class="intro-x mt-8">
        <input  class="intro-x login__input form-control py-3 px-4 block @error('email') is-invalid @enderror" placeholder="Email Address" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
        @error('email')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror

    </div>

    <div class="intro-x mt-5 xl:mt-8 text-center xl:text-left">
        <button class="btn btn-primary py-3 px-4 w-full xl:mr-3 align-top" type="submit">{{ __('Send Password Reset Link') }}</button>
    </div>
</form>
@endsection
