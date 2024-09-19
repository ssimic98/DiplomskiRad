@extends('layouts.admin')
@section('content')
<div class="container mt-1">
    <h1>Početna stranica</h1>
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Broj korisnika po rolama</h5>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="userRolesChart"></canvas>
                        </div>
                        <p class="mt-2">Korisnici sa rolom 'user': <strong>{{ $countUser['user'] }}</strong></p>
                        <p>Korisnici sa rolom 'shelter':  <strong>{{ $countUser['shelter'] }}</strong></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Ukupan broj pasa i udomljenih pasa</h5>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="dogsChart"></canvas>
                        </div>
                        <p class="mt-2">Ukupan broj pasa: <strong>{{ $totalDogs }}</strong></p>
                        <p>Broj udomljenih pasa: <strong>{{ $adoptedDogs }}</strong></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    const ctx1 = document.getElementById('userRolesChart').getContext('2d');
    console.log("User count:", {{ $countUser['user'] }});
    console.log("Shelter count:", {{ $countUser['shelter'] }});

    new Chart(ctx1, {
        type: 'bar',
        data: {
            labels: ['Korisnici', 'Azil'],
            datasets: [{
                label: 'Broj Korisnika',
                data: [{{ $countUser['user'] }}, {{ $countUser['shelter'] }}], 
                backgroundColor: ['#007bff', '#28a745'],
                borderColor: ['#0056b3', '#1e7e34'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        callback: function(value) {
                            if (Number.isInteger(value)) {
                                return value;
                            }
                        }
                    }
                }
            }
        }
    });

    const ctx2 = document.getElementById('dogsChart').getContext('2d');
    new Chart(ctx2, {
        type: 'doughnut',
        data: {
            labels: ['Ukupan broj pasa', 'Udomljeni psi'],
            datasets: [{
                label: 'Broj pasa',
                data: [{{ $totalDogs }}, {{ $adoptedDogs }}], 
                backgroundColor: ['#ffc107', '#28a745'],
                borderColor: ['#e0a800', '#1e7e34'],
                borderWidth: 1
            }]
        },
        options:
        {
            responsive: true,
            maintainAspectRatio: false,
        }
    });
</script>
```


@endsection