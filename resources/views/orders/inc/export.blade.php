<table>
    <thead>
        <tr>
            <td>index</td>
            <td>date</td>
            <td>order number</td>
            <td>discount</td>
            <td>shipping</td>
            <td>coupon</td>
            <td>total</td>
            <td>total after discount</td>
        </tr>
    </thead>
    <tbody>
        @foreach ($orders as $order)
            <tr>
                <td>{{ $loop->index + 1 }}</td>
                <td>{{ \Carbon\Carbon::createFromDate($order->created_at)->format('Y-m-d') }}</td>
                <td>{{ $order->id }}</td>
                <td>{{ $order->total_discount }}</td>
                <td>{{ $order->shipping }}</td>
                <td>
                    @if($order->coupon)
                        {{ $order->coupon->code }}
                    @else
                        لا يوجد
                    @endif
                </td>
                <td>{{ $order->grand_total + $order->total_discount }}</td>
                <td>{{ $order->grand_total }}</td>
            </tr>
        @endforeach
        <tr>
            <td>{{ $orders->count() }}</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>{{ $orders->pluck('grand_total')->sum() }}</td>
        </tr>
    </tbody>
</table>
