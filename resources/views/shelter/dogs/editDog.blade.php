@extends('layouts.shelter')
@section('content')
<div class="container d-flex justify-content-center align-items-center formEdit mt-2">
    <div class="row col-md-7">
        <div class="text-center my-1">
            <img src="{{ asset('images/dog-paw.jpg') }}" alt="Paw" class="img-fluid" style="max-width: 100px;">
            <h1 class="">Uredi psa</h1>
        </div>
        <form action="{{ route('shelter.dogs.updateDog', $dog->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row mb-1">
                <label for="poster" class="form-label">Slika psa</label>
                <input type="file" name="poster" id="poster" value="{{$dog->poster}}" class="form-control @error('poster') is-invalid @enderror"
                    required>
                @error('poster')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{$message}}</strong>
                    </span>
                @enderror
            </div>
            <div class="row mb-3">
                <label for="name" class="form-label">Ime</label>
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                    value="{{ $dog->name }}" required>
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{$message}}</strong>
                    </span>
                @enderror
            </div>
            <div class="row mb-3">
                <label for="breed_id" class="form-label">Pasmina</label>
                <select name="breed_id" id="breed_id" class="form-select" required>
                    @foreach($breeds as $breed)
                        <option value="{{ $breed->id }}" {{ $dog->breed_id == $breed->id ? 'selected' : '' }}>
                            {{ $breed->breed }}
                        </option>
                    @endforeach
                </select>
                @error('breed_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{$message}}</strong>
                    </span>
                @enderror
            </div>
            <div class="row mb-3">
                <label for="location" class="form-label">Mjesto</label>
                <input type="text" name="location" id="location"
                    class="form-control @error('location') is-invalid @enderror" value="{{ $dog->location }}" required>
                @error('location')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{$message}}</strong>
                    </span>
                @enderror
            </div>
            <div class="row mb-3">
                <label for="birth_date" class="form-label">Datum rođenja</label>
                <input type="date" class="form-control @error('poster') is-invalid @enderror" id="birth_date"
                    name="birth_date" value="{{ $dog->birth_date }}" required>
                @error('birth_date')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{$message}}</strong>
                    </span>
                @enderror
            </div>
            <div class="row mb-3">
                <label for="gender_id" class="form-label">Spol</label>
                <div id="gender_id">
                    @foreach($genders as $gender)
                        <div class="form-check">
                            <input type="radio" name="gender_id" value="{{ $gender->id }}" id="gender{{ $gender->id }}" {{ $dog->gender_id == $gender->id ? 'checked' : '' }} class="form-check-input">
                            <label for="gender{{ $gender->id }}" class="form-check-label">{{ $gender->gender }}</label>
                        </div>
                    @endforeach
                </div>
                @error('gender_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{$message}}</strong>
                    </span>
                @enderror
            </div>
            <div class="row mb-3">
                <label for="characteristics" class="form-label">Karakteristike psa</label>
                <div id="characteristics" class="characteristic-container">
                    @foreach ($characteristics as $characteristic)
                        <div class="form-check characteristic-item">
                            <input type="checkbox" name="characteristics[]" value="{{ $characteristic->id }}"
                                id="characteristic{{ $characteristic->id }}" {{ $dog->characteristics->contains($characteristic->id) ? 'checked' : '' }}
                                class="form-check-input @error('characteristics') is-invalid @enderror">

                            <label for="characteristic{{ $characteristic->id }}"
                                class="form-check-label">{{ $characteristic->characteristic }}</label>
                        </div>
                    @endforeach
                </div>
                    @error('characteristics')
                        <span class="invalid-feedback" style="display:inline;" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
            </div>
            <div class="row mb-3">
                <label for="health_statuses" class="form-label">Zdravstveni status</label>
                <div id="healthStatuses" class="health-status-container">
                    @foreach ($healthStatuses as $healthStatus)
                        <div class="form-check health-status-item">
                            <input type="checkbox" name="health_statuses[]" value="{{ $healthStatus->id }}"
                                id="healthStatus{{ $healthStatus->id }}" {{ $dog->healthstatuses->contains($healthStatus->id) ? 'checked' : '' }}
                                class="form-check-input @error('health_statuses') is-invalid @enderror">
                            <label for="healthStatus{{ $healthStatus->id }}"
                                class="form-check-label ">{{ $healthStatus->status }}</label>
                        </div>
                    @endforeach
                    
                    @error('health_statuses')
                        <div class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </div>
                    @enderror
                </div>
                @error('health_statuses')
                    <span class="invalid-feedback">
                        <strong>{{$message}}</strong>
                    </span>
                @enderror
            </div>
            <div class="row mb-3">
                <label for="is_adopted" class="form-label">Status udomljavanja</label>
                <select class="form-select" id="is_adopted" name="is_adopted">
                    <option value="0" {{ !$dog->is_adopted ? 'selected' : '' }}>Spreman za udomljavanje</option>
                    <option value="1" {{ $dog->is_adopted ? 'selected' : '' }}>Udomljen</option>
                </select>
            </div>
            <div class="row mb-3">
                <label for="description" class="form-label">Opis</label>
                <textarea class="form-control @error('description') is-invalid @enderror" id="description"
                    name="description" rows="3" required>{{ $dog->description }}</textarea>@error('description')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{$message}}</strong>
                        </span>
                    @enderror
            </div>

            <button type="submit" class="btn btn-primary mb-1 w-100">Ažuriraj</button>
        </form>
        <form action="{{ route('shelter.dogs.deleteDog', $dog->id) }}" method="POST" class="mt-3">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger w-100 mb-4"
                onclick="return confirm('Jeste li sigurni da želite obrisati psa?')">Obriši</button>
        </form>
    </div>
</div>
@endsection