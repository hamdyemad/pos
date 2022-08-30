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
        {{-- <div class="col-12 col-md-6">
            <div class="card-header">
                <h5 class="m-0 font-weight-bold">{{ translate('all files') }}</h5>
            </div>
            <div class="card-body">
                    <ul class="all_files list-unstyled">
                        @foreach (json_decode($order->customized_files) as $customized_file)
                            <li>
                                <a target="_blank" href="{{ asset($customized_file) }}">
                                    {{ $loop->index + 1 }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div> --}}

    <table class="table products">
        <thead>
            <tr>
                <td><strong>{{ translate('product name') }}</strong></td>
                <td><strong>{{ translate('price') }}</strong></td>
                <td><strong>{{ translate('qty') }}</strong></td>
                <td><strong>{{ translate('discount') }}</strong></td>
                <td><strong>{{ translate('total price') }} </strong></td>
            </tr>
        </thead>
        <tbody>
            @if(isset($order->order_details->groupBy('variant_type')['']))
                @foreach ($order->order_details->groupBy('variant_type')[''] as $variant)
                    @if($variant)
                        <tr>
                            <td>
                                <div class="media">
                                    @if($variant->product->photos !== null)
                                        <img src="{{ asset(json_decode($variant->product->photos)[0]) }}" class="mr-3" alt="...">
                                    @else
                                        <img src="{{ asset('/images/product_avatar.png') }}" class="mr-3" alt="...">
                                    @endif
                                    <div class="media-body mt-2">
                                        <div class="d-flex align-items-center mb-1">
                                            <h3 class="m-0 ml-2">{{ $variant->product->name }}</h3>
                                        </div>
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
                                                                <strong>{{ translate('qty') }} :</strong>
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
                                <strong class="comp-title">{{  $variant->price }}</strong>
                                <ul class="mobile list-unstyled">
                                    <li>{{ translate('price') }}</li>
                                    <li>{{  $variant->price }}</li>
                                </ul>
                            </td>
                            <td>
                                <strong class="comp-title">{{ $variant->qty }}</strong>
                                <ul class="mobile list-unstyled">
                                    <li>{{ translate('qty') }}</li>
                                    <li>{{ $variant->qty }}</li>
                                </ul>
                            </td>
                            <td>
                                <strong class="comp-title">{{ $variant->discount }}</strong>
                                <ul class="mobile list-unstyled">
                                    <li>{{ translate('discount') }}</li>
                                    <li>{{ $variant->discount }}</li>
                                </ul>
                            </td>
                            <td>
                                <strong class="comp-title">{{  $variant->total_price }}</strong>
                                <ul class="mobile list-unstyled">
                                    <li>{{ translate('total price') }}</li>
                                    <li>{{  $variant->total_price }}</li>
                                </ul>
                            </td>
                        </tr>
                    @endif
                @endforeach
            @endif
            @if(isset($order->order_details->groupBy('variant_type')['size']))
                @foreach ($order->order_details->groupBy('variant_type')['size']->groupBy('product_id') as $product_id_from_size => $value)
                    @php
                        $product = App\Models\Product::find($product_id_from_size);
                    @endphp
                    @if($product)
                        <tr>
                            <td colspan="2">
                                <div class="media">
                                    @if($product->photos !== null)
                                        <img src="{{ asset(json_decode($product->photos)[0]) }}" class="mr-3" alt="...">
                                    @else
                                        <img src="{{ asset('/images/product_avatar.png') }}" class="mr-3" alt="...">
                                    @endif
                                    <div class="media-body">
                                        <h3>{{ $product->name }}</h3>
                                    </div>
                                </div>
                                @foreach ($value as $variant)
                                    <div class="mb-2 d-flex">
                                        <div class="box w-50">
                                            <div class="line">
                                                <strong>{{ translate('size') }} :</strong>
                                                <span>{{ $variant->variant  }}</span>
                                            </div>
                                            <div class="line">
                                                <strong>{{ translate('price') }} :</strong>
                                                <span>{{  $variant->price  }}</span>
                                            </div>
                                            <div class="line">
                                                <strong>{{ translate('quantity') }} :</strong>
                                                <span>{{ $variant->qty  }}</span>
                                            </div>
                                            @if($variant->qty > 1)
                                                <div class="line">
                                                    <strong>{{ translate('total price') }} :</strong>
                                                    <span>{{  $variant->total_price  }}</span>
                                                </div>
                                            @endif
                                        </div>
                                        @if($variant->files)
                                            <div class="box w-50">
                                                <ul class="all_files list-unstyled">
                                                    @foreach (json_decode($variant->files) as $file)
                                                        <li>
                                                            <a class="w-100" target="_blank" href="{{ asset($file) }}">
                                                                {{ $loop->index + 1 }}
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                                @if(isset($order->order_details->groupBy('variant_type')['extra']))
                                    @foreach ($order->order_details->groupBy('variant_type')['extra']->groupBy('product_id') as $product_id_from_extra => $val)
                                        @if($product_id_from_extra == $product_id_from_size)
                                            @foreach ($val as $variant)
                                                <div class="mb-2 d-flex">
                                                    <div class="box w-50">
                                                        <div class="line">
                                                            <strong>{{ translate('extra') }} :</strong>
                                                            <span>{{ $variant->variant  }}</span>
                                                        </div>
                                                        <div class="line">
                                                            <strong>{{ translate('price') }} :</strong>
                                                            <span>{{  $variant->price  }}</span>
                                                        </div>
                                                        <div class="line">
                                                            <strong>{{ translate('quantity') }} :</strong>
                                                            <span>{{ $variant->qty  }}</span>
                                                        </div>
                                                        @if($variant->qty > 1)
                                                            <div class="line">
                                                                <strong>{{ translate('total price') }} :</strong>
                                                                <span>{{  $variant->total_price  }}</span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    @if($variant->files)
                                                        <div class="box w-50">
                                                            @foreach (json_decode($variant->files) as $file)
                                                            <a target="_blank" href="{{ asset($file) }}">{{  $loop->index  }}</a>
                                                            @endforeach
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
                                    <li>{{ translate('qty') }}</li>
                                    <li>{{ $value->pluck('qty')->sum() }}</li>
                                </ul>
                            </td>
                            <td>--</td>
                            <td>
                                <strong class="comp-title">{{  $value->pluck('total_price')->sum() }}</strong>
                                <ul class="mobile list-unstyled">
                                    <li>{{ translate('total price') }}</li>
                                    <li>{{  $value->pluck('total_price')->sum() }}</li>
                                </ul>
                            </td>
                        </tr>
                    @endif
                @endforeach
            @endif
            @if($order->coupon)
                <tr>
                    <td></td>
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
                        <li>{{ translate('total price without extras') }}</li>
                        @if(isset($order->order_details->groupBy('variant_type')['extra']))
                            <li>
                                {{   (($order->grand_total  - $order->shipping -  $order->order_details->groupBy('variant_type')['extra']->pluck('total_price')->sum()) + $order->total_discount) }}
                            </li>
                        @else
                            <li>
                                {{  (( $order->grand_total - $order->shipping) + $order->total_discount)  }}
                            </li>
                        @endif
                    </ul>
                </td>
                <td class="comp-td"></td>
                <td class="comp-td"></td>
                <td class="text-center comp-td">
                    <strong>{{ translate('total price without extras') }}</strong></td>
                @if(isset($order->order_details->groupBy('variant_type')['extra']))
                    <td class="comp-td"><strong>{{   (($order->grand_total  - $order->shipping -  $order->order_details->groupBy('variant_type')['extra']->pluck('total_price')->sum()) + $order->total_discount) }}</strong></td>
                @else
                    <td class="comp-td"><strong>{{  (( $order->grand_total - $order->shipping) + $order->total_discount)  }}</strong></td>
                @endif
            </tr>
            @if(isset($order->order_details->groupBy('variant_type')['extra']))
                <tr>
                    <td>
                        <ul class="mobile list-unstyled">
                            <li>{{ translate('total price of extras') }}</li>
                            <li>{{  $order->order_details->groupBy('variant_type')['extra']->pluck('total_price')->sum() }}</li>
                        </ul>
                    </td>
                    <td class="comp-td"></td>
                    <td class="comp-td"></td>
                    <td class="text-center comp-td"> <strong>{{ translate('total price of extras') }}</strong></td>
                    <td class="comp-td"><strong>{{  $order->order_details->groupBy('variant_type')['extra']->pluck('total_price')->sum() }}</strong></td>
                </tr>
            @endif
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
                            <li>{{  $order->total_discount }}</li>
                        </ul>
                    </td>
                    <td class="comp-td"></td>
                    <td class="comp-td"></td>
                    <td class="text-center comp-td">
                        <strong>{{ translate('discount') }}</strong></td>
                    <td class="comp-td"><strong>{{  $order->total_discount }}</strong></td>
                </tr>
            @endif
            <tr>
                <td>
                    <ul class="mobile list-unstyled">
                        <li>{{ translate('final price') }}</li>
                        <li>{{  $order->grand_total }}</li>
                    </ul>
                </td>
                <td class="comp-td"></td>
                <td class="comp-td"></td>
                <td class=" text-center comp-td">
                    <strong>{{ translate('final price') }}</strong></td>
                <td class="comp-td">
                   <strong>{{  $order->grand_total }}</strong></td>
            </tr>
        </tbody>
    </table>
</div>
