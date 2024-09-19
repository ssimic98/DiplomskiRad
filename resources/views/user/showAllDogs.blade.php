@extends('layouts.user')

@section('content')
<h2 class="text-center mb-5">Prikaz svih pasa</h2>
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
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"
                        aria-label="Close"></button>
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
                        {{ session('error') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"
                        aria-label="Close"></button>
                </div>
            </div>
        </div>
    @endif  
    <form method="GET" action="{{ route('user.showAllDogs') }}">
        <div class="container">

            <div class="row">
                <div class="col-6 mb-3">
                    <button class="btn btn-secondary w-100" type="button" data-bs-toggle="collapse"
                        data-bs-target="#filter" aria-expanded="true">
                        Filtriraj opcije
                    </button>
                </div>
                <div class="col-6">
                    <button type="submit" class="btn btn-primary w-100">Filtriraj</button>
                </div>
            </div>


            <div class="collapse" id="filter">
                <div class="card card-body">

                    <div class="row">

                        <div class="col-md-6 col-lg-3 mb-3">
                            <label for="breed_id" class="form-label">Pasmina</label>
                            <select name="breed_id" id="breed_id" class="form-select">
                                <option value="">Sve pasmine</option>
                                @foreach ($breeds as $breed)
                                    <option value="{{ $breed->id }}">{{ $breed->breed }}</option>
                                @endforeach
                            </select>
                        </div>


                        <div class="col-md-6 col-lg-3 mb-3">
                            <label for="location" class="form-label">Mjesto</label>
                            <select name="location" id="location" class="form-select">
                                <option value="">Mjesto</option>
                                @foreach ($dogs->pluck('location')->unique() as $location)
                                    <option value="{{ $location }}">{{ $location }}</option>
                                @endforeach
                            </select>
                        </div>


                        <div class="col-md-6 col-lg-3 mb-3">
                            <label for="gender_id" class="form-label">Spol</label>
                            <select name="gender_id" id="gender_id" class="form-select">
                                <option value="">Spol</option>
                                @foreach ($genders as $gender)
                                    <option value="{{ $gender->id }}">{{ $gender->gender }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 col-lg-3 mb-3">
                            <label for="is_adopted" class="form-label">Status</label>
                            <select name="is_adopted" id="is_adopted" class="form-select">
                                <option value="">Status</option>
                                <option value="1">Udomljen</option>
                                <option value="0">Spreman za udomljavanje</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="characteristics" class="form-label">Karakteristike psa</label>
                            <div id="characteristics">
                                @foreach ($characteristics as $characteristic)
                                    <div class="form-check">
                                        <input type="checkbox" name="characteristics[]" value="{{ $characteristic->id }}"
                                            id="characteristic{{ $characteristic->id }}" {{ in_array($characteristic->id, request('characteristics', [])) ? 'checked' : '' }} class="form-check-input">
                                        <label for="characteristic{{ $characteristic->id }}"
                                            class="form-check-label">{{ $characteristic->characteristic }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="health_statuses" class="form-label">Zdravstveni status</label>
                            <div id="healthStatuse">
                                @foreach ($healthstatus as $healthStatus)
                                    <div class="form-check">
                                        <input type="checkbox" name="health_statuses[]" value="{{ $healthStatus->id }}"
                                            id="healthStatuse{{ $healthStatus->id }}" {{ in_array($healthStatus->id, request('health_statuses', [])) ? 'checked' : '' }} class="form-check-input">
                                        <label for="healthStatuse{{ $healthStatus->id }}"
                                            class="form-check-label">{{ $healthStatus->status }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="sort_by" class="form-label">Sortiraj po</label>
                            <select name="sort_by" id="sort_by" class="form-select">
                                <option value="">Odaberi...</option>
                                <option value="name" {{ request('sort_by') == 'name' ? 'selected' : '' }}>Ime</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="sort_direction" class="form-label">Smjer sortiranja</label>
                            <select name="sort_direction" id="sort_direction" class="form-select">
                                <option value="">Odaberi</option>
                                <option value="asc" {{ request('sort_direction') == 'asc' ? 'selected' : '' }}>Uzlazno
                                </option>
                                <option value="desc" {{ request('sort_direction') == 'desc' ? 'selected' : '' }}>Silazno
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>



    <div class="row">
        @if ($dogs->isEmpty())
            <div>Nema psa prema zadanim kriterijima</div>
        @else
            @foreach ($dogs as $dog)
                <div class="col-md-4 mb-4 mt-2">
                    <div class="card position-relative">
                        <a href="" class="position-absolute top-0 end-0 p-3 favorite-icon" data-dog-id="{{ $dog->id }}">
                            <i class="{{ $user->favoriteDogs->contains($dog->id) ? 'fa-solid fa-heart' : 'fa-regular fa-heart' }} fa-2x"></i>
                        </a>
                        <img src="{{ asset('storage/' . $dog->poster) }}" class="card-img-top img-fluid" alt="{{ $dog->name }}">
                        <div class="card-body">
                            <h5 class="card-title">Ime: {{ $dog->name }}</h5>
                            <p class="card-text"> <i class="fas fa-paw"></i> <strong>Pasmina:</strong> {{ $dog->breed->breed }}
                            </p>
                            <p class="card-text"> <i class="fa-sharp fa-solid fa-location-dot"></i> <strong>Mjesto:</strong>
                                {{ $dog->location }}</p>
                            <p class="card-text"> <i class="fa-solid fa-calendar-days"></i> <strong>Datum rođenja:</strong>
                                {{ $dog->birth_date }}</p>
                            <p class="card-text"> <i class="fa-solid fa-venus-mars"></i> <strong>Spol:</strong>
                                {{ $dog->gender->gender }}</p>
                            <p class="card-text"> <i class="fa-solid fa-user"></i> <strong>Azil: </strong>
                                {{ $dog->user->name }} {{ $dog->user->surname }}</p>
                            @if (!$dog->is_adopted)
                                <p class="badge bg-success"><strong>Status:</strong> Spreman za udomljavanje</p>
                                <div>
                                    <a id="customButton" class="btn" type="button"
                                        href="{{ route('user.adoptionForm', $dog->id) }}">Udomi me</a>
                                    <a class="btn btn-danger" type="button" href="{{ route('user.showDog', $dog->id) }}">Dodatno</a>
                                </div>
                            @else
                                <p class="badge bg-warning"><strong>Status:</strong> Udomljen</p>
                                <div>
                                    <button id="customButton" class="btn btn-primary disabled" type="button">Udomi me</button>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
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



