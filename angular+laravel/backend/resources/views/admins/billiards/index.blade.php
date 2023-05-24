@extends('layouts.admin')
@section('title')
    {{$title}}
@endsection
@section('css')
    <style>
        .col-4 {
            height: 140px;
            width: 30%;
            /*background: #20c997;*/
        }

        h1 {
            text-align: center;
            margin-top: 5px;
            margin-bottom: 5px;
        }

        .a {
            margin-left: 30px
        }

        .tableName {
            text-decoration: none;
            color: inherit;
        }
    </style>
@endsection
@section('content')
    <div class="row">
        <h1 class="bg-success">{{$title}}</h1>
    </div>
    <hr class="m-0">
    <br>
    <div class="row d-flex text-center">
        <div class=" col-2">
            <div class="">
                <a class="btn btn-primary">Khu vuc 1</a>
                <a class="btn btn-primary">Khu vuc 2</a>
            </div>

        </div>
        <div class=" col-8">
            <div class="row justify-content-center">
                @if(count($billiards) > 0)
                    @foreach($billiards as $key => $value)
                        <div class="col-4 me-1 mb-1"
                             style="background: {{$value->status == 0 ? 'gray' : '#20c997' }}; border-radius: 10px">
                            <div>
                                <div>
                                    <a class="tableName" href="">
                                        <h4 class="mt-2">Bàn số: {{$key + 1}}</h4>
                                    </a>
                                </div>
                                <hr>
                                <div class="text-align-center">
                                    @if($value->status == 0)
                                        <a href="{{route('billiard.get-table',['id' => $value->id])}}"
                                           class="btn btn-outline-light">Bắt đầu</a>
                                    @else
                                        <a href="{{route('billiard.end-time',['id' => $value->id])}}"
                                           class="btn btn-outline-light">Chi tiết</a>
                                        <a href="{{route('billiard.create')}}" class="btn btn-outline-light">Thêm dịch
                                            vụ</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
{{--        <div class=" col-2"></div>--}}

    </div>
@endsection

