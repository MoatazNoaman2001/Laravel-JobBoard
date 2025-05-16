<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'JobBoard') }} - Admin</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    {{-- bootstrap library for migrate with application style --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/style/app1.css') }}">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Additional styles -->
    @stack('styles')
</head>
<body class="bg-gray-50 min-h-screen">
    <header>
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
    </header>

    <main class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded" role="alert">
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded" role="alert">
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <!-- Scripts -->
    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        });
    </script>
    
    @stack('scripts')
</body>
</html>