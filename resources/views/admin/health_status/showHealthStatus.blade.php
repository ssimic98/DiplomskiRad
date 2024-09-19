@extends('layouts.admin')
@section('content')
<div class="container mt-1">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h1 class="h2">Pasmine</h1>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addHealthStatus">
            Dodaj
        </button>
        <div class="modal fade" id="addHealthStatus" tabindex="-1" aria-labelledby="addHealthStatusLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addHealthStatusLabel">Dodaj zdravstveni status</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('admin.health_status.storeHealthStatus') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="status" class="form-label">Zdravstveni status</label>
                                <input type="text" value="{{old('status')}}"name="status" id="status"
                                    class="form-control @error('status')is-invalid @enderror"
                                    placeholder="Unesite zdravstveni status" required>
                                @error('status')
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
                    <th>Zdravstveni status</th>
                    <th>Akcija</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($healthStatuses as $healthstatus)
                    <tr>
                        <td>{{ $healthstatus->id }}</td>
                        <td>{{ $healthstatus->status }}</td>
                        <td>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#editHealthStatus{{ $healthstatus->id }}">
                                Uredi
                            </button>

                            <button type="button" class="btn btn-danger " data-bs-toggle="modal"
                                data-bs-target="#deleteModal{{ $healthstatus->id }}">
                                Obriši
                            </button>

                            <div class="modal fade" id="editHealthStatus{{ $healthstatus->id }}" tabindex="-1"
                                aria-labelledby="editHealthStatusLabel{{ $healthstatus->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editHealthStatusLabel{{ $healthstatus->id }}">
                                                Ažuriraj
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form
                                                action="{{ route('admin.health_status.updateHealthStatus', $healthstatus->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="mb-3">
                                                    <label for="status" class="form-label">Pasmina</label>
                                                    <input type="text" name="status" id="status"
                                                        value="{{ $healthstatus->status }}"
                                                        class="form-control @error('status')is-invalid @enderror" required>
                                                    @error('status')
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

                            <div class="modal fade" id="deleteModal{{ $healthstatus->id }}" tabindex="-1"
                                aria-labelledby="deleteModalLabel{{ $healthstatus->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteModalLabel{{ $healthstatus->id }}">Potvrda
                                                brisanja
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Jeste li sigurani da želite obrisati ovaj zdravstveni status?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Otkaži</button>
                                            <form
                                                action="{{ route('admin.health_status.deleteHealthStatus', $healthstatus->id) }}"
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
@if ($errors->has('status'))
    <script>
        window.onload = function(){
            var addHealthStatus = new bootstrap.Modal(document.getElementById('addHealthStatus'));
            addHealthStatus.show();
        }

    </script>
@endif
@endsection