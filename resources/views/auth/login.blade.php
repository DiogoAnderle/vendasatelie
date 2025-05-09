@extends('layouts.app')

@section('content')
    <div class="container">
        @if (session('session_expired'))
            <div class="alert alert-warning">
                {{ session('session_expired') }}
            </div>
        @endif
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Login') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="row mb-3">
                                <label for="email"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Email') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Senha') }}</label>

                                <div class="col-md-6 position-relative">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="current-password">
                                    <i class="fas fa-eye position-absolute text-blue animate__animated " id="showPassord"
                                        style="top:25%; right:15px;"></i>

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6 offset-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                            {{ old('remember') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="remember">
                                            {{ __('Lembrar Me') }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Login') }}
                                    </button>

                                    @if (Route::has('password.request'))
                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                            {{ __('Esqueceu sua senha?') }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@section('scripts')
    <script>
        const passwordInput = $('#password')
        const showPasswordEye = $('#showPassord')
        showPasswordEye.click(function() {
            if (passwordInput.attr('type') == 'password') {
                passwordInput.attr('type', 'text')
                showPasswordEye.removeClass('fa-eye')
                showPasswordEye.removeClass('animate__fadeIn')
                setTimeout(() => {
                    showPasswordEye.addClass('fa-eye-slash')
                }, 3);
                setTimeout(() => {
                    showPasswordEye.addClass('animate__fadeIn')
                }, 3.5);


            } else {
                passwordInput.attr('type', 'password')
                showPasswordEye.removeClass('fa-eye-slash')
                showPasswordEye.removeClass('animate__fadeIn')
                setTimeout(() => {
                    showPasswordEye.addClass('fa-eye')
                }, 3);
                setTimeout(() => {
                    showPasswordEye.addClass('animate__fadeIn')
                }, 3.5);
            }


        })
    </script>
@endsection
@endsection
