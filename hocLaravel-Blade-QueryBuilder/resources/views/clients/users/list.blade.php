@extends('layouts.client')
@section('title')
    {{$title}}
@endsection
@section('content')
    @if(session('msg'))
        <div class="alert-{{session('type')}} alert">
            {{session('msg')}}
        </div>
    @endif
    <h1 style="text-align: center">{{$title}}</h1>
    <a href="{{route('users.add')}}" class="btn btn-primary">Thêm người dùng</a>
    <hr>
    <form method="get" action="" class="mb-3">
        <div class="row">
            <div class="col-3">
                <select name="status" class="form-control" id="">
                    <option value="0">--Tất cả trạng thái--</option>
                    <option value="active" {{request('status') == 'active'?'selected': false}}>Kích hoạt</option>
                    <option value="inactive" {{request('status') == 'inactive'?'selected': false}}>Chưa kích hoạt
                    </option>
                </select>
            </div>
            <div class="col-3">
                <select name="group_id" class="form-control" id="">
                    <option value="0">--Chọn nhóm người dùng--</option>
                    @if(!empty(getAllGroups()))
                        @foreach(getAllGroups() as $item)
                            <option
                                {{request('group_id') == $item->id ? 'selected': false}} value="{{$item->id}}">{{$item->name}}</option>
                        @endforeach
                    @endif
                </select>
            </div>

            <div class="col-4">
                <input type="search" name="keywords" class="form-control" value="{{request('keywords')}}"
                       placeholder="Tìm kiếm">
            </div>
            <div class="col-2">
                <button type="submit" class="btn btn-primary btn-block">Tìm kiếm</button>
            </div>
        </div>
    </form>
    <table class="table table-striped table-hover border table-bordered">
        <thead>
        <tr>
            <th width="5%">STT</th>
            <th width="30%"><a href="?sortBy=fullname&sortType={{$sortType}}">Tên người dùng <i class="fa fa-sort"></i></a></th>
            <th><a href="?sortBy=email&sortType={{$sortType}}">Email <i class="fa fa-sort"></i></a></th>
            <th>Nhóm</th>
            <th>Trạng thái</th>
            <th width="15%"><a href="?sortBy=create_at&sortType={{$sortType}}">Thời gian <i class="fa fa-sort"></i></a></th>
            <th width="5%">Sửa</th>
            <th width="5%">Xóa</th>
        </tr>
        </thead>
        <tbody>
        @if(count($usersList) > 0)
            @foreach($usersList as $key => $item)
                <tr>
                    <td>{{$key +1}}</td>
                    <td>{{$item->fullname}}</td>
                    <td>{{$item->email}}</td>
                    <td>{{$item->group_name}}</td>
                    <td>{!! $item->status == 0 ? '<button class="btn btn-danger">Chưa K/Hoạt</button>' : '<button class="btn btn-success">Kích hoạt</button>' !!}</td>
                    <td>{{date('d-m-Y', strtotime($item->create_at))}}</td>
                    <td>
                        <a href="{{route('users.edit',['id'=>$item->id])}}"
                           class="btn btn-warning btn-sm">Sửa</a>
                    </td>

                    <td>
                        <a onclick="return confirm('Bạn chắc chắn muốn xóa tên : {{$item->fullname}} không? ')"
                           data-confirm-delete="true" href="{{route('users.delete',['id'=>$item->id])}}"
                           class="btn btn-danger btn-sm">Xóa</a>
                        {{--                        <a  type="button"  data-bs-toggle="modal" data-bs-target="#delete"  class="btn btn-danger btn-sm">Xoa</a>--}}
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="8" class="text-danger text-center">Không có người dùng.</td>
            </tr>
        @endif
        </tbody>
    </table>
    <div class="d-flex justify-content-center">
        {{ $usersList->links() }}
    </div>
    <x-form.modal/>
@endsection

