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
    <a href="{{route('users.add')}}" class="btn btn-primary">Them nguoi dung</a>
    <hr>
    <table class="table table-striped table-hover border table-bordered">
        <thead>
        <tr>
            <th width="5%">STT</th>
            <th>Ten</th>
            <th>Email</th>
            <th width="15%">Thoi gian</th>
            <th width="5%">Sua</th>
            <th width="5%">Xoa</th>
        </tr>
        </thead>
        <tbody>
        @if(!empty($usersList))
            @foreach($usersList as $key => $item)
                <tr>
                    <td>{{$key +1}}</td>
                    <td>{{$item->fullname}}</td>
                    <td>{{$item->email}}</td>
                    <td>{{date('d-m-Y', strtotime($item->create_at))}}</td>
                    <td>
                        <a data-bs-toggle="modal" data-bs-target="#delete"
                           href="{{route('users.edit',['id'=>$item->id])}}" class="btn btn-warning btn-sm">Sua</a>
                    </td>

                    <td>
                        <a onclick="return confirm('Ban chac chan muon xoa : {{$item->fullname}} khong? ')"
                           href="{{route('users.delete',['id'=>$item->id])}}" class="btn btn-danger btn-sm">Xoa</a>
                        {{--                        <a  type="button"  data-bs-toggle="modal" data-bs-target="#delete"  class="btn btn-danger btn-sm">Xoa</a>--}}
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="6">Khong co nguoi dung</td>
            </tr>
        @endif
        </tbody>
    </table>
    <x-form.modal />
@endsection

