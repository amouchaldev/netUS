<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
        integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <title>@yield('title')</title>
    <style>
        body {
            min-height: 100vh;
        }

    </style>
    @yield('stylesheets')


 
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <script>
      
    </script>
</head>

<body class="d-flex flex-column justify-content-between">
    @include('layouts.navbar')
    @include('layouts.leftBar')
    @yield('profile')
    @yield('chat')

    <div class="container {{ Route::currentRouteName() != 'chat' ? 'py-4' : '' }}">
        @yield('content')
    </div>

    @include('layouts.footer')
 
  
    {{-- @vite(['resources/js/app.js']) --}}
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    @yield('javascripts')

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

</body>

</html>
