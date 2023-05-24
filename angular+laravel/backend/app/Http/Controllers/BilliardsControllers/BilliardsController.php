<?php

namespace App\Http\Controllers\BilliardsControllers;

use App\Http\Controllers\Controller;
use App\Repositories\BilliardDetails\BilliardDetailRepository;
use App\Repositories\Billiards\BilliardsRepository;
use App\Repositories\Orders\OrderRepository;
use DateTime;
use Illuminate\Http\Request;

class BilliardsController extends Controller
{
    protected $billiardsRepository;
    protected $orderRepository;

    protected $billiardDetailRepository;

    private const _PER_PAGE_ATTACH = 4;


    /**
     * @param $billiardsRepository
     */
    public function __construct(
        BilliardsRepository      $billiardsRepository,
        OrderRepository          $orderRepository,
        BilliardDetailRepository $billiardDetailRepository
    )
    {
        $this->billiardsRepository = $billiardsRepository;
        $this->orderRepository = $orderRepository;
        $this->billiardDetailRepository = $billiardDetailRepository;
    }

    public function home()
    {
        return view('admins.homes.home');
    }

    public function getAllTable()
    {
        $title = 'Danh sách bàn';
        $billiards = $this->billiardsRepository->index();

        return view('admins.billiards.index', compact('title', 'billiards'));
    }

    public function getBilliardTable(Request $request, $id = 0)
    {
        $title = 'Bat dau';

        if (!empty($id)) {
            $billiard = $this->billiardsRepository->getBilliardTable($id);
            if (!empty($billiard)) {
                $request->session()->put('id', $id);
            } else {
                redirect()->route('billiard.get-table')->with([
                    'msg' => 'Người dùng không tồn tại.',
                    'type' => 'danger'
                ]);
            }
        } else {
            redirect()->route('billiard.get-table')->with([
                'msg' => 'Liên kết không tồn tại.',
                'type' => 'danger'
            ]);
        }
        return view('admins.billiards.start', compact('title', 'billiard'));
    }

    public function createBilliardTable(Request $request)
    {
        $id = (session('id'));
        $codeRandom = 'BAN' . '-' . $id . '-' . date('H') . '-' . random();
        if (empty($id)) {
            return back()->with([
                'msg' => 'Liên kết không tồn tại',
                'type' => 'danger'
            ]);
        }

        $data = [
            'id' => $id,
            'billiard_type_id' => $request->billiard_type_id,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'status' => $request->status
        ];

        $orderData = [
            'billiard_id' => $id,
            'code_billiard' => $codeRandom
        ];

        $this->orderRepository->createOrder($orderData);

        $flagBilliardUpdate = $this->billiardsRepository->store($data, $id);

        if ($flagBilliardUpdate == 0 || $flagBilliardUpdate == 1) {
            $status = 'success';
            $title = ' thành công.';
        } else {
            $status = 'error';
            $title = 'không thành công.';
        }
        return redirect()->route('billiard.index')->with($status, $title);
    }


    public function getBilliardTableEnd(Request $request, $id = 0)
    {

        $title = 'Bắt đầu';
        if (!empty($id)) {
            $billiard = $this->billiardsRepository->getBilliardTable($id);

            $codeOrder = $this->orderRepository->getCodeBilliard($id);

            $getListAttachFacility = $this->billiardDetailRepository->getListBilliardDetails($codeOrder->code_billiard, self::_PER_PAGE_ATTACH);

            $viewTimePlayed = getTotalTimeView($billiard);

            $viewTotalFacilities = getTotalAttachView($getListAttachFacility);

            if (!empty($billiard)) {
                $request->session()->put('id', $id);
            } else {
                redirect()->route('billiard.get-table')->with([
                    'msg' => 'Người dùng không tồn tại.',
                    'type' => 'danger'
                ]);
            }
        } else {
            redirect()->route('billiard.get-table')->with([
                'msg' => 'Liên kết không tồn tại.',
                'type' => 'danger'
            ]);
        }

        return view('admins.billiards.end', compact('title', 'billiard', 'viewTimePlayed', 'getListAttachFacility', 'viewTotalFacilities'));
    }

    public function endBilliardTable(Request $request)
    {
        $id = (session('id'));
        if (empty($id)) {
            return back()->with([
                'msg' => 'Liên kết không tồn tại',
                'type' => 'danger'
            ]);
        }
        $data = [
            'id' => $id,
            'billiard_type_id' => $request->billiard_type_id,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'status' => 0
        ];

        $timePlayed = getTotal($request);
        $total = $timePlayed['hour'] + ($timePlayed['minute'] / 60);
        $flagUpdate = $this->billiardsRepository->store($data, $id);
        if ($flagUpdate == 0 || $flagUpdate == 1) {
            $status = 'success';
            $title = 'Sửa thông tin thành công.';
        } else {
            $status = 'error';
            $title = 'Sửa thông tin không thành công.';
        }

        return redirect()->route('billiard.index')->with([
            'status' => $status,
            'title' => $title,
            'total' => $total
        ]);
    }

    public function delete(Request $request)
    {
        $id = $request->id;
        if (!empty($id)) {
            $check = $this->billiardDetailRepository->checkExitsId($id);
            if ($check) {
                $flag = $this->billiardDetailRepository->deleteAttach($id);
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

    public function updateAttachDetails(Request $request)
    {
        $id = $request->id;

        if (!empty($id)) {
            $checkExits = $this->billiardDetailRepository->checkExitsId($id);
            if ($checkExits) {
                $object = $this->billiardDetailRepository->getBilliardDetailForUpdateQuantity($id);
                $object->quantity = $request->quantity;
                $data = [
                    'id' => $id,
                    'quantity' => $object->quantity
                ];
                $flag = $this->billiardDetailRepository->updatequantity($data);
                if ($flag) {
                    $msg = 'Thêm số lượng thành công.';
                    $status = 'success';
                } else {
                    $msg = 'Bạn không thế thêm số lượng ngay lúc này. Vui lòng kiển tra lại.';
                    $status = 'error';
                }
            } else {
                $msg = 'Người dùng không tồn tại.';
                $status = 'warning';
            }

        } else {
            $msg = 'Liên kết không tồn tại.';
            $status = 'error';
        }

        alert()->$status($msg);
        return redirect()->back();
    }

}
