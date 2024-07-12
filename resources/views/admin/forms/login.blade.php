@extends('admin.layouts.common-login')

@section('form-section')
    <div class="auth-form">
        <h4 class="text-center mb-4">Sign in your account</h4>
        @session('error')
            <div class="alert alert-danger text-light" role="alert">
                {{ session('error') }}
            </div>
        @endsession


        <form action="{{ route('admin.login') }}" method="POST">
            @csrf
            <div class="form-group">
                <label><strong>Email</strong></label>
                <input type="text"
                    class="form-control @error('email')
                   is-invalid
                @enderror"
                    name="email" placeholder="Enter valid email" value="{{ old('email') }}">
                @error('email')
                    <div class="invalid-feedback">

                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group">
                <label><strong>Password</strong></label>
                <input type="password"
                    class="form-control @error('password')
                    is-invalid
                @enderror"
                    name="password" placeholder="Enter password" value="{{ old('password') }}">
                @error('password')
                    <div class="invalid-feedback">

                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary btn-block">Sign me in</button>
            </div>
        </form>
        <div class="new-account mt-3">
            <p>Don't have an account? <a class="text-primary" href="{{ route('admin.load.register') }}">Sign up</a></p>
        </div>
    </div>
@endsection
