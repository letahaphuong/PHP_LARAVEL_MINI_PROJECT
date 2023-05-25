@extends('layouts.admin')
@section('title')
    {{$title}}
@endsection
@section('css')
@endsection

@section('content')
    <div class="container">
        <div class="row pb-2">
            <div class="container text-center">
                <h2 class="text-info">Bàn số: {{session('id')}}</h2>
            </div>
            <hr>
            <div class="row">
                <div class="col-6 d-flex justify-content-between">
                    <h3>Chi tiết giờ chơi</h3>

                </div>
                <div class="col-6 d-flex justify-content-between">
                    <h3>Dịch vụ đi kèm</h3>
                    <a href="{{route('billiard.create')}}" class="btn d-flex align-items-center btn-sm btn-success">Thêm
                        dịch vụ</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-5 rounded shadow p-3 mb-5 bg-white rounded">
                <form action="{{route('billiard.end-table')}}" method="post">
                    <div class="mb-3 d-flex">
                        <div class="col-3">
                            <label for="start_time">Giờ Bắt Đầu</label>
                        </div>
                        <div class="col-9">
                            <input readonly value="{{$billiard->start_time ?? now()}}" id="start_time"
                                   class="form-control"
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
                    <div class="mb-3 d-flex">
                        <div class="col-3">
                            <label for="time_played">Số giờ chơi</label>
                        </div>
                        <div class="col-9">
                            <input value="{{$viewTimePlayed[0]}}" id="time_played" class="form-control"
                                   disabled>
                        </div>
                    </div>
                    <div class="mb-3 d-flex">
                        <div class="col-3">
                            <label for="time_played">Tiền giờ</label>
                        </div>
                        <div class="col-9">
                            <input disabled value="{{number_format($viewTimePlayed[1],0 ,',','.')}} VND" id="start_time"
                                   class="form-control"
                                   type="text">
                        </div>
                    </div>

                    <div class="mb-3 d-flex">
                        <div class="col-3">
                            <label for="">Tiền dịch vụ</label>
                        </div>
                        <div class="col-9">
                            <input disabled id="" value="{{number_format($viewTotalFacilities,0,',','.')}} VND"
                                   class="form-control"
                                   type="text">
                        </div>
                    </div>
                    <hr>
                    <div class="mb-3 d-flex">
                        <div class="col-3">
                            <label for="">Tổng tiền : </label>
                        </div>
                        <div class="col-9">
                            <strong
                                class="text-danger">{{number_format($viewTotalFacilities + $viewTimePlayed[1],0,',','.')}}
                                VND</strong>
                        </div>
                    </div>
                    <input value="{{$billiard->billiard_type_id}}" id="end_time" class="form-control"
                           type="hidden" name="billiard_type_id">
                    <button class="btn btn-sm btn-success" type="submit">Thanh toán</button>
                    @csrf
                </form>
            </div>
            <div class="col-7 rounded shadow p-3 mb-5 bg-white rounded">
                @if(count($getListAttachFacility) > 0)
                    <div class="row">
                        <table class="table ">
                            <thead>
                            <tr>
                                <th>STT</th>
                                <th>Tên</th>
                                <th>Gía</th>
                                <th>Số lượng</th>
                                <th>Thành tiền</th>
                                <th>Chức năng</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($getListAttachFacility as $key => $value)
                                <tr>
                                    <td>{{$key + 1}}</td>
                                    <td>{{$value->name}}</td>
                                    <td>{{number_format($value->price,0,',','.')}}</td>
                                    <form action="{{route('billiard.update-attach')}}" method="get">
                                        <td width="90">
                                            <input id="myInput" name="quantity" class="form-control" type="number"
                                                   value="{{$value->quantity ? $value->quantity : value()}}">
                                            <input type="hidden" value="{{$value->id}}" name="id">
                                        </td>
                                        <td>{{ number_format($value->price * $value->quantity,0,',','.') }}</td>
                                        <td class="d-flex" width="170">
                                            <a href="{{route('billiard.delete-attach',['id' => $value->id])}}"
                                               onclick="return confirm('Bạn chắc chắn muốn xóa : {{$value->name}} ra khỏi danh sách không? ')"
                                               data-confirm-delete="true" class="btn btn-sm btn-danger">Xóa</a>
                                            <button type="submit" class="btn btn-sm btn-warning ms-2">Cập nhật</button>
                                        </td>
                                    </form>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-center">
                            {{ $getListAttachFacility->links() }}
                        </div>
                    </div>
                @else
                    <div class="row">
                        <div class="text-danger text-center">
                            <h2>Chưa sử dụng dịch vụ.</h2>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script !src="">
    </script>
@endsection
