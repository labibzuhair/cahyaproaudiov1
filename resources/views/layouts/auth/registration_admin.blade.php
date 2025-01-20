@extends('layouts.auth.master')

@section('title', 'Registrasi Admin')

@section('content')
    <div class="container">
        <div class="frame">
            <div class="nav">
                <ul class="links">
                    <li class="signin-inactive"><a class="btn" href="{{ url('login') }}">Sign in</a></li>
                    <li class="signup-active"><a class="btn">Sign up</a></li>
                    <li class="signup-inactive"><a class="btn" href="{{ url('forgot') }}">Forgot</a></li>
                </ul>
            </div>

            <div>
                @include('layouts.auth._message')
                <form class="form-signin" action="{{ route('registration_post') }}" method="post">
                    @csrf
                    <label for="fullname">Nama Lengkap</label>
                    <input class="form-styling" type="text" name="name" placeholder="" value="{{ old('name') }}"
                        required />
                    <span style="color: red;">{{ $errors->first('name') }}</span>

                    <label for="email">Email</label>
                    <input class="form-styling" type="text" name="email" placeholder="" value="{{ old('email') }}"
                        required />
                    <span style="color: red;">{{ $errors->first('email') }}</span>

                    <label for="password">Password</label>
                    <input class="form-styling" type="password" name="password" placeholder="" required />
                    <span style="color: red;">{{ $errors->first('password') }}</span>

                    <label for="confirmpassword">Konfirmasi password</label>
                    <input class="form-styling" type="password" name="confirm_password" placeholder="" required />
                    <span style="color: red;">{{ $errors->first('confirm_password') }}</span>

                    {{-- <label for="is_role">Role</label>
                    <select class="form-styling" aria-label="Default select example" name="is_role" required>
                        <option selected>Pilih role anda</option>
                        <option {{ old('is_role') == 'admin' ? 'selected' : '' }} value="admin">Admin</option>
                        <option {{ old('is_role') == 'owner' ? 'selected' : '' }} value="owner">Owner</option>
                        <option {{ old('is_role') == 'customer' ? 'selected' : '' }} value="customer">Customer</option>
                    </select> --}}
                    <input type="hidden" name="is_role" value="admin">
                    <span style="color: red;">{{ $errors->first('is_role') }}</span>

                    <button type="submit" class="btn btn-primary btn-signup">Daftar</button>
                </form>
            </div>
        </div>

        <a id="refresh" value="Refresh" onClick="history.go()">
            <svg class="refreshicon" version="1.1" id="Capa_1" x="0px" y="0px" width="25px" height="25px"
                viewBox="0 0 322.447 322.447" style="enable-background:new 0 0 322.447 322.447;" xml:space="preserve">
                <path d="M321.832,230.327c-2.133-6.565-9.184-10.154-15.75-8.025l-16.254,5.281C299.785,206.991,305,184.347,305,161.224
                                                    c0-84.089-68.41-152.5-152.5-152.5C68.411,8.724,0,77.135,0,161.224s68.411,152.5,152.5,152.5c6.903,0,12.5-5.597,12.5-12.5
                                                    c0-6.902-5.597-12.5-12.5-12.5c-70.304,0-127.5-57.195-127.5-127.5c0-70.304,57.196-127.5,127.5-127.5
                                                    c70.305,0,127.5,57.196,127.5,127.5c0,19.372-4.371,38.337-12.723,55.568l-5.553-17.096c-2.133-6.564-9.186-10.156-15.75-8.025
                                                    c-6.566,2.134-10.16,9.186-8.027,15.751l14.74,45.368c1.715,5.283,6.615,8.642,11.885,8.642c1.279,0,2.582-0.198,3.865-0.614
                                                    l45.369-14.738C320.371,243.946,323.965,236.895,321.832,230.327z" />
            </svg>
        </a>
    </div>
@endsection
