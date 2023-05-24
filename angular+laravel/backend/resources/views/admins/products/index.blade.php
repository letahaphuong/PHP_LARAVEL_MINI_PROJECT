@extends('layouts.admin')
@section('title')
    {{--    {{$title}}--}}
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
    <div class="row sticky-top">
        <h1 class="bg-success">Quản Lý</h1>
    </div>
    <hr class="m-0">
    <div class="row">
        <h3>Quản Lý Bàn</h3>
        <div class="col-7 shadow p-3 mb-5 bg-white rounded">
            <button onclick="showForm()" class="btn btn-sm btn-primary mb-2">Thêm bàn</button>
            @if(count($billiardList)>0)
                <table class="table table-hover">
                    <thead>
                    <tr class="text-center">
                        <th>STT</th>
                        <th>Số Bàn</th>
                        <th>Trạng Thái</th>
                        <th>Loại Bàn</th>
                        <th>Giờ Bắt Đầu</th>
                        <th>Giờ Kết Thúc</th>
                        <th>Chức Năng</th>
                    </tr>
                    </thead>
                    @foreach($billiardList as $key => $value)
                        <tbody>
                        <tr>
                            <th class="text-center">{{$key + 1}}</th>
                            <td class="text-center">{{$value->id}}</td>
                            <td>{{$value->status == 0 ? 'Chưa có khách' : 'Đang có khách'}}</td>
                            @switch($value->billiard_type_id)
                                @case(1)
                                    <td>Bida Băng</td>
                                    @break;
                                @case(2)
                                    <td>Bida Lỗ</td>
                                    @break;
                            @endswitch
                            <td>{{formatDateTime($value->start_time)}}</td>
                            <td>{{formatDateTime(now())}}</td>
                            <td class="text-center">
                                <a onclick="editBilliard({{$value->id}},{{$value->billiard_type_id}} ,{{$value->status}} , <?php
                                $startTime = new DateTime($value->start_time);
                                $stringStartTime = $startTime->format('Y-m-d H:i:s');
                                echo "'".$stringStartTime."'";
                                ?>
                                , <?php
                                $endTime = new DateTime(now());
                                $stringEndTime = $endTime->format('Y-m-d H:i:s');
                                echo "'".$stringEndTime."'";
                                ?>)"
                                   class="btn btn-sm btn-warning">Sửa</a>
                            </td>
                        </tr>
                        </tbody>
                    @endforeach
                </table>
                {{$billiardList->links()}}
            @else
                <div class="text-danger text-center">
                    <h1>Chưa có bàn.</h1>
                </div>
            @endif
        </div>
        <div class="col-5 shadow p-3 mb-5 bg-white rounded">
            <div id="form-order" class="form-order" style="display: none">
                <h3>Thêm Bàn</h3>

                <form action="{{route('billiard.add-new-billiard')}}" method="post">

                    <div class="mb-3 d-flex">
                        <div class="col-5" style="height: 40px">
                            <h5>Chọn Loại Bàn : </h5>
                        </div>
                        <div class="col-4" style="height: 40px">
                            <select name="billiard_type_id" class="form-select" id="">
                                <option disabled value="0" class="text-center">-----Loại Bàn-----</option>
                                <option value="1" class="float-start">Bida Băng</option>
                                <option value="2" class="float-start">Bida Lỗ</option>
                            </select>
                        </div>
                        <div class="col-3" style="height: 40px"></div>
                    </div>
                    <div class="mb-3 d-flex">
                        <div class="col-5" style="height: 40px">
                            <h5>Trạng Thái Hoat động : </h5>
                        </div>
                        <div class="col-4" style="height: 40px">
                            <input readonly class="form-control" value="Chưa hoạt động" type="text" name="status">
                        </div>
                        <div class="col-3" style="height: 40px"></div>
                    </div>
                    <div class="mb-3 d-flex">
                        <div class="col-5" style="height: 40px">
                            <h5>Thời Gian Bắt Đầu : </h5>
                        </div>
                        <div class="col-4" style="height: 40px">
                            <input readonly class="form-control" type="datetime-local" name="start_time"
                                   value="{{now()}}">
                        </div>
                        <div class="col-3" style="height: 40px"></div>
                    </div>

                    <div class="mb-3 d-flex">
                        <div class="col-5" style="height: 40px">
                            <h5>Thời Gian Kết Thúc : </h5>
                        </div>
                        <div class="col-4" style="height: 40px">
                            <input readonly class="form-control" type="datetime-local" name="end_time"
                                   value="{{now()}}">
                        </div>
                        <div class="col-3" style="height: 40px"></div>
                    </div>

                    <div class="row">
                        <h5 class="text-danger mr-2">Bạn Chắc Chắc Thêm Bàn mới không?</h5>
                    </div>

                    <button type="submit" class="btn btn-primary">Xác nhận</button>
                    @csrf
                    <br>

                </form>
            </div>
            <div id="form-edit" class="form-edit" style="display: none">
                <h3>Sửa Thông Tin Bàn</h3>
                <form action="{{route('billiard.edit-new-billiard')}}" method="post">

                    <div class="mb-4 d-flex">
                        <div class="col-5" style="height: 40px">
                            <h5>Chọn Loại Bàn : </h5>
                        </div>
                        <div class="col-4" style="height: 40px">
                            <select name="billiard_type_id" class="form-select" id="idField">
                                <option disabled value="0" class="text-center">-----Loại Bàn-----</option>
                                <option value="1" class="float-start">Bida Băng</option>
                                <option value="2" class="float-start">Bida Lỗ</option>
                            </select>
                        </div>
                        <div class="col-3" style="height: 40px"></div>
                    </div>
                    <div class="mb-3 d-flex">
                        <div class="col-5" style="height: 40px">
                            <h5>Trạng Thái Hoat động : </h5>
                        </div>
                        <div class="col-4" style="height: 40px">
                            <input readonly id="statusField" class="form-control" type="text"
                                   name="status">
                            <input id="id" class="form-control" type="hidden"
                                   name="id">
                        </div>
                        <div class="col-3" style="height: 40px"></div>
                    </div>
                    <div class="mb-3 d-flex">
                        <div class="col-5" style="height: 40px">
                            <h5>Thời Gian Bắt Đầu : </h5>
                        </div>
                        <div class="col-4" style="height: 40px">
                            <input readonly id="startTimeField" class="form-control" type="datetime-local"
                                   name="start_time"
                                   value="{{now()}}">
                        </div>
                        <div class="col-3" style="height: 40px"></div>
                    </div>

                    <div class="mb-3 d-flex">
                        <div class="col-5" style="height: 40px">
                            <h5>Thời Gian Kết Thúc : </h5>
                        </div>
                        <div class="col-4" style="height: 40px">
                            <input readonly id="endTimeField" class="form-control" type="datetime-local" name="end_time"
                                   value="{{now()}}">
                        </div>
                        <div class="col-3" style="height: 40px"></div>
                    </div>

                    <button type="submit" class="btn btn-primary">Xác nhận</button>
                    @csrf
                    <br>

                </form>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <h3>Quản Lý Loại Bàn</h3>

        <div class="col-7 shadow p-3 mb-5 bg-white rounded">
            <button onclick="showFormAddBilliardType()" class="btn btn-sm btn-primary mb-2">Thêm Loại Bàn</button>
            @if(count($billiardTypeList)>0)
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th class="text-center">STT</th>
                        <th>Tên Loại Bàn</th>
                        <th>Giá</th>
                        <th>Đơn Vị</th>
                        <th>Ngày Nhập</th>
                        <th>Chức Năng</th>
                    </tr>
                    </thead>
                    @foreach($billiardTypeList as $key => $value)
                        <tbody>
                        <tr>
                            <th class="text-center">{{$key+1}}</th>
                            <td>{{$value->name}}</td>
                            <td>{{$value->price}}</td>
                            <td>giờ</td>
                            <td>{{formatDateTime($value->created_at) ?? 'Chưa cập nhật ngày'}}</td>
                            <td>
                                <a onclick="editBilliardType( {{$value->id}},
                                <?php
                                     $name = "'".$value->name."'";
                                     echo $name;
                                     ?>,
                                     {{$value->price}}
                                )"
                                   class="btn btn-warning btn-sm">Sửa</a>

                                <a onclick="return confirm('Bạn chắc chắn muốn xóa loại : {{$value->name}} không? ')"
                                   href="{{route('billiard.deleteB-billiardType',['id'=>$value->id])}}"
                                   class="btn btn-danger btn-sm">Xóa</a>
                            </td>
                        </tr>
                        </tbody>
                    @endforeach
                </table>
                {{$billiardTypeList->links()}}
            @else
                <div class="text-danger text-center">
                    <h1>Chưa có loại bàn.</h1>
                </div>
            @endif
        </div>
        <div class="col-5 shadow p-3 mb-5 bg-white rounded">
            <div id="form-create-billiard-type" class="form-create-billiard-type" style="display: none">
                <h3>Thêm Loại Bàn</h3>

                <form action="{{route('billiard.add-new-billiard-type')}}" method="post">

                    <div class="mb-3 d-flex">
                        <div class="col-5" style="height: 40px">
                            <h5>Tên Loại Bàn : </h5>
                        </div>
                        <div class="col-4" style="height: 40px">
                            <input style="border: 1px solid #000;" class="form-control" type="text"
                                   name="name">
                            @error('name')
                            <p class="text-danger"> {{$message}}</p>
                            @enderror
                        </div>
                        <br>
                        <br>
                        <br>
                        <div class="col-3" style="height: 40px"></div>
                    </div>
                    <div class="mb-3 d-flex">
                        <div class="col-5" style="height: 40px">
                            <h5>Giá Tiền : </h5>
                        </div>
                        <div class="col-4" style="height: 40px">
                            <input style="border: 1px solid #000;" class="form-control" type="text"
                                   name="price">
                            @error('price')
                            <p class="text-danger"> {{$message}}</p>
                            @enderror
                        </div>
                        <br>
                        <br>
                        <br>
                        <div class="col-3" style="height: 40px"></div>
                    </div>


                    <div class="row">
                        <h5 class="text-danger mr-2">Bạn Chắc Chắc Thêm Bàn mới không?</h5>
                    </div>

                    <button type="submit" class="btn btn-primary">Xác nhận</button>
                    @csrf
                    <br>

                </form>
            </div>
            <div id="form-edit-billiard-type" class="form-edit-billiard-type" style="display: none">
                <h3>Sửa Thông Tin Bàn</h3>
                <form action="{{route('billiard.edit-new-billiard-type')}}" method="post">
                    <input style="border: 1px solid #000;" id="idTypeField" class="form-control" type="hidden"
                           name="id">
                    <div class="mb-3 d-flex">
                        <div class="col-5" style="height: 40px">
                            <h5>Tên Loại Bàn : </h5>
                        </div>
                        <div class="col-4" style="height: 40px">
                            <input style="border: 1px solid #000;" id="nameField" class="form-control" type="text"
                                   name="name">
                            @error('name')
                            <p class="text-danger"> {{$message}}</p>
                            @enderror
                        </div>
                        <br>
                        <br>
                        <br>
                        <div class="col-3" style="height: 40px"></div>
                    </div>
                    <div class="mb-3 d-flex">
                        <div class="col-5" style="height: 40px">
                            <h5>Giá Tiền : </h5>
                        </div>
                        <div class="col-4" style="height: 40px">
                            <input style="border: 1px solid #000;" id="priceField" class="form-control" type="text"
                                   name="price">
                            @error('price')
                            <p class="text-danger"> {{$message}}</p>
                            @enderror
                        </div>
                        <br>
                        <br>
                        <br>
                        <div class="col-3" style="height: 40px"></div>
                    </div>

                    <button type="submit" class="btn btn-primary">Xác nhận</button>
                    @csrf
                    <br>

                </form>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <h3>Quản Lý Sản Phẩm</h3>
        <div class="col-7 shadow p-3 mb-5 bg-white rounded">
            <button onclick="showFormAddProduct()" class="btn btn-sm btn-primary mb-2">Thêm Sản Phẩm</button>
            @error('name')
            <div class="alert-danger alert">{{$message}}</div>
            @enderror
            @error('price')
            <div class="alert-danger alert">{{$message}}</div>
            @enderror
            @error('category_id')
            <div class="alert-danger alert">{{$message}}</div>
            @enderror
            @if(count($productsList)>0)
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th class="text-center">STT</th>
                        <th>Tên Danh Mục</th>
                        <th>Tên Sản Phẩm</th>
                        <th>Giá</th>
                        <th>Ngày Nhập</th>
                        <th>Chức Năng</th>
                    </tr>
                    </thead>
                    @foreach($productsList as $key => $value)
                        <tbody>
                        <tr>
                            <th class="text-center">{{$key + 1}}</th>
                            @switch($value->category_id)
                                @case(1)
                                    <td>Nước Ngọt</td>
                                    @break;
                                @case(2)
                                    <td>Beer</td>
                                    @break;
                                @case(3)
                                    <td>Thức Ăn</td>
                                    @break;
                            @endswitch
                            <td>{{$value->name}}</td>
                            <td>{{$value->price}}</td>
                            <td>{{formatDateTime($value->created_at)}}</td>
                            <td>
                                <a
                                    onclick="editProduct(
                                        {{$value->id}},
                                        <?php
                                         $name = "'" . $value->name ."'";
                                         echo $name;
                                        ?>,
                                        {{$value->category_id}},
                                        {{$value->price}}
                                    )"
                                    class="btn btn-warning btn-sm"
                                >Sửa</a>
                                <a onclick="return confirm('Bạn chắc chắn muốn xóa sản phẩm : [{{$value->name}}] không? ')"
                                   href="{{route('billiard.delete-product',['id'=>$value->id])}}"
                                   class="btn btn-danger btn-sm">Xóa</a>
                            </td>
                        </tr>
                        </tbody>
                    @endforeach
                </table>
                {{$productsList->links()}}
            @else
                <div class="text-danger text-center">
                    <h1>Chưa có sản phẩm.</h1>
                </div>
            @endif
        </div>
        <div class="col-5 shadow p-3 mb-5 bg-white rounded">
            <div id="form-create-product" class="form-create-product" style="display: none">
                <h3>Thêm Sản Phẩm</h3>

                <form action="{{route('billiard.add-new-product')}}" method="post">
                    <div class="mb-3 d-flex">
                        <div class="col-5" style="height: 40px">
                            <h5>Tên Sản Phẩm : </h5>
                        </div>
                        <div class="col-4" style="height: 40px">
                            <input style="border: 1px solid #000;" class="form-control" type="text"
                                   name="name">
                        </div>
                        <div class="col-3" style="height: 40px"></div>
                    </div>

                    <div class="mb-3 d-flex">
                        <div class="col-5" style="height: 40px">
                            <h5>Loại Sản Phẩm : </h5>
                        </div>
                        <div class="col-4" style="height: 40px">
                            <select class="form-select" name="category_id">
                                <option value="0" class="text-center">Loại Sản Phẩm</option>
                                @if(count($categoriesList) > 0)
                                    @foreach($categoriesList as $key => $value)
                                        <option value="{{$value->id}}">{{$value->name}}</option>
                                    @endforeach
                                @else
                                    <option value="1">Nước Ngọt</option>
                                    <option value="2">Beer</option>
                                    <option value="3">Thức Ăn</option>
                                @endif
                            </select>
                        </div>
                        <div class="col-3" style="height: 40px"></div>
                    </div>

                    <div class="mb-3 d-flex">
                        <div class="col-5" style="height: 40px">
                            <h5>Giá Tiền : </h5>
                        </div>
                        <div class="col-4" style="height: 40px">
                            <input style="border: 1px solid #000;" class="form-control" type="text"
                                   name="price">
                        </div>
                        <div class="col-3" style="height: 40px"></div>
                    </div>

                    <div class="row">
                        <h5 class="text-danger mr-2">Bạn Chắc Chắc Thêm Sản Phẩm Mới?</h5>
                    </div>

                    <button type="submit" class="btn btn-primary">Xác nhận</button>
                    @csrf
                    <br>

                </form>
            </div>
            <div id="form-edit-product" class="form-edit-product" style="display: none">
                <h3>Sửa Thông Sản Phẩm</h3>
                <form action="{{route('billiard.edit-product')}}" method="post">
                    <input style="border: 1px solid #000;" id="idProductField" class="form-control" type="hidden"
                           name="id">
                    <div class="mb-3 d-flex">
                        <div class="col-5" style="height: 40px">
                            <h5>Tên Sản Phẩm : </h5>
                        </div>
                        <div class="col-4" style="height: 40px">
                            <input id="productNameField" style="border: 1px solid #000;" class="form-control"
                                   type="text"
                                   name="name">
                        </div>
                        <div class="col-3" style="height: 40px"></div>
                    </div>

                    <div class="mb-3 d-flex">
                        <div class="col-5" style="height: 40px">
                            <h5>Loại Sản Phẩm : </h5>
                        </div>
                        <div class="col-4" style="height: 40px">
                            <select id="productCateIdField" class="form-select" name="category_id">
                                <option value="0" class="text-center">Loại Sản Phẩm</option>
                                @if(count($categoriesList) > 0)
                                    @foreach($categoriesList as $key => $value)
                                        <option value="{{$value->id}}">{{$value->name}}</option>
                                    @endforeach
                                @else
                                    <option value="1">Nước Ngọt</option>
                                    <option value="2">Beer</option>
                                    <option value="3">Thức Ăn</option>
                                @endif
                            </select>
                        </div>
                        <div class="col-3" style="height: 40px"></div>
                    </div>

                    <div class="mb-3 d-flex">
                        <div class="col-5" style="height: 40px">
                            <h5>Giá Tiền : </h5>
                        </div>
                        <div class="col-4" style="height: 40px">
                            <input id="productPriceField" style="border: 1px solid #000;" class="form-control"
                                   type="text"
                                   name="price">
                        </div>
                        <div class="col-3" style="height: 40px"></div>
                    </div>

                    <button type="submit" class="btn btn-primary">Xác nhận</button>
                    @csrf
                    <br>

                </form>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <h3>Quản Lý Danh Mục Sản Phẩm</h3>
        <div class="col-7 shadow p-3 mb-5 bg-white rounded">
            <button onclick="showFormAddCategories()" class="btn btn-sm btn-primary mb-2">Thêm Danh Mục</button>
            @if(count($categoryList)>0)
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th class="text-center">STT</th>
                        <th>Tên Danh Mục</th>
                        <th>Ngày Nhập</th>
                        <th>Chức Năng</th>
                    </tr>
                    </thead>
                    @foreach($categoryList as $key => $value)
                        <tbody>
                        <tr>
                            <th class="text-center">{{$key + 1}}</th>
                            <td>{{$value->name}}</td>
                            <td>{{formatDateTime($value->created_at) ?? 'Chưa cập nhật ngày'}}</td>
                            <td>
                                <a onclick="editCategories( {{$value->id}},
                                <?php
                                     $name = "'".$value->name."'";
                                     echo $name;
                                     ?>
                                )"
                                   class="btn btn-warning btn-sm">Sửa</a>

                                <a onclick="return confirm('Bạn chắc chắn muốn xóa loại : {{$value->name}} không? ')"
                                   href="{{route('billiard.delete-category',['id'=>$value->id])}}"
                                   class="btn btn-danger btn-sm">Xóa</a>
                            </td>
                        </tr>
                        </tbody>
                    @endforeach
                </table>
                {{$categoryList->links()}}
            @else
                <div class="text-danger text-center">
                    <h1>Chưa có danh mục sản phẩm.</h1>
                </div>
            @endif
        </div>
        <div class="col-5 shadow p-3 mb-5 bg-white rounded">
            <div id="form-create-categories" class="form-create-categories" style="display: none">
                <h3>Thêm Danh Mục</h3>

                <form action="{{route('billiard.add-new-category')}}" method="post">

                    <div class="mb-3 d-flex">
                        <div class="col-5" style="height: 40px">
                            <h5>Tên Danh Mục : </h5>
                        </div>
                        <div class="col-4" style="height: 40px">
                            <input style="border: 1px solid #000;" class="form-control" type="text"
                                   name="name">
                        </div>
                        <div class="col-3" style="height: 40px"></div>
                    </div>

                    <div class="row">
                        <h5 class="text-danger mr-2">Bạn Chắc Chắc Thêm Bàn mới không?</h5>
                    </div>

                    <button type="submit" class="btn btn-primary">Xác nhận</button>
                    @csrf
                    <br>

                </form>
            </div>
            <div id="form-edit-categories" class="form-edit-categories" style="display: none">
                <h3>Sửa Thông Tin Bàn</h3>
                <form action="{{route('billiard.edit-category')}}" method="post">
                    <input style="border: 1px solid #000;" id="idCategoriesField" class="form-control" type="hidden"
                           name="id">
                    <div class="mb-3 d-flex">
                        <div class="col-5" style="height: 40px">
                            <h5>Tên Loại Bàn : </h5>
                        </div>
                        <div class="col-4" style="height: 40px">
                            <input style="border: 1px solid #000;" id="nameCategoriesField" class="form-control"
                                   type="text"
                                   name="name">
                            @error('name')
                            <p class="text-danger"> {{$message}}</p>
                            @enderror
                        </div>
                        <div class="col-3" style="height: 40px"></div>
                    </div>

                    <button type="submit" class="btn btn-primary">Xác nhận</button>
                    @csrf
                    <br>

                </form>
            </div>
        </div>
    </div>

