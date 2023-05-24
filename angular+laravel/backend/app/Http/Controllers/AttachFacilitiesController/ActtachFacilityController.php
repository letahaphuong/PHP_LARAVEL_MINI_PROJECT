<?php

namespace App\Http\Controllers\AttachFacilitiesController;

use App\Http\Controllers\Controller;
use App\Repositories\BilliardDetails\BilliardDetailRepository;
use App\Repositories\Categories\CategoriesRepository;
use App\Repositories\Facilities\AttachFacilityRepository;
use App\Repositories\Orders\OrderRepository;
use Illuminate\Http\Request;

class ActtachFacilityController extends Controller
{
    protected $attachFacility;
    protected $orderRepository;

    protected $detailRepository;

    protected $categoriesRepository;

    private const _PER_PAGE = 8;
    public function __construct(
        AttachFacilityRepository $attachFacilityRepository,
        OrderRepository          $orderRepository,
        BilliardDetailRepository $detailRepository,
        CategoriesRepository     $categoriesRepository
    )
    {
        $this->attachFacility = $attachFacilityRepository;
        $this->orderRepository = $orderRepository;
        $this->detailRepository = $detailRepository;
        $this->categoriesRepository = $categoriesRepository;
    }

    public function showViewCreate(Request $request)
    {
        $categoriesList = $this->categoriesRepository->all();

        $filters = '';

        $keywords = '';


        if (!empty($request->category_id)) {
            $categoryID = $request->category_id;
            $filters =  $categoryID;
        }

        if (!empty($request->keywords)) {
            $keywords = $request->keywords;
        }
        $drinks = $this->attachFacility->getAllAttachFacilities($filters, $keywords, self::_PER_PAGE);
        return view('admins.billiards.add', compact('drinks', 'categoriesList'));
    }

    public function addFacilities(Request $request)
    {
        $idBilliard = session('id');

        $codeOrder = $this->orderRepository->getCodeBilliard($idBilliard);
//dd($codeOrder);
        $order = $this->orderRepository->findOrderById($idBilliard);

        $idAttachFacility = $request->id;

        $quantity = $request->quantity;

        $dataCheck = [
            'order_id' => $order->id,
            'attach_facility_id' => $idAttachFacility,
            'quantity' => $quantity,
            'code_order' => $codeOrder->code_billiard
        ];
//        dd($dataCheck, $request->all());

        $arrayId = [
            'attach_facility_id' => $idAttachFacility,
            'code_order' => $codeOrder->code_billiard,
            'order_id' => $order->id
        ];

        if (checkExists($dataCheck)) {
            $object = $this->detailRepository->getBilliardDetail($arrayId);
            $object->quantity = $object->quantity + $dataCheck['quantity'];
            $data = [
                'id' => $object->id,
                'order_id' => $object->order_id,
                'attach_facility_id' => $object->attach_facility_id,
                'quantity' => $object->quantity,
                'code_order' => $object->code_order
            ];
            $this->attachFacility->updateAttachFacility($data);

        } else {
            $data = [
                'order_id' => $order->id,
                'attach_facility_id' => $idAttachFacility,
                'quantity' => $quantity,
                'code_order' => $codeOrder->code_billiard
            ];
            $this->attachFacility->createAttachFacility($data);
        }

//        if ($flag) {
//            $msg = 'Them thanh cong!';
//            $status = 'success';
//        } else {
//            $msg = 'Them khong thanh cong!';
//            $status = 'danger';
//        }
        return back()->with([
//            'msg' => $msg,
//            'status' => $status
        ]);
    }
}
