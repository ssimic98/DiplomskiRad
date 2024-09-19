@extends('layouts.admin')
@section('content')
<div class="container mt-1">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h1 class="h2">Spol</h1>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addGenderModal">
            Dodaj
        </button>
        <div class="modal fade" id="addGenderModal" tabindex="-1" aria-labelledby="addGenderModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addGenderModalLabel">Dodaj spol</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('admin.gender.storeGender') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="gender" class="form-label">Spol</label>
                                <input type="text" name="gender" id="gender"
                                    class="form-control @error('gender')is-invalid @enderror"
                                    placeholder="Unesite naziv spola" required value="{{old('gender')}}">
                                @error('gender')
                                    <div class="invalid-feedback" role="alert">
                                        <strong>{{$message}}</strong>
                                    </div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Dodaj</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table  table-hover">
            <thead class="thead-light">
                <tr>
                    <th>ID</th>
                    <th>Spol</th>
                    <th>Akcija</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($genders as $gender)
                    <tr>
                        <td>{{ $gender->id }}</td>
                        <td>{{ $gender->gender }}</td>
                        <td>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#editGenderModal{{ $gender->id }}">
                                Uredi
                            </button>

                            <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                data-bs-target="#deleteModal{{ $gender->id }}">
                                Obriši
                            </button>

                            <div class="modal fade" id="editGenderModal{{ $gender->id }}" tabindex="-1"
                                aria-labelledby="editGenderModalLabel{{ $gender->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editGenderModalLabel{{ $gender->id }}">Ažuriraj spol
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('admin.gender.updateGender', $gender->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="mb-3">
                                                    <label for="gender" class="form-label">Spol</label>
                                                    <input type="text" name="gender" id="gender"
                                                        value="{{ $gender->gender }}"
                                                        class="form-control @error('gender')is-invalid @enderror" required>
                                                    @error('gender')
                                                        <div class="invalid-feedback" role="alert">
                                                            <strong>{{$message}}</strong>
                                                        </div>
                                                    @enderror
                                                </div>
                                                <button type="submit" class="btn btn-primary">Spremi</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal fade" id="deleteModal{{ $gender->id }}" tabindex="-1"
                                aria-labelledby="deleteModalLabel{{ $gender->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteModalLabel{{ $gender->id }}">Potvrda brisanja
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Jeste li sigurni da želite obrisati ovaj spol?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Otkaži</button>
                                            <form action="{{ route('admin.gender.deleteGender', $gender->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Obriši</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@if ($errors->has('gender'))
    <script>
        window.onload = function(){
            var addGenderModal = new bootstrap.Modal(document.getElementById('addGenderModal'));
            addGenderModal.show();
        }

    </script>
@endif
@endsection