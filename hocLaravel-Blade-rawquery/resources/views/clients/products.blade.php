@extends('layouts.client')
@section('content')
    @if(session('msg'))
        <div class="alert alert-success">
            {{session('msg')}}
        </div>
    @endif
    <h1>Trang San Pham</h1>

    @push('scripts')
        <script>
            console.log('Push lan 2');
        </script>
    @endpush
@endsection

{{--@section('sidebar')--}}
{{--    @parent--}}
{{--    <h3>Product sidebar</h3>--}}
{{--@endsection--}}

@section('title')
    {{$title}}
@endsection

@section('css')
    {{--    --}}
@endsection

@section('js')
    {{--    --}}
@endsection

@prepend('scripts')
    <script>
        console.log('Push lan 1');
    </script>
@endprepend
