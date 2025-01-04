@extends('layouts.auth.master')


@section('title', 'Reset Password')

@section('content')

    <div class="container">
        <div class="frame">
            <div class="nav">
                <ul class="links">
                    <li class="signin-active"><a class="btn">Reset Password</a></li>
                </ul>
            </div>

            <div ng-app ng-init="checked = false">
                <span style="color: red;">{{ $errors->first('password') }}</span>
                <span style="color: red;">{{ $errors->first('confirm_password') }}</span>
                @include('layouts.auth._message')
                <form class="form-signin" action="{{ route('reset_post', $token) }}" method="post">
                    @csrf
                    <label for="password">Password</label>
                    <input class="form-styling" type="password" name="password" placeholder="" required />
                    <label for="confirm_password">Confirm Password</label>
                    <input class="form-styling" type="password" name="confirm_password" placeholder="" required />
                    <button type="submit" class="btn btn-primary btn-signup">Reset Password</button>
                </form>
            </div>
            <div class="forgot">
                <a href="{{ url('login') }}">Back to Login</a>
            </div>
        </div>
    </div>
@endsection
