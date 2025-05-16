<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - @yield('title')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/style/app1.css') }}">

    
</head>
<body class="bg-white">
    <div class="container-fluid">
        @auth
        <nav class="navbar navbar-light navbar-custom justify-content-between mx-4 my-4 rounded-lg p-3">
            <a class="navbar-brand d-flex align-items-center text-dark fw-bold" href="#">
                <img src="{{ asset('images/user.png') }}" width="45" height="45" class="d-inline-block align-top me-3 rounded-circle" alt="">
                <span class="fs-5">{{ auth()->user()->name }}</span>
            </a>

            <div class="d-flex align-items-center">
                @if(auth()->user()->user_type == 'candidate')
                <div class="dropdown me-3">
                    <button class="btn btn-outline-primary btn-custom rounded-pill px-4 py-2 position-relative" type="button" id="notificationDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-bell"></i>
                        @if(auth()->user()->unreadNotifications->count())
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger badge-animate">
                            {{ auth()->user()->unreadNotifications->count() }}
                            <span class="visually-hidden">unread notifications</span>
                        </span>
                        @endif
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationDropdown" style="min-width: 320px; max-height: 450px; overflow-y: auto;">
                        @forelse(auth()->user()->unreadNotifications as $notification)
                        <li>
                            <a class="dropdown-item d-flex align-items-center text-dark py-3" href="{{ route('notifications.viewJob', $notification->data['job_id']) }}">
                                <i class="fas fa-info-circle text-primary me-3"></i>
                                <div>
                                    <p class="mb-0">{{ $notification->data['message'] }}</p>
                                    <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                </div>
                            </a>
                        </li>
                        @empty
                        <li><span class="dropdown-item text-center py-4 text-muted">No new notifications</span></li>
                        @endforelse
                    </ul>
                </div>
                @endif

                <form method="POST" action="{{ route('employer.logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-secondary btn-custom rounded-pill px-4 py-2">
                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                    </button>
                </form>
            </div>
        </nav>
        @endauth
        <main class="py-5">
    <div class="{{ (auth()->check() && auth()->user()->user_type == 'candidate') ? 'container w-90' : 'container w-60' }}">
        <div class="row justify-content-center">
            <div class="col-12">
                @yield('content')
            </div>
        </div>
    </div>
</main>


    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>