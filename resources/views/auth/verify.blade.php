@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div id="headerCustom"class="card-header text-white text-center fs-4">
                    {{ __('Verificiraj svoj email račun.') }}
                </div>

                <div class="card-body custom-card-body text-center">
                    @if (session('message'))
                        <div class="position-fixed top-0 end-0 p-3" style="z-index: 1050;">
                            <div id="toastLoad" class="toast align-items-center border-0 custom-toast" role="alert" aria-live="assertive" aria-atomic="true">
                                <div class="d-flex align-items-center justify-content-between">
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

                    <div class="mb-4">
                        <i class="fas fa-paw fa-5x text-primary"></i>
                    </div>

                    <p class="fs-5 mb-4">
                        {{ __('Prije nego što nastavite, molim Vas da verificirate svoj račun.') }}
                    </p>
                    <p class="fs-5 mb-4">
                        {{ __('Ako niste zaprimili verifikacijsku poveznicu, kliknite opet.') }}
                    </p>
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button id="customButton"type="submit" class="btn">{{ __('Pritisni ovdje za ponovno slanje.') }}</button>
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
