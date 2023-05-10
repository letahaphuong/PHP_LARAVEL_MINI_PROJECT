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
            <div class="alert-danger alert">Du lieu nhap vao khong hop le. Vui long kiem tra lai.</div>
        @endif
        <div class="mb-3">
            <label>Ho va ten:</label>
            <input value="{{old('fullname') ?? $user->fullname}}" type="text" class="form-control" name="fullname"
                   placeholder="Ho va ten...">
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
        <button type="submit" class="btn btn-primary">Cap nhat</button>
        <a href="{{route('users.index')}}" class="btn btn-warning">Quay ve</a>
        @csrf
    </form>
@endsection
