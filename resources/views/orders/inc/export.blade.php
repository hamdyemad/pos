<table>
    <thead>
        <tr>
            <td>index</td>
            <td>date</td>
            <td>order number</td>
            <td>name</td>
            <td>customer type</td>
            <td>phone</td>
            <td>phone2</td>
            <td>address</td>
            <td>qty's</td>
            <td>payment method</td>
            <td>branch</td>
            <td>type</td>
            <td>status</td>
            @if($order_type)
                <td>employee name</td>
                <td>pincode</td>
                <td>approved</td>
            @endif
            <td>discount</td>
            <td>shipping</td>
            <td>coupon</td>
            <td>total</td>
            <td>total after discount</td>
            <td>notes</td>
        </tr>
    </thead>
    <tbody>
        @foreach ($orders as $order)
            @php
                if($order->discount_type == 'percent') {
                    if($order->total_discount > 0) {
                        $num =  $order->grand_total / (100-$order->total_discount) * 100;
                        $discount = $num * ($order->total_discount / 100);
                    }
                } else {
                    $discount = $order->total_discount;
                }
            @endphp
            <tr>
                <td>{{ $loop->index + 1 }}</td>
                <td>{{ \Carbon\Carbon::createFromDate($order->created_at)->format('Y-m-d') }}</td>
                <td>{{ $order->id }}</td>
                @if($order->customer)
                    <td>{{ $order->customer->name }}</td>
                    <td>{{ $order->customer->type }}</td>
                    <td>{{ $order->customer->phone }}</td>
                    <td>{{ $order->customer->phone2 }}</td>
                    <td>{{ $order->customer->address }}</td>
                @else
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                @endif
                <td>{{ $order->order_details()->pluck('qty')->sum() }}</td>
                <td>{{ $order->payment_method }}</td>
                <td>
                    @if($order->branch)
                        {{ $order->branch->name }}
                    @endif
                </td>
                <td>{{ $order->type }}</td>
                <td>{{ $order->status->name }}</td>
                @if($order_type)
                    <td>{{ App\User::where('bin_code', $order->bin_code)->first()->name }}</td>
                    <td>{{ $order->bin_code }}</td>
                    <td>
                        @if($order->under_approve)
                            unapproved
                        @else
                            approved
                        @endif
                    </td>
                @endif
                <td>
                    {{ $discount }}
                </td>
                <td>{{ $order->shipping }}</td>
                <td>
                    @if($order->coupon)
                        {{ $order->coupon->code }}
                    @else
                        لا يوجد
                    @endif
                </td>
                <td>{{ $order->grand_total + $discount }}</td>
                <td>{{ $order->grand_total }}</td>
                <td>{{ $order->notes }}</td>
            </tr>
        @endforeach
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            @if($order_type)
                <td></td>
                <td></td>
                <td></td>
            @endif
            <td>{{ $orders->pluck('grand_total')->sum() }}</td>
        </tr>
    </tbody>
</table>
