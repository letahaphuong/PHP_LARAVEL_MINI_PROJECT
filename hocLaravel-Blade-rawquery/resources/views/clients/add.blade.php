@extends('layouts.client')
@section('content')
    <h1>Them moi san Pham</h1>
    <form action="{{route('post-add')}}" method="post" id="product_form">
        {{--        @if($errors->any())--}}
        {{--            <div class="alert alert-danger text-center">--}}
        {{--                {{ $errorMess }}--}}
        {{--            </div>--}}
        {{--        @endif--}}
        <div id="div1" class="alert alert-danger text-center msg" style="display: none;">
        </div>
        {{--        @error('msg')--}}
        {{--        <div class="alert alert-danger text-center">--}}
        {{--            {{$message}}--}}
        {{--        </div>--}}
        {{--        @enderror--}}
        <div class="mb-3">
            <label for="">Ten san pham</label>
            <input value="{{old('product_name')}}" type="text" name="product_name" placeholder="Product name...">
            {{--            @error('product_name')--}}
            {{--            <p class="text-danger" >{{ $message }}</p>--}}
            <p class="text-danger error product_name_error"></p>
            {{--            @enderror--}}
        </div>
        <div class="mb-3">
            <label for="">Gia san pham</label>
            <input value="{{old('product_price')}}" type="text" name="product_price" placeholder="Product price...">
            {{--            @error('product_price')--}}
            {{--            <p class="text-danger" class="product_price_error">{{$message}}</p>--}}
            <p class="text-danger error product_price_error"></p>
            {{--            @enderror--}}
        </div>
        @csrf
        <button type="submit" class="btn btn-primary">Them moi</button>
    </form>
@endsection

{{--@section('sidebar')--}}
{{--    @parent--}}
{{--    <h3>Product sidebar</h3>--}}
{{--@endsection--}}

@section('title')
    {{$title}}
@endsection

@section('css')
    {{--    --}}
@endsection

@section('js')
    <script>
        $(document).ready(function () {
            $('#product_form').on('submit', function (e) {
                e.preventDefault();
                let productName = $('input[name="product_name"]').val().trim();
                let productPrice = $('input[name="product_price"]').val().trim();
                let actionUrl = $(this).attr('action');
                let csrfToken = $(this).find('input[name="_token"]').val();
                $('.error').text('');

                $.ajax({
                    url: actionUrl,
                    type: 'POST',
                    data: {
                        product_name: productName,
                        product_price: productPrice,
                        _token: csrfToken
                    },
                    dataType: 'json',
                    success: function (response) {
                        console.log(response)
                    },
                    error: function (error) {


                        let responseJSON = error.responseJSON.errors;

                        if (responseJSON != null) {
                            $('.msg').text(responseJSON.msg).show();
                            for (let key in responseJSON) {
                                $('.' + key + '_error').text(responseJSON[key][0])
                            }
                        } else {
                            $('#div1').hide();
                        }
                    }
                })
            })
        })
    </script>
@endsection

