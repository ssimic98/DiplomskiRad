@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div id="headerCustom"class="card-header text-white text-center fs-4">
                    {{ __('Resetiraj svoju lozinku.') }}
                </div>

                <div class="card-body">
                @if (session('status'))
                        <div class="position-fixed top-0 end-0 p-3" style="z-index: 1050;">
                            <div id="toastLoad" class="toast align-items-center border-0 custom-toast" role="alert" aria-live="assertive" aria-atomic="true">
                                <div class="d-flex align-items-center">
                                    <div class="toast-icon me-2">
                                        <i class="fas fa-paw fa-2x"></i>
                                    </div>
                                    <div class="custom-toast-body">
                                        Zahtjev za promjenom lozinke je poslan na Vašu email adresu.
                                    </div>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
                                </div>
                            </div>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="email" class="form-label col-md-4 col-form-label text-md-end">{{ __('Email adresa') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>Ovaj mail ne postoji ili nije ispravan.</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                            <button id="customButton"type="submit" class="btn">{{ __('Resetiraj lozinku.') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
    <script> document.addEventListener('DOMContentLoaded', function () {
    var toastElement = document.getElementById('toastLoad');
    if (toastElement) {
        var toast = new bootstrap.Toast(toastElement, {
            delay: 5000
        });
        toast.show();
    }
});</script>
@endpush
