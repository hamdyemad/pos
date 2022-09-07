<div class="invoice">
    <div class="client_info">
        <div class="client_head">
            <div class="first">
                <h4 class="font-weight-bold">{{ translate('order information') }}</h4>
                @if (get_setting('logo'))
                    <img class="rounded" src="{{ asset(get_setting('logo')) }}" alt="">
                @else
                    <img class="rounded" src="{{ asset('/images/default.jpg') }}" alt="">
                @endif
            </div>
            @php
                $order_id = $order['id'];
                    \Storage::disk('public')->put('barcodes/' . $order_id . '.png',base64_decode(DNS1D::getBarcodePNG("$order_id", 'C128')));
            @endphp
            <img class="barcode" src="{{ asset('barcodes/' . $order_id . '.png') }}" alt="">
        </div>
        <div class="infos">
            <div class="info">
                <div class="first_line">
                    <i class="fas fa-hashtag"></i>
                    <span>{{ translate('order number') }}</span>
                </div>
                <div class="second_line">
                    <span class="pr-1">{{ $order['id'] }}</span>
                    <i class="fas fa-mobile-alt"></i>
                </div>
            </div>
            <div class="info">
                <div class="first_line">
                    <i class="fas fa-money-bill-wave"></i>
                    <span>الدفع</span>
                </div>
                <div class="second_line">
                    {{ $order->payment_method }}
                </div>
            </div>
            <div class="info">
                <div class="first_line">
                    <i class="far fa-calendar-alt"></i>
                    <span>تاريخ الطلب</span>
                </div>
                <div class="second_line">
                    @php
                        $date = \Carbon\Carbon::createFromDate($order['date']);
                    @endphp
                    <span>{{
                        $date->dayName . ' ' . $date->day . ' ' . $date->monthName . ' ' . $date->year. ' | '  . $date->format('H:i A')
                    }}</span>
                </div>
            </div>
            <div class="info">
                <div class="first_line">
                    <i class="fas fa-flag"></i>
                    <span>حالة الطلب</span>
                </div>
                <div class="second_line">
                    <span>
                        {{ ($order['status']['name']) }}
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="cards row mt-2 justify-content-between">
        @if($order->customer)
            <div class="col-12 col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="m-0 font-weight-bold">{{ translate('customer') }}</h5>
                    </div>
                    <div class="card-body d-flex align-items-center">
                        {{-- <img src="{{ $order['customer']['avatar'] }}" alt="صورة العميل"> --}}
                        <div class="info_of_user">
                            <h3>{{ $order->customer->name}}</h3>
                            <span>
                                @if($order->customer->phone)
                                    <div class="mobile" style="direction: ltr">
                                        <a href="tel:+2{{ $order->customer->phone }}">
                                            <i class="fas fa-phone-alt"></i>
                                            <span>اتصال</span>
                                        </a>
                                        <span>{{ $order->customer->phone }}</span>
                                    </div>
                                    <a href="https://wa.me/+2{{ $order->customer->phone }}">
                                        <i class="fab fa-whatsapp"></i>
                                        <span>واتساب</span>
                                    </a>
                                @endif
                                @if($order->customer->phone2)
                                    <div class="mobile" style="direction: ltr">
                                        <a href="tel:+2{{ $order->customer->phone2 }}">
                                            <i class="fas fa-phone-alt"></i>
                                            <span>اتصال</span>
                                        </a>
                                        <span>{{ $order->customer->phone2 }}</span>
                                    </div>
                                    <a href="https://wa.me/+2{{ $order->customer->phone2 }}">
                                        <i class="fab fa-whatsapp"></i>
                                        <span>واتساب</span>
                                    </a>
                                @endif
                                {{-- @if($order['customer']['email'])
                                    <a href="mailto:{{ $order['customer']['email'] }}">
                                        <i class="far fa-envelope"></i>
                                        <span>ايميل</span>
                                    </a>
                                @endif --}}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <div class="col-12 col-md-6">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="m-0 font-weight-bold">{{ translate('Delivery Information') }}</h5>
                    <div class="d-flex align-items-center">
                        @if(Auth::user()->role_type == 'online' || Auth::user()->type == 'admin' || Auth::user()->type == 'sub-admin')
                            <form action="{{ route('orders.pdf',$order['id']) }}" target="_blank" method="GET">
                                <input type="hidden" name="type" value="online">
                                <button class="btn btn-secondary">
                                    <i class="mdi mdi-file-pdf"></i>
                                    <span>{{ translate('online invoice') }}</span>
                                </button>
                            </form>
                        @endif
                        @if(Auth::user()->role_type == 'inhouse' || Auth::user()->type == 'admin' || Auth::user()->type == 'sub-admin')
                            <form class="ml-2" action="{{ route('orders.pdf',$order['id']) }}" target="_blank" method="GET">
                                <input type="hidden" name="type" value="pos">
                                <button class="btn btn-primary">
                                    <i class="mdi mdi-file-pdf"></i>
                                    <span>{{ translate('pos invoice') }}</span>
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
                <div class="card-body d-flex align-items-center">
                    <div class="info_of_user">
                        <h3>{{ translate('order type') . ': ' . translate($order['type']) }}</h3>
                        <p class="m-0">{{ $order['customer_address'] }}</p>
                        @if($order['city'])
                            <h3>{{ $order['city']['name'] . ', ' . $order['city']['country']['name'] }}</h3>
                        @endif
                        @if($order->branch)
                            <h3>{{ translate('order branch') . ': ' . translate($order->branch->name) }}</h3>
                        @endif
                        <h3>{{ translate('notes') . ': ' . $order->notes }}</h3>
                    </div>
                </div>
            </div>
        </div>

    <table class="table products">
        <thead>
            <tr>
                <th>{{ translate('product name') }}</th>
                <th>{{ translate('sizes') }}</th>
                <th>{{ translate('extras') }}</th>
                <th>{{ translate('price') }}</th>
                <th>{{ translate('qty') }}</th>
                <th>{{ translate('discount') }}</th>
                @can('orders.files')
                    <th>{{ translate('files') }}</th>
                @endcan
                <th>{{ translate('notes') }}</th>
                <th>{{ translate('total price') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->order_details as $order_detail)
                <tr>
                    <td>
                        <div class="media">
                            @if($order_detail->product->photos !== null)
                                <img src="{{ asset(json_decode($order_detail->product->photos)[0]) }}" class="mr-3" alt="...">
                            @else
                                <img src="{{ asset('/images/product_avatar.png') }}" class="mr-3" alt="...">
                            @endif
                            <div class="media-body mt-2">
                                <div class="">
                                    <h3 class="m-0 ml-2">{{ $order_detail->product->name }}</h3>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                        @if($order_detail->variant_type == 'size')
                            {{ $order_detail->variant }}
                        @endif
                    </td>
                    <td>
                        @if($order_detail->variant_type == 'extra')
                            {{ $order_detail->variant }}
                        @endif
                    </td>
                    <td>
                        {{ $order_detail->price }}
                    </td>
                    <td>
                        {{ $order_detail->qty }}
                    </td>
                    <td>
                        {{ $order_detail->discount }}
                    </td>
                    @can('orders.files')
                        <td>
                            @if($order_detail->files)
                                <ul class="all_files list-unstyled">
                                    @foreach (json_decode($order_detail->files) as $file)
                                        <li>
                                            <a class="w-100" target="_blank" href="{{ asset($file) }}">
                                                {{ $loop->index + 1 }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </td>
                    @endcan
                    <td>
                        {{ $order_detail->notes }}
                    </td>
                    <td>
                        {{ $order_detail->total_price }}
                    </td>
                </tr>
            @endforeach
            @if($order->shipping)
                <tr>
                    <td>
                        <ul class="mobile list-unstyled">
                            <li>{{ translate('shipping') }}</li>
                            <li>{{  $order->shipping }}</li>
                        </ul>
                    </td>
                    <td class="comp-td"></td>
                    <td class="comp-td"></td>
                    <td class="comp-td"></td>
                    <td class="comp-td"></td>
                    <td class="comp-td"></td>
                    <td class="text-center comp-td">
                        <strong>{{ translate('shipping') }}</strong></td>
                    <td class="comp-td"><strong>{{  $order->shipping }}</strong></td>
                </tr>
            @endif
            @if($order->total_discount)
                <tr>
                    <td>
                        <ul class="mobile list-unstyled">
                            <li>{{ translate('discount') }}</li>
                            @if($order->discount_type == 'percent')
                                <li>{{  '%' . $order->total_discount }}</li>
                            @else
                                <li>{{  $order->total_discount }}</li>
                            @endif
                        </ul>
                    </td>
                    <td class="comp-td"></td>
                    <td class="comp-td"></td>
                    <td class="comp-td"></td>
                    <td class="comp-td"></td>
                    <td class="comp-td"></td>
                    <td class="text-center comp-td">
                        <strong>{{ translate('discount') }}</strong></td>
                    <td class="comp-td">
                        @if($order->discount_type == 'percent')
                            <strong>{{  '%' . $order->total_discount }}</strong>
                        @else
                            <strong>{{  $order->total_discount }}</strong>
                        @endif
                    </td>
                </tr>
            @endif
            @if($order->coupon)
                <tr>
                    <td></td>
                    <td class="comp-td"></td>
                    <td class="comp-td"></td>
                    <td class="comp-td"></td>
                    <td class="comp-td"></td>
                    <td class="comp-td"></td>
                    <td class="comp-td text-center"><strong>{{ translate('coupon discount') }}</strong></td>
                    <td class="comp-td">
                        @if($order->coupon->type == 'price')
                            <strong>{{ $order->coupon->price }}</strong>
                        @else
                            <strong>{{ $order->coupon->price . '%' }}</strong>
                        @endif
                    </td>
                </tr>
            @endif
            <tr>
                <td>
                    <ul class="mobile list-unstyled">
                        <li>{{ translate('total price') }}</li>
                        <li>{{  $order->grand_total }}</li>
                    </ul>
                </td>
                <td class="comp-td"></td>
                <td class="comp-td"></td>
                <td class="comp-td"></td>
                <td class="comp-td"></td>
                <td class="comp-td"></td>
                <td class=" text-center comp-td">
                    <strong>{{ translate('total price') }}</strong></td>
                <td class="comp-td">
                   <strong>{{  $order->grand_total }}</strong></td>
            </tr>
        </tbody>
    </table>
</div>
