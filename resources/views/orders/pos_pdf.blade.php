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
                width: 302.36220472;
				padding: 30px;
                margin: auto;
				border: 1px solid #eee;
                height: 100%;
				box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
				font-size: 16px;
				line-height: 24px;
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

		</style>
	</head>

	<body>
		<div class="invoice-box @if($rtl) rtl @endif">
			<table class="table" cellpadding="0" cellspacing="0">
                <tr>
                    <td class="top" colspan="4">
                        @if (get_setting('logo'))
                            <img src="{{ asset(get_setting('logo')) }}" style="width: 250px; height: 180px;" alt="">
                        @else
                            <img src="{{ asset('/images/default.jpg') }}" style="width: 150px; height: 150px;" alt="">
                        @endif
                    </td>
                </tr>
                <tr class="info">
                    <td colspan="1">{{ translate('n.o') }}</td>
                    <td class="text-center" colspan="3">{{ $order->id }}</td>
                </tr>
                <tr class="info">
                    <td colspan="1">{{ translate('date') }}</td>
                    <td class="text-center" colspan="3">{{ \Carbon\Carbon::createFromDate($order->created_at)->format('Y-md-d') }}</td>
                </tr>
                @if($order->customer)
                    <tr class="info">
                        <td colspan="1">{{ translate('name') }}</td>
                        <td class="text-center" colspan="3">{{ $order->customer->name }}</td>
                    </tr>
                    <tr class="info">
                        <td colspan="1">{{ translate('phone') }}</td>
                        <td class="text-center" colspan="3">{{ $order->customer->phone }}</td>
                    </tr>
                @endif
                <tr>
                    <td colspan="4">
                        <hr>
                    </td>
                </tr>
                <tr class="heading">
                    <td>{{ translate('Desc.') }}</td>
                    <td>{{ translate('QTY') }}</td>
                    <td>{{ translate('Price') }}</td>
                    <td>{{ translate('Total') }} </td>
                </tr>
                @if(isset($order->order_details->groupBy('variant_type')['']))
                    @foreach ($order->order_details->groupBy('variant_type')[''] as $variant)
                        <tr class="item">
                            <td>
                                <span>{{ $variant->product->name }}</span>
                            </td>
                            <td><span>{{ $variant->qty }}</span></td>
                            <td>
                                <span>{{ $variant->price }}</span>
                            </td>
                            <td><span>{{ $variant->total_price }}</span></td>
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
                                <td><span>{{ $value->pluck('qty')->sum() }}</span></td>
                                <td>--</td>
                                <td><span>{{ $value->pluck('total_price')->sum() }}</span></td>
                            </tr>
                            @foreach ($value as $variant)
                                <tr class="item_childs">
                                    <td>{{ $variant->variant }}</td>
                                    <td>{{ $variant->qty }}</td>
                                    <td>{{ $variant->price }}</td>
                                    <td>{{ $variant->total_price }}</td>
                                </tr>
                            @endforeach
                        @endif
                    @endforeach
                @endif
                @if(isset($order->order_details->groupBy('variant_type')['extra']))
                    @foreach ($order->order_details->groupBy('variant_type')['extra']->groupBy('product_id') as $product_id_from_extra => $val)
                        @if($val)
                            @foreach ($val as $extra)
                                <tr class="item_childs">
                                    <td>
                                        <span>{{ $extra->variant  }}</span>
                                    </td>
                                    <td>
                                        <span>{{ $extra->qty  }}</span>
                                    </td>
                                    <td>
                                        <span>{{ $extra->price  }}</span>
                                    </td>
                                    <td>
                                        <span>{{ $extra->total_price  }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    @endforeach
                @endif
                @if($order->coupon)
                    <tr class="item">
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
                @if($order->total_discount)
                    <tr class="item">
                        <td></td>
                        <td></td>
                        <td class="no-line text-center">
                            <span>{{ translate('discount') }}</span></td>
                        <td><span>{{ $order->total_discount }}</span></td>
                    </tr>
                @endif
                <tr class="item">
                    <td class="no_border"></td>
                    <td class="no_border"></td>
                    <td class="no-line text-center">
                        <span>{{ translate('final price') }}</span></td>
                    <td>
                        <span>{{ $order->grand_total }}</span>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <hr>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        شروط الاسترجاع داخل الفروع خلال 14 يوم
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        1- عدم غسل المنتج
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        2- عدم استخدام برفيوم علي المنتج
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        3- عدم اللبس
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        شروط الاستبدال داخل الفروع واون لاين خلال 14 يوم اي مشكله في المنتج  بعد اللبس خلال هذه المده  بيتم التبديل فور فري ايآ كانت المشكلة ولا يحق للعميل الاسترجاع
                        التبديل فقط
                    </td>
                </tr>
                <tr>
                    <td colspan="2"></td>
                    <td></td>
                    <td></td>
                </tr>
			</table>
		</div>
	</body>
</html>
