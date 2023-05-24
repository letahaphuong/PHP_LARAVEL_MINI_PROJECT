@extends('layouts.admin')
@section('title')
    {{$title}}
@endsection
@section('content')
    <div class="row sticky-top">
        <h1 class="bg-success text-center">Lịch Sử Kinh Doanh</h1>
    </div>
    <hr class="m-0">
    <div class="row">
        <div class="col-1"></div>
        <div class="col-10 shadow p-3 mb-5 bg-white rounded">
            <a href="{{route('billiard.dashboard')}}"><i
                    class="fa-solid fa-arrow-left"></i></a>
            <h2 class="text-center">Danh Sách Lịch Sử Mã Đơn Hàng: <span class="text-danger">{{$listOrderDetails[0]->code_order}}</span></h2>
            <hr>

            @if(count($listOrderDetails)>0)
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th class="text-center">STT</th>
                        <th>Mã Đơn Hàng</th>
                        <th>Tên Sản Phẩm</th>
                        <th>Giá Sản Phẩm</th>
                        <th>Số Lượng</th>
                        <th>Thành Tiền</th>
                        <th>Giờ Bắt Đầu</th>
                        <th>Giờ Bắt Thúc</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($listOrderDetails as $key => $value)
                        <tr>
                            <th class="text-center">{{$key + 1}}</th>
                            <td>{{$value->code_order}}</td>
                            <td>{{$value->categoryName}}</td>
                            <td>{{$value->productPrice}}</td>
                            <td>{{$value->quantity}}</td>
                            <td>{{number_format($value->productPrice * $value->quantity,0,',','.')}} VND</td>
                            <td>{{formatDateTime($value->created_at)}}</td>
                            <td>{{formatDateTime($value->updated_at)}}</td>
                        </tr>
                    @endforeach
                    <tr class="float-right">
                        <h5>Tổng số giờ sử dụng:
                            <span class="text-danger">
                                {{$hourTotal[0]}}
                            </span> VND
                        </h5>
                    </tr>
                    <tr class="float-right">
                        <h5>Tổng tiền giờ sử dụng:
                            <span class="text-danger">
                                {{number_format($hourTotal[1],0,',','.')}}
                            </span> VND
                        </h5>
                    </tr>
                    <tr class="float-right">
                        <h5>Tổng tiền sử dụng dịch vụ đi kèm:
                            <span class="text-danger">
                                {{number_format($total,0,',','.')}}
                            </span> VND
                        </h5>
                    </tr>
                    <hr>
                    <tr class="float-right">
                        <h5>Tổng tiền:
                            <span class="text-danger">
                                {{number_format($total + $hourTotal[1],0,',','.') }}
                            </span> VND
                        </h5>
                    </tr>
                    <hr class="text-danger">
                    </tbody>
                </table>
            @else
                <div class="text-danger text-center">
                    <h1>Chưa có bàn.</h1>
                </div>
            @endif
        </div>
        <div class="col-1">
        </div>
    </div>
@endsection
