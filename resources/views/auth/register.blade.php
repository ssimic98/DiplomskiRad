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
                            <form method="POST" action="{{ route('register') }}">
                                @csrf
                                <div class="d-flex align-items-center mb-3 pb-1">
                                    <img src="{{asset('images/dogs-paws.jpg')}}" style="max-width: 50px;" alt="">
                                    <span class="h1">Udomi me</span>
                                </div>
                                <h2 id="register"class="register-form" style="letter-spacing: 1px;">Registriraj se</h2>
                                
                                <div class="row mb-0">
                                    <div class="col-md-6">
                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                        <label class="form-label" for="name">Ime</label>
                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{$message}}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <input id="surname" type="text" class="form-control @error('surname') is-invalid @enderror" name="surname" value="{{ old('surname') }}" required autocomplete="surname">
                                        <label class="form-label" for="surname">Prezime</label>
                                        @error('surname')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{$message}}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-0">
                                    <div class="col-md-6">
                                        <input id="city" type="text" class="form-control @error('city') is-invalid @enderror" name="city" value="{{ old('city') }}" required autocomplete="city">
                                        <label class="form-label" for="city">Mjesto</label>
                                        @error('city')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{$message}}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ old('address') }}" required autocomplete="address">
                                        <label class="form-label" for="address">Adresa</label>
                                        @error('address')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{$message}}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-0">
                                    <div class="col-md-12"><input id="email" type="email" class="form-control  @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                    <label class="form-label" for="email">Email adresa</label>
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{$message}}</strong>
                                    </span>
                                    @enderror
                                    
                                </div>

                                <!-- Lozinka i Potvrda Lozinke -->
                                <div class="row mb-0">
                                    <div class="col-md-6">
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                        <label class="form-label" for="password">Lozinka</label>
                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                        <label class="form-label" for="password-confirm">Potvrda lozinke</label>
                                    </div>
                                    
                                </div>
                                <div class="row mb-0">
                                    <div class="col-md-6">
                                        <select id="role" class="form-control @error('role') is-invalid @enderror" name="role" required>
                                            <option value="user">Korisnik</option>
                                            <option value="shelter">Azil</option>
                                        </select>
                                        <label class="form-label" for="role">Uloga</label>
                                        @error('role')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row mb-0"><div class="pt-1 mb-3">
                                <button id="customButton"type="submit" class="btn">{{ __('Registracija') }}</button>
                                
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
