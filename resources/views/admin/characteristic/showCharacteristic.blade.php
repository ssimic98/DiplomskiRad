@extends('layouts.admin')
@section('content')
<div class="container mt-1">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h1 class="h2">Karakteristike</h1>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCharacteristicModal">
            Dodaj
        </button>
        <div class="modal fade" id="addCharacteristicModal" tabindex="-1" aria-labelledby="addCharacteristicModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addCharacteristicModalLabel">Dodaj novu karakteristiku</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('admin.characteristic.storeCharacteristic') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="characteristic" class="form-label">Karakteristika</label>
                                <input type="text" name="characteristic" id="characteristic" value="{{old('characteristic')}}"class="form-control @error('characteristic') is-invalid @enderror"
                                    placeholder="Unesite naziv karakteristike" required>
                                @error('characteristic')
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
        <table class="table table-hover">
            <thead class="thead-light">
                <tr>
                    <th>ID</th>
                    <th>Karakteristika</th>
                    <th>Akcija</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($characteristics as $characteristic)
                    <tr>
                        <td>{{ $characteristic->id }}</td>
                        <td>{{ $characteristic->characteristic }}</td>
                        <td>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#editCharacteristicModal{{ $characteristic->id }}">
                                Uredi
                            </button>

                            <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                data-bs-target="#deleteModal{{ $characteristic->id }}">
                                Obriši
                            </button>

                            <div class="modal fade" id="editCharacteristicModal{{ $characteristic->id }}" tabindex="-1"
                                aria-labelledby="editCharacteristicModalLabel{{ $characteristic->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title"
                                                id="editCharacteristicModalLabel{{ $characteristic->id }}">Ažuriraj
                                                karakteristiku
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form
                                                action="{{ route('admin.characteristic.updateCharacteristic', $characteristic->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="mb-3">
                                                    <label for="characteristic" class="form-label">Pasmina</label>
                                                    <input type="text" name="characteristic" id="characteristic"
                                                        value="{{ $characteristic->characteristic }}"
                                                        class="form-control @error('characteristic') is-invalid @enderror"
                                                        required>

                                                    @error('characteristic')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <button type="submit" class="btn btn-primary">Spremi</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal fade" id="deleteModal{{ $characteristic->id }}" tabindex="-1"
                                aria-labelledby="deleteModalLabel{{ $characteristic->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteModalLabel{{ $characteristic->id }}">Potvrda
                                                brisanja
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Jeste li sigurani da želite obrisati ovu karakteristiku?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Otkaži</button>
                                            <form
                                                action="{{ route('admin.characteristic.deleteCharacteristic', $characteristic->id) }}"
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
@if ($errors->has('characteristic'))
    <script>
        window.onload = function()
        {
            var CharacteristicModal = new bootstrap.Modal(document.getElementById('addCharacteristicModal'));
            CharacteristicModal.show();
        }
    </script>
@endif
@endsection