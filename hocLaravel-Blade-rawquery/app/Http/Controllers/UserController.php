<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    private $users;

    public function __construct()
    {
        $this->users = new Users();
    }

    public function index()
    {
        $title = 'Danh sach nguoi dung';

        $usersList = $this->users->getAllUsers();

        return view('clients.users.list', compact('title', 'usersList'));
    }

    public function add()
    {
        $title = 'Them nguoi dung';

        return view('clients.users.add', compact('title',));
    }

    public function postAdd(Request $request)
    {
        $request->validate([
            'fullname' => ['required', 'min:5'],
            'email' => ['required', 'email', 'unique:user']
        ], [
            'fullname.required' => 'Ho va ten ko duoc de trong.',
            'fullname.min' => 'Ho va ten it nhat co :min k tu.',
            'email.required' => 'Email khong duoc de trong.',
            'email.email' => 'Email khong dung dinh dang',
            'email.unique' => 'Email da ton tai tren he thong.'
        ]);
//        $dataInsert = [
//            $request->fullname,
//            $request->email,
//            $request->date('d-m-Y H:i:s')
//        ];

        $dataInsert = $request->all();

        $this->users->addUser($dataInsert);
        return redirect(route('users.index'))->with([
            'msg' => 'Them moi thanh cong.',
            'type' => 'success'
        ]);
    }

    public function getEdit(Request $request, $id = 0)
    {
        $title = 'Cap nhat nguoi dung';


        if (!empty($id)) {
            $user = $this->users->getDetail($id);
            if (!empty($user[0])) {
                $request->session()->put('id', $id);
                $user = $user[0];
            } else {
                redirect()->route('users.index')->with([
                    'msg' => 'Nguoi dung khong ton tai.',
                    'type' => 'danger'
                ]);
            }
        } else {
            redirect()->route('users.index')->with([
                'msg' => 'Lien ket khong ton tai.',
                'type' => 'danger'
            ]);
        }
        return view('clients.users.edit', compact('title', 'user'));
    }


    public function postEdit(Request $request)
    {
        $id = (session('id'));
        if (empty($id)) {
            return back()->with([
                'msg' => 'Lien ket khong ton tai',
                'type' => 'danger'
            ]);
        }
        $request->validate([
            'fullname' => ['required', 'min:5'],
            'email' => ['required', 'email', 'unique:user,email,' . $id]
        ], [
            'fullname . required' => 'Ho va ten ko duoc de trong . ',
            'fullname . min' => 'Ho va ten it nhat co :min k tu . ',
            'email . required' => 'Email khong duoc de trong . ',
            'email . email' => 'Email khong dung dinh dang',
            'email . unique' => 'Email da ton tai tren he thong . '
        ]);
        $data = $request->all();

        $this->users->updateUser($data, $id);

        return redirect()->route('users.index')->with([
            'msg' => 'Sua thanh cong.',
            'type' => 'success'
        ]);
    }

    public function delete($id = 0)
    {
        if (!empty($id)) {
            $user = $this->users->getDetail($id);
            if (!empty($user[0])) {
                $flagDelete = $this->users->deleteUser($id);
                if ($flagDelete) {
                    $msg = 'Xoa thanh cong.';
                    $type = 'success';
//                    return redirect()->route('users.index')->with([
//                        'msg' => 'Xoa thanh cong.',
//                        'type' => 'success'
//                    ]);
                } else {
                    $msg = 'Ban khong the xoa nguoi dung luc nay. Vui long thu lai.';
                    $type = 'danger';
//                    return redirect()->route('users.index')->with([
//                        'msg' => 'Ban khong the xoa nguoi dung ngay luc nay.',
//                        'type' => 'danger'
//                    ]);
                }
            } else {
                $msg = 'Nguoi dung khong ton tai';
                $type = 'danger';
            }
        }else{
            $msg = 'Lien ket khong ton tai';
            $type = 'danger';
        }
        return redirect()->route('users.index')->with(['msg' => $msg, 'type' => $type]);
    }
}
