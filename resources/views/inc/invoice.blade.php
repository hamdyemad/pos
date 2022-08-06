<div class="invoice">
    <div class="client_info">
        <div class="client_head">
            <div class="first">
                <h4 class="font-weight-bold">معلومات الطلب</h4>
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
                    <span>رقم الطلب</span>
                </div>
                <div class="second_line">
                    <span>{{ $order['id'] }}</span>
                    <i class="fas fa-mobile-alt"></i>
                </div>
            </div>
            <div class="info">
                <div class="first_line">
                    <i class="fas fa-money-bill-wave"></i>
                    <span>الدفع</span>
                </div>
                <div class="second_line">
                    @if($order->paid)
                        <span class="font-weight-bold text-success">{{ translate('paid') }}</span>
                    @else
                        <span class="font-weight-bold text-danger">{{ translate('unpaid') }}</span>
                    @endif
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
        @if($order['customer_name'])
            <div class="col-12 col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="m-0 font-weight-bold">العميل</h5>
                    </div>
                    <div class="card-body d-flex align-items-center">
                        {{-- <img src="{{ $order['customer']['avatar'] }}" alt="صورة العميل"> --}}
                        <div class="info_of_user">
                            <h3>{{ $order['customer_name']}}</h3>
                            <span>
                                @if($order['customer_phone'])
                                    <div class="mobile" style="direction: ltr">
                                        <a href="tel:+2{{ $order['customer_phone'] }}">
                                            <i class="fas fa-phone-alt"></i>
                                            <span>اتصال</span>
                                        </a>
                                        <span>{{ $order['customer_phone'] }}</span>
                                    </div>
                                    <a href="https://wa.me/+2{{ $order['customer_phone'] }}">
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
                    <h5 class="m-0 font-weight-bold">معلومات التوصيل</h5>
                    <form action="{{ route('orders.pdf',$order['id']) }}" target="_blank" method="GET">
                        <button class="btn btn-warning">
                            <i class="fas fa-truck"></i>
                            <span>اصدار بوليصة</span>
                        </button>
                    </form>
                </div>
                <div class="card-body d-flex align-items-center">
                    <div class="info_of_user">
                        <h3>{{ translate('order type') . ': ' . translate($order['type']) }}</h3>
                        <p class="m-0">{{ $order['customer_address'] }}</p>
                        @if($order['city'])
                            <h3>{{ $order['city']['name'] . ', ' . $order['city']['country']['name'] }}</h3>
                        @endif
                        <h3>{{ translate('order branch') . ': ' . translate($order->branch->name) }}</h3>
                        <h3>{{ translate('notes') . ': ' . $order->notes }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <table class="table products">
        <thead>
            <tr>
                <td><strong>{{ translate('food name') }}</strong></td>
                <td><strong>{{ translate('price') }}</strong></td>
                <td><strong>{{ translate('count') }}</strong></td>
                <td><strong>{{ translate('total price') }} </strong></td>
            </tr>
        </thead>
        <tbody>
            @if(isset($order->order_details->groupBy('variant_type')['']))
                @foreach ($order->order_details->groupBy('variant_type')[''] as $variant)
                    <tr>
                        <td>
                            <div class="media">
                                <img src="{{ asset(json_decode($variant->product->photos)[0]) }}" class="mr-3" alt="...">
                                <div class="media-body mt-2">
                                    <h3>{{ $variant->product->name }}</h3>
                                    <!-- Extras -->
                                    @if(isset($order->order_details->groupBy('variant_type')['extra']))
                                        @foreach ($order->order_details->groupBy('variant_type')['extra']->groupBy('product_id') as $product_id_from_extra => $val)
                                            @if($variant->product->id == $product_id_from_extra)
                                                @foreach ($val as $extra)
                                                    <div class="mb-2 box">
                                                        <div class="line">
                                                            <strong>{{ translate('extra') }} :</strong>
                                                            <span>{{ $extra->variant  }}</span>
                                                        </div>
                                                        <div class="line">
                                                            <strong>{{ translate('price') }} :</strong>
                                                            <span>{{ $extra->price  }}</span>
                                                        </div>
                                                        <div class="line">
                                                            <strong>{{ translate('quantity') }} :</strong>
                                                            <span>{{ $extra->qty  }}</span>
                                                        </div>
                                                        @if($extra->qty > 1)
                                                            <div class="line">
                                                                <strong>{{ translate('total price') }} :</strong>
                                                                <span>{{ $extra->total_price  }}</span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            @endif
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td>
                            <strong class="comp-title">{{ $order->currency->code . $variant->price }}</strong>
                            <ul class="mobile list-unstyled">
                                <li>{{ translate('price') }}</li>
                                <li>{{ $order->currency->code . $variant->price }}</li>
                            </ul>
                        </td>
                        <td>
                            <strong class="comp-title">{{ $variant->qty }}</strong>
                            <ul class="mobile list-unstyled">
                                <li>{{ translate('count') }}</li>
                                <li>{{ $variant->qty }}</li>
                            </ul>
                        </td>
                        <td>
                            <strong class="comp-title">{{ $order->currency->code . $variant->total_price }}</strong>
                            <ul class="mobile list-unstyled">
                                <li>{{ translate('total price') }}</li>
                                <li>{{ $order->currency->code . $variant->total_price }}</li>
                            </ul>
                        </td>
                    </tr>
                @endforeach
            @endif
            @if(isset($order->order_details->groupBy('variant_type')['size']))
                @foreach ($order->order_details->groupBy('variant_type')['size']->groupBy('product_id') as $product_id_from_size => $value)
                    @php
                        $product = App\Models\Product::find($product_id_from_size);
                    @endphp
                    <tr>
                        <td colspan="2">
                            <div class="media">
                                <img src="{{ asset(json_decode($product->photos)[0]) }}" class="mr-3" alt="...">
                                <div class="media-body">
                                  <h3>{{ $product->name }}</h3>
                                </div>
                            </div>
                            @foreach ($value as $variant)
                                <div class="mb-2 box">
                                    <div class="line">
                                        <strong>{{ translate('size') }} :</strong>
                                        <span>{{ $variant->variant  }}</span>
                                    </div>
                                    <div class="line">
                                        <strong>{{ translate('price') }} :</strong>
                                        <span>{{ $order->currency->code . $variant->price  }}</span>
                                    </div>
                                    <div class="line">
                                        <strong>{{ translate('quantity') }} :</strong>
                                        <span>{{ $variant->qty  }}</span>
                                    </div>
                                    @if($variant->qty > 1)
                                        <div class="line">
                                            <strong>{{ translate('total price') }} :</strong>
                                            <span>{{ $order->currency->code . $variant->total_price  }}</span>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                            @if(isset($order->order_details->groupBy('variant_type')['extra']))
                                @foreach ($order->order_details->groupBy('variant_type')['extra']->groupBy('product_id') as $product_id_from_extra => $val)
                                    @if($product_id_from_extra == $product_id_from_size)
                                        @foreach ($val as $variant)
                                            <div class="mb-2 box">
                                                <div class="line">
                                                    <strong>{{ translate('extra') }} :</strong>
                                                    <span>{{ $variant->variant  }}</span>
                                                </div>
                                                <div class="line">
                                                    <strong>{{ translate('price') }} :</strong>
                                                    <span>{{ $order->currency->code . $variant->price  }}</span>
                                                </div>
                                                <div class="line">
                                                    <strong>{{ translate('quantity') }} :</strong>
                                                    <span>{{ $variant->qty  }}</span>
                                                </div>
                                                @if($variant->qty > 1)
                                                    <div class="line">
                                                        <strong>{{ translate('total price') }} :</strong>
                                                        <span>{{ $order->currency->code . $variant->total_price  }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    @endif
                                @endforeach
                            @endif
                        </td>
                        <td>
                            <strong class="comp-title">{{ $value->pluck('qty')->sum() }}</strong>
                            <ul class="mobile list-unstyled">
                                <li>{{ translate('count') }}</li>
                                <li>{{ $value->pluck('qty')->sum() }}</li>
                            </ul>
                        </td>
                        <td>
                            <strong class="comp-title">{{ $order->currency->code . $value->pluck('total_price')->sum() }}</strong>
                            <ul class="mobile list-unstyled">
                                <li>{{ translate('total price') }}</li>
                                <li>{{ $order->currency->code . $value->pluck('total_price')->sum() }}</li>
                            </ul>
                        </td>
                    </tr>
                @endforeach
            @endif
            <tr>
                <td>
                    <ul class="mobile list-unstyled">
                        <li>{{ translate('total price withoud extras') }}</li>
                        @if(isset($order->order_details->groupBy('variant_type')['extra']))
                            <li>
                                {{  $order->currency->code . (($order->grand_total  - $order->shipping -  $order->order_details->groupBy('variant_type')['extra']->pluck('total_price')->sum()) + $order->total_discount) }}
                            </li>
                        @else
                            <li>
                                {{ $order->currency->code . (( $order->grand_total - $order->shipping) + $order->total_discount)  }}
                            </li>
                        @endif
                    </ul>
                </td>
                <td class="comp-td"></td>
                <td class="text-center comp-td">
                    <strong>{{ translate('total price withoud extras') }}</strong></td>
                @if(isset($order->order_details->groupBy('variant_type')['extra']))
                    <td class="comp-td"><strong>{{  $order->currency->code . (($order->grand_total  - $order->shipping -  $order->order_details->groupBy('variant_type')['extra']->pluck('total_price')->sum()) + $order->total_discount) }}</strong></td>
                @else
                    <td class="comp-td"><strong>{{ $order->currency->code . (( $order->grand_total - $order->shipping) + $order->total_discount)  }}</strong></td>
                @endif
            </tr>
            @if(isset($order->order_details->groupBy('variant_type')['extra']))
                <tr>
                    <td>
                        <ul class="mobile list-unstyled">
                            <li>{{ translate('total price of extras') }}</li>
                            <li>{{ $order->currency->code . $order->order_details->groupBy('variant_type')['extra']->pluck('total_price')->sum() }}</li>
                        </ul>
                    </td>
                    <td class="comp-td"></td>
                    <td class="text-center comp-td"> <strong>{{ translate('total price of extras') }}</strong></td>
                    <td class="comp-td"><strong>{{ $order->currency->code . $order->order_details->groupBy('variant_type')['extra']->pluck('total_price')->sum() }}</strong></td>
                </tr>
            @endif
            @if($order->shipping)
                <tr>
                    <td>
                        <ul class="mobile list-unstyled">
                            <li>{{ translate('shipping') }}</li>
                            <li>{{ $order->currency->code . $order->shipping }}</li>
                        </ul>
                    </td>
                    <td class="comp-td"></td>
                    <td class="text-center comp-td">
                        <strong>{{ translate('shipping') }}</strong></td>
                    <td class="comp-td"><strong>{{ $order->currency->code . $order->shipping }}</strong></td>
                </tr>
            @endif
            @if($order->total_discount)
                <tr>
                    <td>
                        <ul class="mobile list-unstyled">
                            <li>{{ translate('discount') }}</li>
                            <li>{{ $order->currency->code . $order->total_discount }}</li>
                        </ul>
                    </td>
                    <td class="comp-td"></td>
                    <td class="text-center comp-td">
                        <strong>{{ translate('discount') }}</strong></td>
                    <td class="comp-td"><strong>{{ $order->currency->code . $order->total_discount }}</strong></td>
                </tr>
            @endif
            <tr>
                <td>
                    <ul class="mobile list-unstyled">
                        <li>{{ translate('final price') }}</li>
                        <li>{{ $order->currency->code . $order->grand_total }}</li>
                    </ul>
                </td>
                <td class="comp-td"></td>
                <td class=" text-center comp-td">
                    <strong>{{ translate('final price') }}</strong></td>
                <td class="comp-td">
                   <strong>{{ $order->currency->code . $order->grand_total }}</strong></td>
            </tr>
        </tbody>
    </table>
</div>
