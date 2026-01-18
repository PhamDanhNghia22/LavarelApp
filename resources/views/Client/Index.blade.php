<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
     <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="{{asset('Client/css/bootstrap.min.css') }} " rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.css" />
    @vite(['resources/scss/style.scss','resources/js/app.js','resources/js/swiper.js'])
</head>

<body>
    <div class="container-xl-fluid">
        @include('Client.Shared.Header')
        <main class="py-5 px-3 ">
            @yield('Content')
        </main>

        @include('Client.Shared.Footer')
    </div>
    <script src="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.js"></script>

    <script src="{{ asset('Client/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('Client/js/jquery-3.7.1.min.js') }}"></script>
    @stack('scripts')
</body>

</html>