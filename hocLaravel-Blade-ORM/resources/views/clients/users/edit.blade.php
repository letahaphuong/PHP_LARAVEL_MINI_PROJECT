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
    <form action="{{route('users.post-edit')}}" method="post">
        @if($errors->any())
            <div class="alert-danger alert">Dữ liệu nhập vào không hợp lệ. Vui lòng kiểm tra lại.</div>
        @endif
        <div class="mb-3">
            <label>Họ và tên:</label>
            <input value="{{old('fullname') ?? $user->fullname}}" type="text" class="form-control" name="fullname"
                   placeholder="Họ và tên...">
            @error('fullname')
            <p class="text-danger"> {{$message}}</p>
            @enderror
        </div>
        <div class="mb-3">
            <label>Email:</label>
            <input value="{{old('email') ?? $user->email}}" type="text" class="form-control" name="email"
                   placeholder="Email...">

            @error('email')
            <p class="text-danger"> {{$message}}</p>
            @enderror
        </div>
        <div class="mb-3">
            <label>Nhóm người dùng:</label>
            <select class="form-control" name="group_id" id="">
                <option class="text-center" value="{{null}}">-------Chọn nhóm người dùng-------</option>
                @if(!empty(getAllGroups()))
                    @foreach(getAllGroups() as $item)
                        <option
                            {{ (old('group_id') == $item->id || $user->group_id == $item->id)? 'selected' : false }} class="text-center"
                            value="{{$item->id}}">{{$item->name}}</option>
                    @endforeach
                @endif
            </select>
            @error('group_id')
            <p class="text-danger"> {{$message}}</p>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Cập nhật</button>
        <a href="{{route('users.index')}}" class="btn btn-warning">Quay lại</a>
        @csrf
    </form>
@endsection
