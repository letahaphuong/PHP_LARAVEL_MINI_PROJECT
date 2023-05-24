@extends('layouts.admin')
@section('title')
    {{$title}}
@endsection
@section('css')
@endsection
@section('content')
    <div class="row sticky-top">
        <h1 class="bg-success text-center">Lịch Sử Kinh Doanh</h1>
    </div>
    <hr class="m-0">
    <div class="row">
        <div class="col-1"></div>
        <div class="col-10 shadow p-3 mb-5 bg-white rounded">
            <h2 class="text-center">Danh Sách Lịch Sử</h2>
            <hr>

            @if(count($orderListHistory)>0)
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th class="text-center">STT</th>
                            <th>Mã Đơn Hàng</th>
                            <th>Số Bàn</th>
                            <th>Giờ Bắt Đầu</th>
                            <th>Giờ Bắt Thúc</th>
                            <th>Chức Năng</th>
                        </tr>
                        </thead>
                        @foreach($orderListHistory as $key => $value)
                            <tbody>
                            <tr>
                                <th class="text-center">{{$key + 1}}</th>
                                <td>{{$value->code_billiard}}</td>
                                <td>{{$value->billiard_id}}</td>
                                <td>{{formatDateTime($value->created_at)}}</td>
                                <td>{{formatDateTime($value->updated_at)}}</td>
                                <td>
                                    <a href="{{route('billiard.dashboard-details',['id'=>$value->id,'code'=> $value->code_billiard ])}}"
                                       class="btn btn-sm btn-warning">Chi tiết</a>
                                </td>
                            </tr>
                            </tbody>
                        @endforeach
                    </table>
                {{$orderListHistory->links()}}
            @else
                <div class="text-danger text-center">
                    <h1>Chưa có bàn.</h1>
                </div>
            @endif


            {{--            <form method="get" action="" class="mb-3">--}}
            {{--                <div class="row d-flex">--}}
            {{--                    <div class="col-3">--}}
            {{--                        <select style="border:  #212121 solid 1px " name="group_id" class="form-control" id="">--}}
            {{--                            <option class="text-center" value="0">--Loại Bàn--</option>--}}
            {{--                            @if(!empty(getAllGroups()))--}}
            {{--                                @foreach(getAllGroups() as $item)--}}
            {{--                                    <option--}}
            {{--                                        {{request('group_id') == $item->id ? 'selected': false}} value="{{$item->id}}">{{$item->name}}</option>--}}
            {{--                                @endforeach--}}
            {{--                            @endif--}}
            {{--                        </select>--}}
            {{--                        <select style="border:  #212121 solid 1px " name="group_id" class="form-control mt-2" id="">--}}
            {{--                            <option value="0">--Chọn nhóm người dùng--</option>--}}
            {{--                            @if(!empty(getAllGroups()))--}}
            {{--                                @foreach(getAllGroups() as $item)--}}
            {{--                                    <option--}}
            {{--                                        {{request('group_id') == $item->id ? 'selected': false}} value="{{$item->id}}">{{$item->name}}</option>--}}
            {{--                                @endforeach--}}
            {{--                            @endif--}}
            {{--                        </select>--}}
            {{--                    </div>--}}
            {{--                    <div class="col-3">--}}
            {{--                        <input style="border:  #212121 solid 1px " type="date" name="keywords" class="form-control" value="{{request('keywords')}}"--}}
            {{--                               placeholder="Tìm kiếm">--}}
            {{--                    </div>--}}
            {{--                    <div class="col-4" >--}}
            {{--                        <input style="border:  #212121 solid 1px " type="search" name="keywords" class="form-control" value="{{request('keywords')}}"--}}
            {{--                               placeholder="Tìm kiếm">--}}
            {{--                    </div>--}}
            {{--                    <div class="col-2">--}}
            {{--                        <button type="submit" class="btn btn-primary btn-block">Tìm kiếm</button>--}}
            {{--                    </div>--}}
            {{--                </div>--}}
            {{--            </form>--}}
            {{--            @if(count($historyList)>0)--}}
            {{--                <table class="table table-hover">--}}
            {{--                    <thead>--}}
            {{--                    <tr >--}}
            {{--                        <th class="text-center">STT</th>--}}
            {{--                        <th>Mã Đơn Hàng</th>--}}
            {{--                        <th>Tên Loại Bàn</th>--}}
            {{--                        <th>Giá Loại Bàn</th>--}}
            {{--                        <th>Tên Sản Phẩm</th>--}}
            {{--                        <th>Giá Sản Phẩm</th>--}}
            {{--                        <th>Giờ Bắt Đầu</th>--}}
            {{--                        <th>Giờ Bắt Thúc</th>--}}
            {{--                        <th>Chức Năng</th>--}}
            {{--                    </tr>--}}
            {{--                    </thead>--}}
            {{--                    @foreach($historyList as $key => $value)--}}
            {{--                        <tbody>--}}
            {{--                        <tr>--}}
            {{--                            <th class="text-center">{{$key + 1}}</th>--}}
            {{--                            <td >{{$value->code_order}}</td>--}}
            {{--                            <td >{{$value->billiardTypeName}}</td>--}}
            {{--                            <td >{{$value->billiardPrice}}</td>--}}
            {{--                            <td >{{$value->categoryName}}</td>--}}
            {{--                            <td >{{$value->productPrice}}</td>--}}
            {{--                            <td>{{formatDateTime($value->created_at)}}</td>--}}
            {{--                            <td>{{formatDateTime($value->updated_at)}}</td>--}}
            {{--                            <td class="text-center">--}}
            {{--                                <a class="btn btn-sm btn-warning">do something</a>--}}
            {{--                            </td>--}}
            {{--                        </tr>--}}
            {{--                        </tbody>--}}
            {{--                    @endforeach--}}
            {{--                </table>--}}
            {{--                {{$historyList->links()}}--}}
            {{--            @else--}}
            {{--                <div class="text-danger text-center">--}}
            {{--                    <h1>Chưa có bàn.</h1>--}}
            {{--                </div>--}}
            {{--            @endif--}}
        </div>
        <div class="col-1">
        </div>
    </div>
@endsection
@section('js')
@endsection
