@extends('layouts.admin')
@section('title')
    {{--    {{$title}}--}}
@endsection
@section('css')
@endsection

@section('content')
    <div class="container">
        <div class="col-1"></div>
        <div class="col-10">
            <br>
            <br>
            <div class="row">
                <div class="text-center col-2">
                    <a href="{{route('billiard.end-time',['id'=>session('id')])}}"><i
                            class="fa-solid fa-arrow-left"></i></a>
                </div>@csrf
                <div class="text-center col-8">
                    <h2>Danh Sách Dịch Vụ</h2>
                </div>
                <div class="text-center col-2"></div>
            </div>
            <hr>
            <div class="row">
                <form method="get" action="" class="mb-3">
                    <div class="row">
                        <div class="col-5">
                            <select style="border: #212121 solid 1px" name="category_id" class="form-control" id="">
                                <option value="0" class="text-center">-----Loại dịch vụ-----</option>
                                @if(count($categoriesList) > 0)
                                    @foreach($categoriesList as $item)
                                        <option
                                            {{request('category_id') == $item->id ? 'selected': false}} value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-5">
                            <input type="search" name="keywords" class="form-control" value="{{request('keywords')}}"
                                   placeholder="Tên sản phẩm...">
                        </div>
                        <div class="col-2">
                            <button type="submit" class="btn btn-primary btn-block">Tìm kiếm</button>
                        </div>
                    </div>
                </form>
            </div>
            <h2>{{session('msg')}}</h2>
            @if(count($drinks) > 0)
                <div class="row">
                    <table class="table ">
                        <thead>
                        <tr>
                            <th>Stt</th>
                            <th>Tên</th>
                            <th>Loại</th>
                            <th>Gía</th>
                            <th>Số lượng</th>
                            <th>Chức năng</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($drinks as $key => $value)
                            <tr @switch($value->category_id)
                                    @case('1'):
                                style="background: #CFCFCF"
                                @break;
                                @case('2'):
                                style="background: #E8E8E8"
                                @break;
                                @case('3'):
                                style="background: #BEBEBE"
                                @break;
                                @endswitch>
                                <td>{{$key + 1}}</td>
                                <td>{{$value->attachFacilityName}}</td>
                                <td>{{$value->categoryName}}</td>
                                <td>{{number_format($value->price,0,'.')}}</td>
                                <form action="{{route('billiard.add-category')}}" method="get">
                                    <td>
                                        <input value="1" style="width: 60px" class="form-control" min="1"
                                               name="quantity"
                                               type="number">
                                        <input value="{{$value->id}}" name="id" type="hidden">
                                    </td>
                                    <td>
                                        <button class="btn btn-warning" type="submit">Thêm</button>
                                        {{--                                <a class="btn btn-success" href="{{route('billiard.add-category',['id'=>$value->id])}}">Them</a>--}}
                                    </td>
                                </form>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center">
                        {{ $drinks->links() }}
                    </div>
                </div>
            @else
                <div class="row text-center">
                    <h3 class="text-danger">
                        Chưa có sản phẩm.
                    </h3>
                </div>
            @endif


        </div>
        <div class="col-1"></div>
    </div>
@endsection

@section('js')
@endsection

