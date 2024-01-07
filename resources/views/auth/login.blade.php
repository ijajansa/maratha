@extends('layouts.public')
@section('content')
<div class="card card-bordered" style="border:none;">
    <div class="card-inner card-inner-lg">
        <div class="nk-block-head">
            <div class="nk-block-head-content">
                <h4 class="nk-block-title text-center">तुमच्या खात्यात प्रवेश करण्यासाठी लॉग इन करा</h4>

            </div>
        </div>
        <form action="{{ route('login') }}" method="post">
            @csrf
            <div class="form-group">
                <div class="form-label-group">
                    <label class="form-label" for="default-01">{{ __('ई-मेल') }}</label>
                </div>
                <div class="form-control-wrap">
                 <input name="email" type="email" placeholder="Email Address" id="default-01" class="form-control form-control-md @error('email') is-invalid @enderror" value="{{ old('email') }}" required="">
                 @error('email')
                 <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="form-group">
            <div class="form-label-group">
                <label class="form-label" for="password">{{ __('पासवर्ड ') }}</label>

            </div>
            <div class="form-control-wrap">
                <a href="#" class="form-icon form-icon-right passcode-switch lg" data-target="password">
                    <em class="passcode-icon icon-show icon ni ni-eye"></em>
                    <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                </a>

                <input id="password" name="password" type="password" placeholder="Password" class="form-control form-control-md form-control-lglock-input @error('password') is-invalid @enderror" required="">
                @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="form-group">
            <button class="btn btn-lg btn-primary btn-block">लॉगिन करा</button>
        </div>
    </form>

</div>
</div>


@endsection
