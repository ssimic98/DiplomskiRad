@extends('layouts.user')

@section('content')

    <h2 class="text-center mb-5">Favoriti</h2>
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
        @foreach ($favoritedogs as $favoritedog)
            <div class="col-md-4 mb-4">
                <div class="card position-relative">
                    <a href="" class="position-absolute top-0 end-0 p-3 favorite-icon" data-dog-id="{{ $favoritedog->id }}">
                            <i class="{{ $user->favoriteDogs->contains($favoritedog->id) ? 'fa-solid fa-heart' : 'fa-regular fa-heart' }} fa-2x"></i>
                        </a>
                    <img src="{{ asset('storage/' . $favoritedog->poster) }}" class="card-img-top" alt="{{ $favoritedog->name }}">
                    <div class="card-body">
                        <h5 class="card-title">Ime: {{ $favoritedog->name }}</h5>
                        <p class="card-text"> <i class="fas fa-paw"></i> <strong>Pasmina:</strong> {{ $favoritedog->breed->breed }}</p>
                        <p class="card-text"> <i class="fa-sharp fa-solid fa-location-dot"></i> <strong>Mjesto:</strong>  {{ $favoritedog->location }}</p>
                        <p class="card-text"> <i class="fa-solid fa-calendar-days"></i> <strong>Datum rođenja:</strong>  {{ $favoritedog->birth_date }}</p>
                        <p class="card-text"> <i class="fa-solid fa-venus-mars"></i> <strong>Spol:</strong> {{ $favoritedog->gender->gender }}</p>
                        @if (!$favoritedog->is_adopted)
                            <p  class="badge bg-warning" class="card-text"><strong>Status:</strong> Spreman za udomljavanje</p>
                            <div>
                            <a id="customButton" class="btn" type="button" href="{{ route('user.adoptionForm', $favoritedog->id) }}">Udomi me</a>

                                <a class="btn btn-danger" type="button" href="{{route('user.showDog', $favoritedog->id)}}">Dodatno</a>
                            </div>
                        @else
                            <p class="badge bg-success"><strong>Status:</strong>Udomljen</p>
                            <div>
                                
                            <a  id="customButton" class="btn btn btn-primary disabled" type="button" href="">Udomi me</a> 
                            </div>
                        @endif                                                                              
                       
                    </div>
                </div>
            </div>
        @endforeach
    </div></div>
@endsection

@push('scripts')
    <script src="{{ asset('js/favorite.js') }}"></script> 
    <script src="{{ asset('js/toastErrorShow.js') }}"></script> 
    <script src="{{ asset('js/toastSucessShow.js') }}"></script> 
@endpush
