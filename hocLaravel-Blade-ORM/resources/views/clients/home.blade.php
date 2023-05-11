@extends('layouts.client')

@section('sidebar')
    @parent
    <h3>Home sidebar</h3>
@endsection

@section('title')
    {{$title}}
@endsection

@section('content')
    <div class="alert alert-{{session('type')}}">
        @if(session('msg'))
            {{session('msg')}}
        @endif
    </div>
    <section>
        <div class="container">
            <h1>Trang chủ</h1>
            @datetime("2021-12-15 15:00:30")
            @include('clients.contents.slide')
            @include('clients.contents.about')
            @datetime("2021-11-10 00:30:30")
        </div>
    </section>

    <x-alert type="info" :content="$message" data-icon="youtube"/>

{{--        <x-input.button />--}}

    {{--    <x-form.button />--}}
    <p><img src="https://live.staticflickr.com/7340/10238728426_7a3d614761_c.jpg" alt=""></p>
    <p><a href="{{route('download-image').'?image='.public_path('storage/DEMO _ DJI_0226A.jpg')}}"
          class="btn btn-primary">Download Img</a></p>
    <p><a href="{{route('download-pdf').'?pdf='.public_path('storage/demo.pdf')}}" class="btn btn-danger">Download
            Pdf</a></p>
@endsection


@section('css')
    <style>
        img {
            max-width: 100%;
            height: auto;
        }

    </style>
@endsection

@section('js')

@endsection