@endsection
@section('js')
    <script>
        function showForm() {
            $(".form-order").slideToggle();
        }

        function editBilliard(id, idBilliardType, status, startTime, endTime) {
            $(".form-edit").slideToggle();
            $("#id").val(id);
            $("#idField").val(idBilliardType);
            $("#statusField").val(status);
            $("#startTimeField").val(startTime);
            $("#endTimeField").val(endTime);
        }

        function showFormAddBilliardType() {
            $(".form-create-billiard-type").slideToggle();
        }

        function editBilliardType(id, name, price) {
            $("#idTypeField").val(id);
            $("#nameField").val(name);
            $("#priceField").val(price);
            $(".form-edit-billiard-type").slideToggle();
        }

        function showFormAddProduct() {
            $(".form-create-product").slideToggle();
        }

        function editProduct(id, name, cateId, price) {
            $("#idProductField").val(id);
            $("#productNameField").val(name);
            $("#productCateIdField").val(cateId);
            $("#productPriceField").val(price);
            $(".form-edit-product").slideToggle();
        }


        function showFormAddCategories() {
            $(".form-create-categories").slideToggle();
        }

        function editCategories(id, name) {
            $("#idCategoriesField").val(id);
            $("#nameCategoriesField").val(name);
            $(".form-edit-categories").slideToggle();
        }

        document.addEventListener('DOMContentLoaded', function () {
            var scrollPosition = "{{ Session::get('scroll_position') }}";
            if (scrollPosition) {
                window.location.href = scrollPosition + '#your-anchor-id';
            }
        });
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
@endsection
