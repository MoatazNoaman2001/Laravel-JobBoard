<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - @yield('title')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        .rounded-lg {
            border-radius: 1rem;
        }
        .company-logo-preview {
            max-width: 150px;
            height: auto;
            display: none;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container-fluid">
        @auth
        <nav class="navbar navbar-light bg-light justify-content-between mx-4">
            <a class="navbar-brand" href="#">
                <img src="{{asset('images/user.png')}}" width="30" height="30" class="d-inline-block align-top" alt="">
                {{auth()->user()->name}}
            </a>
            <form method="GET" action="{{route('employer.logout')}}">
                @csrf
                <button type="submit" class="btn btn-outline-secondary">
                    Logout
                </button>
            </form>
        </nav>
        @endauth
        
        <main class="py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        @yield('content')
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<script>

</script>