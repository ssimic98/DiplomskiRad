@extends('layouts.user')

@section('content')

<div class="container mt-5">
@if (session('message'))
        <div class="position-fixed top-0 end-0 p-3" style="z-index: 1050;">
            <div id="toastLoad" class="toast align-items-center border-0 custom-toast" role="alert" aria-live="assertive"
                aria-atomic="true">
                <div class="d-flex justify-content-between align-items-center">
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
    @if (session('error'))
        <div class="position-fixed top-0 end-0 p-3" style="z-index: 1050;">
            <div id="errorToast" class="toast align-items-center border-0 custom-toast" role="alert" aria-live="assertive"
                aria-atomic="true">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="toast-icon me-2">
                        <i class="fas fa-exclamation-triangle fa-2x"></i>
                    </div>
                    <div class="custom-toast-body">
                        {{session('error')}}
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        </div>
    @endif

    <div class="row">


        <div class="col-md-6">
            <div class="card mb-4 shadow-sm">
                <img src="{{ asset('storage/' . $dog->poster) }}" class="card-img-top img-fluid" alt="{{ $dog->name }}">
            </div>
        </div>


        <div class="col-md-6">
            
            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <h3 class="card-title text-center mb-4"> Ime: {{ $dog->name }}</h3>

                    <div class="mb-3">
                        <h5><i class="fas fa-paw"></i> Pasmina</h5>
                        <p class="card-text">{{ $dog->breed->breed }}</p>
                    </div>

                    <div class="mb-3">
                        <h5><i class="fa-sharp fa-solid fa-location-dot"></i> Mjesto</h5>
                        <p class="card-text">{{ $dog->location }}</p>
                    </div>

                    <div class="mb-3">
                        <h5><i class="fa-solid fa-calendar-days"></i> Datum rođenja</h5>
                        <p class="card-text">{{ $dog->birth_date }}</p>
                    </div>


                    <div class="mb-3">
                        <h5><i class="fa-solid fa-venus-mars"></i> Spol</h5>
                        <p class="card-text">{{ $dog->gender->gender }}</p>
                    </div>

                  
                    <div class="mb-3">
                        <h5><i class="fas fa-info-circle"></i> Karakteristike</h5>
                        <p class="card-text">
                            @forelse ($dog->characteristics as $characteristic)
                                {{ $characteristic->characteristic }}@if (!$loop->last), @endif
                            @empty
                                N/A
                            @endforelse
                        </p>
                    </div>

                    
                    <div class="mb-3">
                        <h5><i class="fas fa-info-circle"></i> Opis</h5>
                        <p class="card-text">
                                {{$dog->description}}
                        </p>
                    </div>

                    <div class="mb-3">
                        <h5><i class="fas fa-heartbeat"></i> Zdravstveni status</h5>
                        <p class="card-text">
                            @forelse($dog->healthstatuses as $healthstatus)
                                {{ $healthstatus->status }}@if (!$loop->last), @endif
                            @empty
                                N/A
                            @endforelse
                        </p>
                    </div>
                    <div class="mb-3">
                        <h5><i class="fa-solid fa-user"></i> Azil</h5>
                        <p class="card-text">
                                {{$dog->user->name}} {{$dog->user->surname}}
                        </p>
                    </div>
                    <div class="mb-3">
                        <h5><i class="fas fa-info-circle"></i> Status</h5>
                        <p class="card-text">
                            @if ($dog->is_adopted)
                                <span class="badge bg-success">Udomljen</span>
                            @else
                                <span class="badge bg-warning">Spreman za udomljavanje</span>
                            @endif
                        </p>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    @if (!$dog->is_adopted)
        <div class="text-center mt-4">
         <a id="customButton" class="btn"  type="button"  href="{{route('user.adoptionForm', $dog->id)}}">Udomi me</a>
        </div>
    @endif
</div>

@endsection
@push('scripts')
    <script src="{{ asset('js/favorite.js') }}"></script> 
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
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var toastElement = document.getElementById('errorToast');
        if (toastElement) {
            var toast = new bootstrap.Toast(toastElement, {
                delay: 5000
            });
            toast.show();
        }
    });
</script>
@endpush
