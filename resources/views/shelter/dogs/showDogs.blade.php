@extends('layouts.shelter')

@section('content')

    <h2 class="text-center mb-5">Prikaz svih pasa</h2>

    <div class="container mt-5">
                    @if (session('message'))
                        <div class="position-fixed top-0 end-0 p-3" style="z-index: 1050;">
                            <div id="toastLoad" class="toast align-items-center border-0 custom-toast" role="alert" aria-live="assertive" aria-atomic="true">
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
        @foreach ($dogs as $dog)
            <div class="col-md-4 mb-4">
                <div class="card position-relative">
                    <a href="{{ route('shelter.dogs.editDog', $dog->id) }}" class="position-absolute top-0 end-0 p-3 favorite-icon">
                        <i class="fas fa-edit fa-2x"></i>
                    </a>
                    <img src="{{ asset('storage/' . $dog->poster) }}" class="card-img-top img-fluid" alt="{{ $dog->name }}">
                    <div class="card-body">
                        <h5 class="card-title">Ime: {{ $dog->name }}</h5>
                        <p class="card-text"><i class="fas fa-paw"></i> <strong>Pasmina: </strong> {{ $dog->breed->breed }}</p>
                        <p class="card-text"><i class="fa-sharp fa-solid fa-location-dot"></i> <strong>Mjesto: </strong>  {{ $dog->location }}</p>
                        <p class="card-text"><i class="fas fa-heartbeat"></i><strong>Zdravstveni status: </strong>
                            @forelse($dog->healthstatuses as $healthstatus)
                                {{ $healthstatus->status }}@if (!$loop->last),
                                @endif
                            @empty
                                N/A
                            @endforelse
                        </p>
                        <p class="card-text"><i class="fa-solid fa-calendar-days"></i> <strong>Datum rođenja: </strong>{{ $dog->birth_date }}</p>
                        <p class="card-text"><i class="fas fa-info-circle"></i> <strong>Opis: </strong>{{ $dog->description }}</p>
                        <p class="card-text"><i class="fas fa-info-circle"></i> <strong>Karakteristike: </strong>
                            @forelse ($dog->characteristics as $characteristic)
                                {{ $characteristic->characteristic }}@if (!$loop->last),
                                @endif
                            @empty
                                N/A
                            @endforelse
                        </p>
                        <p class="card-text"><i class="fa-solid fa-venus-mars"></i> <strong>Spol:</strong> {{ $dog->gender->gender }}</p>
                        @if ($dog->is_adopted)
                        <p  class="badge bg-success" class="card-text"><strong>Status:</strong> Udomljen</p>
                        @else
                        <p  class="badge bg-warning" class="card-text"><strong>Status:</strong> Spreman za udomljavanje</p>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
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
