<?php

namespace App\Exports;

use App\Models\Order;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class OrderExport implements FromView
{

    protected $orders;
    protected $order_type;


    public function __construct($orders, $order_type)
    {
        $this->orders = $orders;
        $this->order_type = $order_type;
    }

    public function view(): View
    {
        return view('orders.inc.export', [
            'orders' => $this->orders,
            'order_type' => $this->order_type
        ]);
    }
}
