<?php

namespace App\Repositories;

use App\Models\BookingTransaction;
use App\Models\ProductTransaction;
use App\Repositories\Contracts\OrderRepositoryInterface;
use Illuminate\Support\Facades\Session;

class OrderRepository implements OrderRepositoryInterface
{
    public function createTransaction(array $data)
    {
        return ProductTransaction::create($data);
    }

    public function findByTrxIdAndPhoneNumber($bookingTrxId, $phoneNumber)
    {
        return ProductTransaction::where('booking_trx_id', $bookingTrxId)
            ->where('phone', $phoneNumber)
            ->first();
    }

    public function saveToSession(array $data)
    {
        session()->put('order_data', $data);
    }

    public function updateSessionData(array $data)
    {
        $orderData = session('order_data', []);
        $orderData = array_merge($orderData, $data);
        session(['order_data' => $orderData]);
    }

    public function getOrderDataFromSession()
    {
        return session()->get('order_data');
    }

    public function clearSession()
    {
        Session::forget('order_data');
    }
}
