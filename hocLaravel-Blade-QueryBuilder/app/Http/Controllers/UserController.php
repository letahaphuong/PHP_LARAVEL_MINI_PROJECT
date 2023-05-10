<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Requests\UserRequest;

class UserController extends Controller
{
    private $users;
    private const _PER_PAGE = 3;

    public function __construct()
    {
        $this->users = new Users();
    }

    public function index(Request $request)
    {
//        $this->users->statementUser("delete from user");
        $title = 'Danh sách người dùng';

//        $this->users->learnQueryBuilder();
        $filters = [];

        $keywords = null;

        if (!empty($request->status)) {
            $status = $request->status;
            if ($status == 'active') {
                $status = 1;
            } else {
                $status = 0;
            }
            $filters[] = ['user.status', '=', $status];
        }

        if (!empty($request->group_id)) {
            $groupId = $request->group_id;
            $filters[] = ['user.group_id', '=', $groupId];
        }

        if (!empty($request->keywords)) {
            $keywords = $request->keywords;
        }


        $sortBy = $request->input('sortBy');

        $sortType = $this->makeLowerCase($request->input('sortType'));

        $allowSort = ['asc', 'desc'];

        if (!empty($sortType && in_array($sortType, $allowSort))) {
            if ($sortType == 'desc') {
                $sortType = 'asc';
            } else {
                $sortType = 'desc';
            }
        } else {
            $sortType = 'asc';
        }

        $sortArray = [
            'sortBy' => $sortBy,
            'sortType' => $sortType
        ];

        $usersList = $this->users->getAllUsers($filters, $keywords, $sortArray, self::_PER_PAGE);
//        dd($usersList[0]);
        return view('clients.users.list', compact('title', 'usersList', 'sortType'));
    }

    public function add()
    {
        $title = 'Thêm người dùng';

        return view('clients.users.add', compact('title',));
    }

    public function postAdd(UserRequest $request)
    {

        $dataInsert = $request->all();

        $flagCreate = $this->users->addUser($dataInsert);
        if ($flagCreate) {
            alert()->success('Thêm mới thành công.');
        } else {
            alert()->error( 'Thêm mới không thành công.');
        }
        return redirect(route('users.index'))->with([
            'msg' => 'Thêm mới thành công.',
            'type' => 'success'
        ]);
    }

    public function getEdit(Request $request, $id = 0)
    {
        $title = 'Cập nhật người dùng';


        if (!empty($id)) {
            $user = $this->users->getDetail($id);
            if (!empty($user[0])) {
                $request->session()->put('id', $id);
                $user = $user[0];
            } else {
                redirect()->route('users.index')->with([
                    'msg' => 'Người dùng không tồn tại.',
                    'type' => 'danger'
                ]);
            }
        } else {
            redirect()->route('users.index')->with([
                'msg' => 'Liên kết không tồn tại.',
                'type' => 'danger'
            ]);
        }
        return view('clients.users.edit', compact('title', 'user'));
    }


    public function postEdit(UserRequest $request)
    {
        $id = (session('id'));
        if (empty($id)) {
            return back()->with([
                'msg' => 'Liên kết không tồn tại',
                'type' => 'danger'
            ]);
        }

        $data = $request->all();

        $flagUpdate = $this->users->updateUser($data, $id);
        if ($flagUpdate == 0 || $flagUpdate == 1) {
            $status = 'success';
            $titel = 'Sửa thông tin thành công.';
        } else {
            $status = 'error';
            $titel = 'Sửa thông tin không thành công.';
        }
        toast()->$status($titel);
        return redirect()->route('users.index')->with([
            'msg' => 'Sửa thành công.',
            'type' => 'success'
        ]);
    }

    public function delete($id)
    {
        if (!empty($id)) {
            $user = $this->users->getDetail($id);
            if (!empty($user[0])) {
                $flagDelete = $this->users->deleteUser($id);
                if ($flagDelete) {
                    $msg = 'Xóa thành công.';
                    $type = 'success';
                    $status = 'success';
                } else {
                    $msg = 'Bạn không thế xóa người dùng lúc này. Vui lòng kiển tra lại.';
                    $type = 'danger';
                    $status = 'error';
//                    return redirect()->route('users.index')->with([
//                        'msg' => 'Ban khong the xoa nguoi dung ngay luc nay.',
//                        'type' => 'danger'
//                    ]);
                }
            } else {
                $msg = 'Người dùng không tồn tại.';
                $type = 'danger';
                $status = 'error';
            }
        } else {
            $msg = 'Liên kết không tồn tại.';
            $status = 'error';
            $type = 'danger';
        }
        toast()->$status('Thông báo', $msg);
        return redirect()->route('users.index')->with(['msg' => $msg, 'type' => $type]);
    }

    public function makeLowerCase($input)
    {
        if (!empty($input)) {
            $str = strtolower($input);
            return $str;
        }
        return false;

    }
}
