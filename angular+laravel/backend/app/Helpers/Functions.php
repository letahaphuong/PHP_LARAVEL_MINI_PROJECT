<?php

use App\Repositories\BilliardDetails\BilliardDetailRepositoryEloquent;
use Illuminate\Support\Facades\DB;

function getTotalTimeView($billiard)
{
//    dd($billiard->billiard_type_id);
    $start_time = formatTime($billiard->start_time);
    $end_time = now();
    $startDateTime = new DateTime($start_time);
    $endDateTime = new DateTime($end_time);
    $interval = $startDateTime->diff($endDateTime);
    $time = $interval->format('%H giờ, %i phút');
    $hour = +$interval->format('%H');
    $minute = +$interval->format('%i');

    switch ($billiard->billiard_type_id) {
        case 1:
            $price = 32000;
            break;
        case 2:
            $price = 35000;
            break;
        case 3:
            $price = 5000;
            break;
    }

    $total = ($hour + ($minute / 60)) * $price;

    return [$time, $total];
}

function getTotalTimeActive($value)
{
//    dd($billiard->billiard_type_id);
    $start_time = formatTime($value->created_at);
    $end_time = formatTime($value->updated_at);

    $startDateTime = new DateTime($start_time);
    $endDateTime = new DateTime($end_time);
    $interval = $startDateTime->diff($endDateTime);
    $time = $interval->format('%H giờ, %i phút');

    $hour = +$interval->format('%H');
    $minute = +$interval->format('%i');

    switch ($value->billiard_type_id) {
        case 1:
            $price = 32000;
            break;
        case 2:
            $price = 35000;
            break;
        case 3:
            $price = 5000;
            break;
    }

    $total = ($hour + ($minute / 60)) * $price;

    return [$time, $total];
}

function getTotalAttachView($data)
{
    $total = 0;
    foreach ($data as $item) {
        $total += ($item->quantity * $item->price);
    }
    return $total;
}

function getTotal($request)
{
    $start_time = formatTime($request->start_time);
    $end_time = formatTime($request->end_time);
    $startDateTime = new DateTime($start_time);
    $endDateTime = new DateTime($end_time);
    $interval = $startDateTime->diff($endDateTime);
    $hour = $interval->format('%h');
    $minute = $interval->format('%i');
    return [
        'hour' => $hour,
        'minute' => $minute
    ];
}


function formatTime($value)
{
    $data = str_split($value);
    $array = str_replace("T", " ", $data);
    $string = implode("", $array);
    return $string;
}

function checkExists($data)
{


//    $billiardRepo = new BilliardDetailRepositoryEloquent();
    $attachFacilityIdExits = DB::table('billiard_details')
        ->select('attach_facility_id')
        ->where('attach_facility_id', $data['attach_facility_id'])
        ->where('order_id', $data['order_id'])
        ->where('code_order', '=', $data['code_order'])
        ->exists();
//    $orderIdExits = DB::table('billiard_details')
//        ->select('order_id')
//        ->where('order_id', $data['order_id'])
//        ->exists();
//    $orderCodeExits = DB::table('billiard_details')
//        ->select('code_order')
//        ->where('code_order', '=', $data['code_order'])
//        ->exists();dd($attachFacilityIdExits);

//    dd($attachFacilityIdExits, $data['attach_facility_id'],$orderIdExits, $data['order_id'],$orderCodeExits ,$data['code_order']);
    if ($attachFacilityIdExits) {
        return true;
    }
    return false;
}

function random()
{
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $length = 6;

    $randomString = '';
    $charactersLength = strlen($characters);

// Tạo chuỗi ngẫu nhiên
    for ($i = 0; $i < $length; $i++) {
        $randomChar = $characters[rand(0, $charactersLength - 1)];

        // Kiểm tra xem ký tự đã tồn tại trong chuỗi chưa
        while (strpos($randomString, $randomChar) !== false) {
            $randomChar = $characters[rand(0, $charactersLength - 1)];
        }

        $randomString .= $randomChar;
    }

    return $randomString;
}

function formatDateTime($dateTime)
{
    $dateFormat = formatTime($dateTime);
    $date = new DateTime($dateFormat);
    $dateTimeFinal = $date->format('d/m/Y H:i:s');
    return $dateTimeFinal;
}
