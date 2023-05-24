@extends('layouts.admin')
@section('title')
    {{$title}}
@endsection
@section('css')
@endsection

@section('content')
    <div class="row">
        <div class="row text-center">
            <div class="col-1">
                <a href="{{route('billiard.index')}}"><i
                        class="fa-solid fa-arrow-left"></i></a>
            </div>
            <div class="col-10">
                <h1>Bắt đầu tính giờ.</h1>
            </div>
            <div class="col-1"></div>
        </div>
        <hr>
        <div class="row">
            <div class="col-3"></div>
            <div class="col-6 shadow p-3 mb-5 bg-white rounded align-items-center" style="height: 450px">
                <h1 class="text-center">RIN BILLIARD</h1>
                <br>
                <br>
                <form action="{{route('billiard.create-table')}}" method="post">
                    <div class="mb-3 d-flex">
                        <div class="col-3">
                            <label for="start_time">Giờ Bắt Đầu</label>
                        </div>
                        <div class="col-9">
                            <input value="{{now()}}" id="start_time" class="form-control"
                                   type="datetime-local" name="start_time">
                        </div>
                    </div>
                    <div class="mb-3 d-flex">
                        <div class="col-3">
                            <label for="end_time">Giờ Kết Thúc</label>
                        </div>
                        <div class="col-9">
                            <input value="{{now()}}" id="end_time" class="form-control"
                                   type="datetime-local" name="end_time">
                        </div>
                    </div>
                    <input value="1" class="form-control" type="hidden"
                           name="status">
                    <input value="{{$billiard->billiard_type_id}}" class="form-control" type="hidden"
                           name="billiard_type_id">
                    <div class="mb-3 d-flex">
                        <div class="col-3">
                        </div>
                        <div class="col-3">
                            <input class="form-control" type="hidden" value="1" name="status">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Bắt đầu</button>
                    @csrf
                </form>
            </div>
            <div class="col-3"></div>
        </div>
    </div>
@endsection

@section('js')
@endsection
