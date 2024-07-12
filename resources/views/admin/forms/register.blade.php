@extends('admin.layouts.common-login')

@section('form-section')
    <div class="auth-form">
        <h4 class="text-center mb-4">Register new account</h4>
        <form action="{{ route('admin.register') }}" method="POST">
            @csrf
            <div class="form-group">
                <label><strong>Name</strong></label>
                <input type="text"
                    class="form-control @error('name')
                    is-invalid
                @enderror"
                    name="name" placeholder="Enter full name" value="{{ old('name') }}">
                @error('name')
                    <div class="invalid-feedback">

                        {{ $message }}
                    </div>
                @enderror

            </div>
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
                    name="password" placeholder="Enter password" value="">
                @error('password')
                    <div class="invalid-feedback">

                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group">
                <label><strong>Confirm Password</strong></label>
                <input type="password"
                    class="form-control @error('password')
                    is-invalid
                @enderror"
                    name="password_confirmation" placeholder="Enter confirm password" value="">
                @error('password')
                    <div class="invalid-feedback">

                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary btn-block">Sign up</button>
            </div>
        </form>
        <div class="new-account mt-3">
            <p>Already have an account? <a class="text-primary" href="{{ route('admin.load.login') }}">Sign in</a></p>
        </div>
    </div>
@endsection
