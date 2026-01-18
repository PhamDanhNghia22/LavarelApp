<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('Admin/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('Admin/css/app.css') }}" />

    <style>
        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        .main,
        .sidebar {
            min-height: 100vh;
        }
    </style>
</head>

<body>
    
    <div class="wrapper">
        @include('Admin.Shared.Header')
        <div class="container-fluid main ">
            <span class="loader"></span>
            <div class="row">
                <div class="col-md-2 d-xl-flex d-none shadow boder-0  py-4 ">
                    @include('Admin.Shared.Sidebar')
                </div>
                <div class="col-md-10 col-12  py-4">
                    @yield('Content')
                </div>
            </div>
        </div>
        @include('Admin.Shared.Footer')
    </div>
    <script src="{{ asset('Admin/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('Admin/js/jquery-3.7.1.min.js') }}"></script>
    @stack('js')




</body>

</html>