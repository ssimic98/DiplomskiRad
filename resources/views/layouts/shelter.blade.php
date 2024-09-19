<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'UdomiMe') }}</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{asset('css/styleEditdog.css')}}">
    </link>
    <link rel="stylesheet" href="{{asset('css/styleCreateSurvey.css')}}">
    <link rel="stylesheet" href="{{asset('css/styleShelter.css')}}">
    <link rel="stylesheet" href="{{asset('css/styleShowDogs.css')}}">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-custom shadow-sm">
            <div class="container">
                <a class="navbar-brand">
                    UdomiMe
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item dropdown">
                        <li class="nav-item">
                            <a href="{{ route('shelter.dogs.createDog') }}" class="nav-link">Dodaj novog psa</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('shelter.dogs.showDogs') }}" class="nav-link">Prikaži pse</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('shelter.dogs.adoptionsQuestionCreate') }}" class="nav-link">Stvori
                                obrazac</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('shelter.dogs.showAdoptionRequests')}}" class="nav-link">Zaprimljeni
                                zahtjevi</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('shelter.dogs.adoption')}}" class="nav-link">Prikaži obrazac</a>
                        </li>
                        @if (Auth::check() && Auth::user()->role==='shelter')
                        <li class="nav-item">
                            <a id="notificationsDropDown" class="nav-link dropdown-toggle" href="#" role="button"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell"></i>
                                <span class="badge badge-danger"> {{Auth::user()->unreadNotifications->count()}}</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropDown">
                            @if (Auth::user()->unreadNotifications->count())
                                <div class="d-flex justify-content-end mx-1 my-2">
                                    <a href="{{route('mark-as-read')}}" class="btn btn-success btn-sm">Označi sve pročitanim</a>
                                </div>
                            @endif
                                @foreach (Auth::user()->unreadNotifications as $notification)
                                    <a class="text-success dropdown-item"href="{{ $notification->data['url'] }}">
                                            {{ $notification->data['message'] }}
                                    </a>
                                @endforeach
                                @foreach (Auth::user()->readNotifications as $notification)
                                    <a class="text-secondary dropdown-item" href="{{ $notification->data['url'] }}">
                                            {{ $notification->data['message'] }}
                                    </a>
                                @endforeach
                            </div>
                        </li>
                        @endif
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} {{ Auth::user()->surname }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <main class="py-4">
            @yield('content')
        </main>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    @stack('scripts')
</body>

</html>