<!doctype html>
<html lang="5">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="Website Icon" type="png" href="{{asset('asset/clients/images/unnamed.png')}}">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{asset('asset/clients/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('asset/clients/css/style.css')}}">
    @yield('css')
</head>
<body>

<main class="py-0" >
        <div class="row ">
            <div class="col-2 container">
                @section('sidebar')
                    @include('admins.blocks.sidebar')
                @show
            </div>
            <div class="col-10 " id="content">
                @include('admins.blocks.header')
                @yield('content')
            </div>
        </div>
</main>

@include('admins.blocks.footer')
@include('sweetalert::alert')
</body>
<script src="{{asset('asset/clients/js/bootstrap.min.js')}}"></script>
<script src="{{asset('asset/clients/js/custom.js')}}"></script>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://unpkg.com/sweetalert2@7.18.0/dist/sweetalert2.all.js"></script>
<script src="{{asset('asset/clients/js/jquery.min.js')}}"></script>
<script src="{{asset('asset/clients/js/popper.js')}}"></script>
<script src="{{asset('asset/clients/js/bootstrap.min.js')}}"></script>
<script src="{{asset('asset/clients/js/main.js')}}"></script>
@yield('js')
@stack('scripts')
</html>
