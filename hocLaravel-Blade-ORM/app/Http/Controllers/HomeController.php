<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Info;
use App\Models\Phone;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Rules\Uppercase;

//use Illuminate\Support\Facades\DB;

use DB;

class HomeController extends Controller
{
    public $data = [];

    public function index()
    {
        $this->data['title'] = 'Dao tao lap trinh web';
        $this->data['message'] = 'Dang ky tai khoan thanh cong';

//        $user = DB::select('select * from `user` where email = :email',[
//            'email' => 'letahaphuong@gmail.com'
//        ]);
//        dd($user);

        return view('clients.home', $this->data);
    }

    public function products()
    {
        $this->data['title'] = 'San pham';
        $user = Users::with('phone')->where('phone_id','1');
//        $user1 = Info::with('user')->find(1);
        dd($user->phone) ;

        return view('clients.products', $this->data);
    }

    public function showFormCreate()
    {
        $this->data['title'] = 'Them San Pham';
        $this->data['errorMess'] = 'Vui long kiem tra lai du lieu';
        return view('clients.add', $this->data);
    }

    public function createProduct(ProductRequest $request)
    {
        $rules = [
            'product_name' => ['required', 'min:6'],
//            'product_name' => ['required', 'min:6', new Uppercase()],
            'product_price' => 'required | integer'
        ];
        $message = [
            'required' => 'Truong :attribute bat buoc nhap.',
            'min' => 'Truong :attribute khong duoc nho hon :min',
            'integer' => 'Truong :attribute phai la so.',
            'regex' => 'Truong :attribute khong dung dinh dang',

        ];

        $attributes = [
            'product_name' => 'Ten san pham',
            'product_price' => 'Gia san pham'
        ];

        // $valid = Validator::make($request->all(), $rules, $message, $attributes);

        // $valid->validate();

        $request->validate($rules, $message);

        return response()->json([
            'status' => 'success'
        ]);
//        if ($valid->fails()) {
//
//            $valid->errors()->add('msg', 'Vui long kiem tra lai du lieu');
////            return 'Validate That bai';
//        } else {
//            return redirect(route('product'))->with('msg', 'Them moi thanh cong');
////            return 'Validate thanh cong';
//        }
        return back()->withErrors($valid);
    }

//    public function createProduct(ProductRequest $request)
//    {
//        // VIET GOP
////        $request->validate([
////            'product_name' => 'required | min:6 | regex:/(^([a-zA-z]+)(\d+)?$)/u',
////            'product_price' => 'required | integer'
////        ], [
////                'product_name.required' => 'Ten san pham khong duoc de trong.',
////                'product_name.min' => 'Ten san pham khong duoc nho hon :min ki tu.',
////                'product_name.regex' => 'Ten san pham khong dung dinh dang.',
////                'product_price.required' => 'Gia san pham khong duoc de trong.',
////                'product_price.integer' => 'Gia chi duoc phep dien so.'
////            ]
////        );
//
//        // VIET RIENG
////        $rules = [
////            'product_name' => 'required | min:6 | regex:/(^([a-zA-z]+)(\d+)?$)/u',
////            'product_price' => 'required | integer'
////        ];
////        $message = [
////            'product_name.required' => 'Ten san pham khong duoc de trong.',
////            'product_name.min' => 'Ten san pham khong duoc nho hon :min ki tu.',
////            'product_name.regex' => 'Ten san pham khong dung dinh dang.',
////            'product_price.required' => 'Gia san pham khong duoc de trong.',
////            'product_price.integer' => 'Gia chi duoc phep dien so.'
////        ];
//
////        $message = [
////            'required'  => 'Truong :attribute bat buoc nhap.',
////            'min'       => 'Truong :attribute khong duoc nho hon :min',
////            'integer'   => 'Truong :attribute phai la so.',
////            'regex'     => 'Truong :attribute khong dung dinh dang'
////        ];
//
//        dd($request->all());
//        $request->validate($request->rules(), $request->messages());
//        // Xữ lý việc thêm dữ liệu vào Database
//
//    }

    public function putAdd(Request $request)
    {

        dd($request);
    }

    public function getArray()
    {
        $contentArr = [
            'name' => 'Laravel 8.x',
            'lesson' => 'Khoa hoc lap trinh la ra vel',
            'academy' => 'unicode'
        ];

        return $contentArr;
    }

    public function demo()
    {
        return view('clients.demo-test');
    }

    public function postDemo(Request $request)
    {
        if ($request->username) {
            return back()->withInput()->with(['mess' => 'Co Data', 'type' => 'success']);
        }
        return redirect()->route('demoNe')->with(['mess' => 'khong co Data', 'type' => 'danger']);
    }

    public function downloadImage(Request $request)
    {
        if (!empty($request->image)) {
            $image = trim($request->image);
//            $fileName = basename($image);
//            $fileName = 'image_' . uniqid() . '.jpg';
            $fileName = 'image_' . date('Y-m-d_H:i:s') . '.jpg';
            // <============ Dung Download Anh tu local ==============>

            return response()->download($image, $fileName);

            // <============ Dung Download Anh ko phari tu local ==============>
//            return response()->streamDownload(function () use ($image) {
//                $imageContent = file_get_contents($image);
//                echo $imageContent;
//            }, $fileName);
        }
        return false;
    }

    public function downLoadPdf(Request $request)
    {
        if (!empty($request->pdf)) {
            $pdf = trim($request->pdf);
            $baseName = basename($pdf);
            $fileName = 'file_' . $baseName . date('Y-m-d H:i:s') . '.pdf';

            return response()->download($pdf, $fileName);
        }
    }
}
