@extends('layouts.app')

@section('content')
<div class="container py-0 h-100">
    @if (session('message'))
    <div class="position-fixed top-0 end-0 p-3" style="z-index: 1050;">
        <div id="toastLoad" class="toast align-items-center border-1 custom-toast" role="alert" aria-live="assertive"
            aria-atomic="true">
            <div class="d-flex align-items-center">
                <div class="toast-icon me-2">
                    <i class="fas fa-paw fa-2x"></i>
                </div>
                <div class="custom-toast-body">
                    {{ session('message') }}
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
    @endif
    <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col col-xl-10 h-100">
            <div class="card h-100" style="border-radius: 1rem;">
                <div class="row g-0 h-100">
                    <div class="col-md-6 col-lg-6 img-container full-height">
                        <img src="{{asset('images/dogLoginPage.jpg')}}" alt="login form"
                            class="img-fluid full-height" />
                    </div>
                    <div class="col-md-6 col-lg-6 d-flex align-items-center">
                        <div class="card-body p-4 p-lg-5 text-black">
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="d-flex align-items-center mb-3 pb-1">
                                    <img src="{{asset('images/dogs-paws.jpg')}}" style="max-width: 50px;" alt="">
                                    <span class="h1">Udomi me</span>
                                </div>
                                <h2 class="mb-3 pb-3" style="letter-spacing: 1px;">Prijavi se</h2>
                                
                                <div class="row mb-3">
                                    <input id="email" type="email" class="form-control  @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                    <label class="form-label" for="email">Email</label>
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>Krivi email ili lozinka</strong>
                                    </span>
                                    @enderror
                                </div>
                                
                                <div class="row mb-3">
                                    <input id="password" type="password" class="form-control  @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                    <label class="form-label" for="password">Lozinka</label>
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>Krivi email ili lozinka</strong>
                                    </span>
                                    @enderror
                                </div>
                                
                                <div class="row mb-3"><div class="pt-1 mb-2">
                                <button id="customButton"type="submit" class="btn">{{ __('Prijava') }}</button>
                                </div>
                                    <div class="col-md-8">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="remember">
                                                {{ __('Zapamti me') }}
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                @if (Route::has('password.request'))
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('Zaboravio si lozinku?') }}
                                </a>
                                @endif

                                <p class="mb-5 pb-lg-2" style="color: #393f81;">Nemaš korisnički račun? <a href="{{ route('register') }}" style="color: #393f81;">Registriraj se</a></p>
                                
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var toastElement = document.getElementById('toastLoad');
        if (toastElement) {
            var toast = new bootstrap.Toast(toastElement, {
                delay: 5000
            });
            toast.show();
        }
    });
</script>
@endpush
