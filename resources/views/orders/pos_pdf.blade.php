<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>{{ $order->id }}</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Cairo&display=swap" rel="stylesheet">
		<style>
			.invoice-box {
                width: 250px;
                height: 100%;
                /* height: 1056px; */
				font-size: 16px;
				font-family: "Cairo", sans-serif;
			}

            td {
                width: 100%;
            }

			/** RTL **/
			.invoice-box.rtl {
				direction: rtl;
			}
            .table {
                vertical-align: middle
            }

            .info td,
            .item td {
                border: 1px solid rgba(0, 0, 0, 0.15);
                padding: 5px;
            }
            .item .no_border {
                border: 1px solid #eee !important;
            }
            .item_childs td {
                padding: 5px;
                border: 1px solid rgb(206, 206, 206);

            }

            .invoice-box table tr.heading td {
                padding: 5px;
				background: #eee;
				border-bottom: 1px solid #ddd;
			}

        tr.nothing td {
            padding: 0;
            margin: 0;
        }

        .logo_div {
            text-align: center;
            margin: auto;
            display: block
        }

        .logo {
            width: 200px;
            height: 150px;
        }

		</style>
	</head>

	<body>
		<div class="invoice-box @if($rtl) rtl @endif">
            <div class="logo_div">
                <img class="logo" src="{{ asset(get_setting('logo')) }}" alt="">
            </div>

			<table class="table" cellpadding="0" cellspacing="0">
                <tr class="info">
                    <td colspan="2">{{ translate('n.o') }}</td>
                    <td class="text-center" colspan="4">{{ $order->id }}</td>
                </tr>
                <tr class="info">
                    <td colspan="2">{{ translate('date') }}</td>
                    <td class="text-center" colspan="4">{{ \Carbon\Carbon::createFromDate($order->created_at)->format('Y-m-d') }}</td>
                </tr>
                @if($order->branch)
                    <tr class="info">
                        <td colspan="2">{{ translate('branch') }}</td>
                        <td class="text-center" colspan="4">{{ $order->branch->name }}</td>
                    </tr>
                @endif
                @if($order->customer)
                    <tr class="info">
                        <td colspan="2">{{ translate('name') }}</td>
                        <td class="text-center" colspan="4">{{ $order->customer->name }}</td>
                    </tr>
                    <tr class="info">
                        <td colspan="2">{{ translate('phone') }}</td>
                        <td class="text-center" colspan="4">{{ $order->customer->phone }}</td>
                    </tr>
                    <tr class="info">
                        <td colspan="2">{{ translate('phone2') }}</td>
                        <td class="text-center" colspan="4">{{ $order->customer->phone2 }}</td>
                    </tr>
                @endif
                <tr>
                    <td colspan="6">
                        <hr>
                    </td>
                </tr>
                <tr class="heading">
                    <td>{{ translate('Desc.') }}</td>
                    <td>{{ translate('Price') }}</td>
                    <td>{{ translate('QTY') }}</td>
                    <td>{{ translate('Full Price') }}</td>
                    <td>{{ translate('Discount') }}</td>
                    <td>{{ translate('Total') }} </td>
                </tr>
                @php
                    $sub_total = 0;
                @endphp
                @if(isset($order->order_details->groupBy('variant_type')['']))
                    @foreach ($order->order_details->groupBy('variant_type')[''] as $variant)
                        @php
                            if($order->discount_type == 'percent') {
                                $discount = $variant->total_price * ($variant->discount / 100);
                            } else {
                                $discount = $variant->discount;
                            }
                            $sub_total += $variant->total_price - $discount;
                        @endphp
                        <tr class="item">
                            <td>
                                <span>{{ $variant->product->name }}</span>
                            </td>
                            <td>
                                <span>{{ $variant->price }}</span>
                            </td>
                            <td><span>{{ $variant->qty }}</span></td>
                            <td>
                                <span>{{ $variant->price * $variant->qty }}</span>
                            </td>
                            <td>
                                <span>{{ $discount }}</span>
                            </td>
                            <td><span>{{ $variant->total_price - $discount }}</span></td>
                        </tr>
                    @endforeach
                @endif
                @if(isset($order->order_details->groupBy('variant_type')['size']))
                    @foreach ($order->order_details->groupBy('variant_type')['size']->groupBy('product_id') as $product_id_from_size => $value)
                        @if($value)
                            <tr class="item">
                                <td>
                                    <span>{{ App\Models\Product::find($product_id_from_size)->name }}</span>
                                </td>
                                <td>--</td>
                                <td><span>{{ $value->pluck('qty')->sum() }}</span></td>
                                <td>--</td>
                                <td>--</td>
                                <td>--</td>
                            </tr>
                            @foreach ($value as $variant)
                                @php
                                    if($order->discount_type == 'percent') {
                                        $discount = $variant->total_price * ($variant->discount / 100);
                                    } else {
                                        $discount = $variant->discount;
                                    }
                                    $sub_total += $variant->total_price - $discount;
                                @endphp
                                <tr class="item_childs">
                                    <td>{{ $variant->variant }}</td>
                                    <td>{{ $variant->price }}</td>
                                    <td>{{ $variant->qty }}</td>
                                    <td>{{ $variant->total_price }}</td>
                                    <td>
                                        {{ $discount }}
                                    </td>
                                    <td>
                                        {{  $variant->total_price - $discount }}
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    @endforeach
                @endif
                @if(isset($order->order_details->groupBy('variant_type')['extra']))
                    @foreach ($order->order_details->groupBy('variant_type')['extra']->groupBy('product_id') as $product_id_from_extra => $val)
                        @if($val)
                            @foreach ($val as $extra)
                                @php
                                    if($order->discount_type == 'percent') {
                                        $discount = $extra->total_price - (($extra->total_price * $extra->discount) / 100);
                                    } else {
                                        $discount = $extra->total_price - $extra->discount;
                                    }
                                    $sub_total += $variant->total_price - $discount;
                                @endphp
                                <tr class="item_childs">
                                    <td>{{ $extra->variant }}</td>
                                    <td>{{ $extra->price }}</td>
                                    <td>{{ $extra->qty }}</td>
                                    <td>{{ $extra->total_price }}</td>
                                    <td>
                                        {{ $discount }}
                                    </td>
                                    <td>
                                        {{  $extra->total_price - $discount }}
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    @endforeach
                @endif

                <tr>
                    <td colspan="6">
                        <hr>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>{{ translate('sub total') }}</td>
                    <td>
                        {{ $sub_total }}
                    </td>

                </tr>
                @if($order->total_discount)
                    <tr>
                        <td colspan="6">
                            <hr>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="no-line text-center">
                            <span>{{ translate('discount') }}</span></td>
                        <td>
                            @php
                                if($order->discount_type == 'percent') {
                                    $total_discount = $sub_total * ($order->total_discount / 100);
                                } else {
                                    $total_discount = $order->total_discount;
                                }
                            @endphp
                            {{ $total_discount }}
                        </td>
                    </tr>
                @endif
                @if($order->coupon)
                    <tr>
                        <td colspan="6">
                            <hr>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>{{ translate('coupon discount') }}</td>
                        <td>
                            @if($order->coupon->type == 'price')
                                {{ $order->coupon->price }}
                            @else
                                {{ $order->coupon->price . '%' }}
                            @endif
                        </td>

                    </tr>
                @endif
                <tr>
                    <td colspan="6">
                        <hr>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="no-line text-center">
                        <span>{{ translate('total price') }}</span></td>
                    <td>
                        <span>{{ $order->grand_total }}</span>
                    </td>
                </tr>
                <tr>
                    <td colspan="6">
                        <hr>
                    </td>
                </tr>
                <tr>
                    <td colspan="6" style="text-align: right; font-size: 13px">
                        ???????? ?????????????????? ???????? ???????????? ???????? 14 ??????
                    </td>
                </tr>
                <tr>
                    <td colspan="6" style="text-align: right; font-size: 13px">
                        1- ?????? ?????? ????????????
                    </td>
                </tr>
                <tr>
                    <td colspan="6" style="text-align: right; font-size: 13px">
                        2- ?????? ?????????????? ???????????? ?????? ????????????
                    </td>
                </tr>
                <tr>
                    <td colspan="6" style="text-align: right; font-size: 13px">
                        3- ?????? ??????????
                    </td>
                </tr>
                <tr>
                    <td colspan="6" style="text-align: right; font-size: 13px">
                        ???????? ?????????????????? ???????? ???????????? ???????? ???????? ???????? 14 ?????? ???? ?????????? ???? ????????????  ?????? ?????????? ???????? ?????? ??????????  ???????? ?????????????? ?????? ?????? ?????? ???????? ?????????????? ?????? ?????? ???????????? ??????????????????
                        ?????????????? ??????
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
			</table>
		</div>
	</body>
</html>
