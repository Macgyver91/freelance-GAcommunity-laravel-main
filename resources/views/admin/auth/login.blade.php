@extends('layouts.app')

@section('content')

    <div class="authincation h-100">
        <div class="container h-100">
            <div class="row justify-content-center vh-100 align-items-center">
                <div class="col-md-10">
                    <div class="authincation-content">
                        <div class="row no-gutters">
                            <div class="col-xl-6">
                                <div class="welcome-content">
                                    <div class="brand-logo">
                                        <a class="title-log" href="{{ route('home') }}">Greatness académie</a>
                                    </div>
                                    <h3 class="welcome-title">Bienvenue sur l’outil de gestion!</h3>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="auth-form">
                                    <h4 class="text-center mb-4">Admin Sign in</h4>
                                    <form action="{{ route('admin.login') }}" method="post">
                                        @csrf
                                        <div class="form-group">
                                            <label for="email"><strong>Email</strong></label>
                                            <input type="email" name="email" class="form-control"
                                                value="{{ old('email') }}" placeholder="Votre email">
                                            @error('email')
                                                <div class="text-danger">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="password"><strong>Password</strong></label>
                                            <input type="password" name="password" class="form-control"
                                                value="{{ old('password') }}" placeholder="Votre password">
                                            @error('password')
                                                <div class="text-danger">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-row d-flex justify-content-between mt-4 mb-2">
                                            <div class="form-group">
                                                <div class="form-check ml-2">
                                                    <input class="form-check-input" type="checkbox" id="basic_checkbox_1"
                                                        name="remember" {{ old('remember') ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="basic_checkbox_1">Remember
                                                        me</label>
                                                </div>
                                            </div>
                                            {{-- <div class="form-group">
                                            <a href="page-forgot-password.html">Forgot Password?</a>
                                        </div> --}}
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-block btn-primary">Sign me in</button>
                                        </div>
                                        @if (session('error'))
                                            <div class="alert alert-danger mt-2" role="alert">
                                                {{ session('error') }}
                                            </div>
                                        @endif
                                    </form>
                                    {{-- <div class="new-account mt-3">
                                    <p>Don't have an account? <a class="text-primary" href="./page-register.html">Sign up</a></p>
                                </div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection
