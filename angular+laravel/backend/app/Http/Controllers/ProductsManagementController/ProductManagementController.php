<?php

namespace App\Http\Controllers\ProductsManagementController;

use App\Http\Controllers\Controller;
use App\Http\Requests\BilliardTypeRequest;
use App\Http\Requests\ProductRequest;
use App\Repositories\Categories\CategoriesRepository;
use App\Repositories\Management\ManagementRepository;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ProductManagementController extends Controller
{
    const TABLE_BILLIARD = 'billiards';
    const TABLE_ATTACH_FACILITY = 'attach_facility';
    const TABLE_BILLIARD_TYPE = 'billiards_type';
    const TABLE_BILLIARD_DETAIL = 'billiard_details';
    const TABLE_CATEGORY = 'categories';
    const TABLE_ORDER = 'order';
    protected $managementRepo;
    protected $categoriesRepository;


    private const _PER_PAGE_BILLIARD = 3;
    private const _PER_PAGE_BILLIARD_TYPE = 3;
    private const _PER_PAGE_PRODUCT = 5;
    private const _PER_PAGE_CATEGORY = 3;
    private const _PER_PAGE_HISTORY = 10;
    private const _PER_PAGE_ORDER = 10;

    public function __construct(
        ManagementRepository $managementRepository,
        CategoriesRepository $categoriesRepository
    )
    {
        $this->managementRepo = $managementRepository;
        $this->categoriesRepository = $categoriesRepository;
    }

    public function index()
    {
        $categoriesList = $this->categoriesRepository->getAllCategories();

        $selectColumnBilliards = ['id', 'billiard_type_id', 'status', 'start_time', 'end_time'];
        $billiardList = $this->managementRepo->showList(self::TABLE_BILLIARD, $selectColumnBilliards, self::_PER_PAGE_BILLIARD);

        $selectColumnBilliardTypes = ['id', 'name', 'price', 'created_at'];
        $billiardTypeList = $this->managementRepo->showList(self::TABLE_BILLIARD_TYPE, $selectColumnBilliardTypes, self::_PER_PAGE_BILLIARD_TYPE);

        $selectColumnProducts = ['id', 'category_id', 'name', '	price', 'created_at'];
        $productsList = $this->managementRepo->showList(self::TABLE_ATTACH_FACILITY, $selectColumnProducts, self::_PER_PAGE_PRODUCT);

        $selectColumnCategories = ['id', 'name', 'created_at'];
        $categoryList = $this->managementRepo->showList(self::TABLE_CATEGORY, $selectColumnCategories, self::_PER_PAGE_CATEGORY);

        return view('admins.products.index', compact('billiardList',
            'billiardTypeList',
            'productsList',
            'categoriesList',
            'categoryList',
        ));
    }

    public function addNewBilliard(Request $request)
    {
        $table = self::TABLE_BILLIARD;
        $data = [
            "billiard_type_id" => +$request->billiard_type_id,
            "status" => 0,
            "start_time" => $request->start_time,
            "end_time" => $request->end_time
        ];
        if (!empty($data)) {
            $flag = $this->managementRepo->createObject($table, $data);
            if ($flag) {
                $msg = 'Thêm mới thành công.';
                $status = 'success';
            } else {
                $msg = 'Thêm mới không thành công.';
                $status = 'error';
            }
        } else {
            $msg = 'Bạn không thể thêm mới lúc này. Vui lòng kiểm tra lại.';
            $status = 'error';
        }
        alert()->$status($msg);
        return redirect()->back();
    }

    public function editNewBilliard(Request $request)
    {
        $table = 'billiards';
        if (!empty($request->all())) {
            $data = [
                "billiard_type_id" => $request->billiard_type_id,
                "status" => $request->status,
                "id" => $request->id,
                "start_time" => $request->start_time,
                "end_time" => $request->end_time,
            ];
            $flag = $this->managementRepo->editObject($table, $data);
            if ($flag) {
                $msg = 'Sửa thông tin thành công.';
                $status = 'success';
            } else {
                $msg = 'Sửa thông tin không thành công. Vui lòng kiểm tra lại.';
                $status = 'error';
            }
        } else {
            $msg = 'Xin vui lòng nhập thông tin.';
            $status = 'warning';
        }
        alert()->$status($msg);
        Session::put('scroll_position', url()->previous());
        return redirect()->back();
    }

    public function addNewBilliardType(BilliardTypeRequest $request)
    {
        $table = self::TABLE_BILLIARD_TYPE;

        if (!empty($request->all())) {
            $data = [
                "name" => $request->name,
                "price" => $request->price,
            ];
            $flag = $this->managementRepo->createObject($table, $data);
            if ($flag) {
                $msg = 'Thêm thông tin thành công.';
                $status = 'success';
            } else {
                $msg = 'Thêm thông tin không thành công. Vui lòng kiểm tra lại.';
                $status = 'error';
            }
        } else {
            $msg = 'Xin vui lòng nhập thông tin.';
            $status = 'warning';
        }
        alert()->$status($msg);
        Session::put('scroll_position', url()->previous());
        return redirect()->back();

    }

    public function editNewBilliardType(BilliardTypeRequest $request)
    {
        $table = self::TABLE_BILLIARD_TYPE;

        if (!empty($request->all())) {
            $data = [
                "name" => $request->name,
                "price" => $request->price,
                "id" => $request->id,
            ];
            $checkExits = $this->managementRepo->checkExit($table, $request->id);
            if ($checkExits) {
                $flag = $this->managementRepo->editObject($table, $data);
                if ($flag) {
                    $msg = 'Sửa thông tin thành công.';
                    $status = 'success';
                } else {
                    $msg = 'Sửa thông tin không thành công. Vui lòng kiểm tra lại.';
                    $status = 'error';
                }
            } else {
                $msg = 'Liên kết không đúng. Vui lòng kiểm tra lại.';
                $status = 'error';
            }
        } else {
            $msg = 'Xin vui lòng nhập thông tin.';
            $status = 'warning';
        }
        alert()->$status($msg);
        return redirect()->back();
    }

    public function deleteBilliardType(Request $request)
    {
        $table = self::TABLE_BILLIARD_TYPE;

        $id = $request->id;
        if (!empty($id)) {
            $check = $this->managementRepo->checkExit($table, $id);
            if ($check) {
                $flag = $this->managementRepo->deleteObject($table, $id);
                if ($flag) {
                    $msg = 'Xóa thành công.';
                    $status = 'success';
                } else {
                    $msg = 'Bạn không thế xóa người dùng lúc này. Vui lòng kiển tra lại.';
                    $status = 'error';
                }
            } else {
                $msg = 'Người dùng không tồn tại.';
                $status = 'error';
            }
        } else {
            $msg = 'Liên kết không tồn tại.';
            $status = 'error';
        }
        alert()->$status($msg);
        return redirect()->back();
    }

    public function addProduct(ProductRequest $request)
    {
        $table = self::TABLE_ATTACH_FACILITY;

        if (!empty($request->all())) {
            $data = [
                "name" => $request->name,
                "price" => $request->price,
                "category_id" => $request->category_id,
            ];

            $flag = $this->managementRepo->createObject($table, $data);
            if ($flag) {
                $msg = 'Thêm sản phẩm thành công.';
                $status = 'success';
            } else {
                $msg = 'Thêm sản phẩm không thành công. Vui lòng kiểm tra lại.';
                $status = 'error';
            }
        } else {
            $msg = 'Xin vui lòng nhập thông tin.';
            $status = 'warning';
        }
        alert()->$status($msg);
        Session::put('scroll_position', url()->previous());
        return redirect()->back();
    }

    public function editProduct(ProductRequest $request)
    {
        $table = self::TABLE_ATTACH_FACILITY;

        if (!empty($request->all())) {
            $data = [
                "name" => $request->name,
                "price" => $request->price,
                "id" => $request->id,
                "category_id" => $request->category_id,
            ];
            $checkExits = $this->managementRepo->checkExit($table, $request->id);
            if ($checkExits) {
                $flag = $this->managementRepo->editObject($table, $data);
                if ($flag) {
                    $msg = 'Sửa thông tin thành công.';
                    $status = 'success';
                } else {
                    $msg = 'Sửa thông tin không thành công. Vui lòng kiểm tra lại.';
                    $status = 'error';
                }
            } else {
                $msg = 'Liên kết không đúng. Vui lòng kiểm tra lại.';
                $status = 'error';
            }
        } else {
            $msg = 'Xin vui lòng nhập thông tin.';
            $status = 'warning';
        }
        alert()->$status($msg);
        return redirect()->back();
    }

    public function deleteProduct(Request $request)
    {
        $table = self::TABLE_ATTACH_FACILITY;

        $id = $request->id;
        if (!empty($id)) {
            $check = $this->managementRepo->checkExit($table, $id);
            if ($check) {
                $flag = $this->managementRepo->deleteObject($table, $id);
                if ($flag) {
                    $msg = 'Xóa thành công.';
                    $status = 'success';
                } else {
                    $msg = 'Bạn không thế xóa người dùng lúc này. Vui lòng kiển tra lại.';
                    $status = 'error';
                }
            } else {
                $msg = 'Người dùng không tồn tại.';
                $status = 'error';
            }
        } else {
            $msg = 'Liên kết không tồn tại.';
            $status = 'error';
        }
        alert()->$status($msg);
        return redirect()->back();
    }

    public function addCategory(Request $request)
    {
        $table = self::TABLE_CATEGORY;

        if (!empty($request->all())) {
            $data = [
                "name" => $request->name
            ];

            $flag = $this->managementRepo->createObject($table, $data);
            if ($flag) {
                $msg = 'Thêm sản phẩm thành công.';
                $status = 'success';
            } else {
                $msg = 'Thêm sản phẩm không thành công. Vui lòng kiểm tra lại.';
                $status = 'error';
            }
        } else {
            $msg = 'Xin vui lòng nhập thông tin.';
            $status = 'warning';
        }
        alert()->$status($msg);
        Session::put('scroll_position', url()->previous());
        return redirect()->back();
    }

    public function editCategory(Request $request)
    {
        $table = self::TABLE_CATEGORY;

        if (!empty($request->all())) {
            $data = [
                "name" => $request->name,
                "id" => $request->id,
            ];
            $checkExits = $this->managementRepo->checkExit($table, $request->id);
            if ($checkExits) {
                $flag = $this->managementRepo->editObject($table, $data);
                if ($flag) {
                    $msg = 'Sửa thông tin thành công.';
                    $status = 'success';
                } else {
                    $msg = 'Sửa thông tin không thành công. Vui lòng kiểm tra lại.';
                    $status = 'error';
                }
            } else {
                $msg = 'Liên kết không đúng. Vui lòng kiểm tra lại.';
                $status = 'error';
            }
        } else {
            $msg = 'Xin vui lòng nhập thông tin.';
            $status = 'warning';
        }
        alert()->$status($msg);
        return redirect()->back();

    }

    public function deleteCategory(Request $request)
    {
        $table = self::TABLE_CATEGORY;

        $id = $request->id;
        if (!empty($id)) {
            $check = $this->managementRepo->checkExit($table, $id);
            if ($check) {
                $flag = $this->managementRepo->deleteObject($table, $id);
                if ($flag) {
                    $msg = 'Xóa thành công.';
                    $status = 'success';
                } else {
                    $msg = 'Bạn không thế xóa người dùng lúc này. Vui lòng kiển tra lại.';
                    $status = 'error';
                }
            } else {
                $msg = 'Người dùng không tồn tại.';
                $status = 'error';
            }
        } else {
            $msg = 'Liên kết không tồn tại.';
            $status = 'error';
        }
        alert()->$status($msg);
        return redirect()->back();
    }


    public function dashboard()
    {
        $title = 'Dashboard';

        $selectColumnOrder = [
            self::TABLE_ORDER . '.' . 'billiard_id',
            self::TABLE_ORDER . '.' . 'code_billiard',
            self::TABLE_ORDER . '.' . 'id ',
            self::TABLE_ORDER . '.' . 'created_at',
            self::TABLE_ORDER . '.' . 'updated_at',
        ];

        $orderListHistory = $this->managementRepo->listOrder(self::TABLE_ORDER, $selectColumnOrder, self::_PER_PAGE_ORDER);
        return view('admins.dashboards.dashboard', compact(
            'title',
            'orderListHistory'
        ));
    }

    function dashboardDetail(Request $request)
    {
        $title = 'Lịch Sử Chi Tiết';
        if (!empty($request->id) && $request->code) {
            $id = $request->id;
            $codeOrder = $request->code;
        } else {
            alert()->error('Khong tim thay tong tin');
        }

        $selectColumn = [
            self::TABLE_BILLIARD_DETAIL . '.' . 'id as idOrder',
            self::TABLE_BILLIARD_DETAIL . '.' . 'order_id',
            self::TABLE_BILLIARD_DETAIL . '.' . 'attach_facility_id',
            self::TABLE_BILLIARD_DETAIL . '.' . 'quantity',
            self::TABLE_BILLIARD_DETAIL . '.' . 'code_order',
            self::TABLE_BILLIARD_DETAIL . '.' . 'created_at',
            self::TABLE_BILLIARD_DETAIL . '.' . 'updated_at',
            self::TABLE_ATTACH_FACILITY . '.' . 'name as productName',
            self::TABLE_ATTACH_FACILITY . '.' . 'price as productPrice',
            self::TABLE_CATEGORY . '.' . 'name as categoryName',
            self::TABLE_ORDER . '.' . 'billiard_id',
            self::TABLE_BILLIARD . '.' . 'billiard_type_id',
        ];

        if (!empty($id)) {
            $check = $this->managementRepo->checkExit(self::TABLE_ORDER, $id);
            if ($check) {
                $listOrderDetail = $this->managementRepo->historyList(self::TABLE_BILLIARD_DETAIL, $selectColumn, $codeOrder);
                $total = 0;
                foreach ($listOrderDetail as $value) {
                    $total += ($value->productPrice * $value->quantity);
                }
                $orderDetail = $listOrderDetail[0];
                $hourTotal = getTotalTimeActive($orderDetail);

                if (count($listOrderDetail) > 0) {
                    $listOrderDetails = $listOrderDetail;
                } else {
                    alert()->info('Khong su dung dich vu');
                    return back();
                }
            } else {
                $msg = 'khong co don hang chi tiet';
                $status = 'warning';
                alert()->$status($msg);
            }
        } else {
            $msg = 'Khong tim thay thong tin';
            $status = 'error';
            alert()->$status($msg);
        }

        return view('admins.dashboards.dashboard-details', compact('title', 'listOrderDetails', 'total', 'hourTotal'));
    }
}
