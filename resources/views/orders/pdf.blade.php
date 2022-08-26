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
				padding: 30px;
				border: 1px solid #eee;
                height: 100%;
				box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
				font-size: 16px;
				line-height: 24px;
				font-family: "Cairo", sans-serif;
				color: #555;
			}

			.invoice-box table {
				width: 100%;
				line-height: inherit;
				text-align: right;
			}

			.invoice-box table td {
				padding: 5px;
				vertical-align: top;
			}

			.invoice-box table tr td:nth-child(2) {
				text-align: right;
			}

			.invoice-box table tr.top table td {
				padding-bottom: 20px;
			}

			.invoice-box table tr.top table td.title {
				font-size: 45px;
				line-height: 45px;
				color: #333;
			}

			.invoice-box table tr.information table td {
				padding-bottom: 40px;
			}

			.invoice-box table tr.heading td {
				background: #eee;
				border-bottom: 1px solid #ddd;
			}

			.invoice-box table tr.details td {
				padding-bottom: 20px;
			}

			.invoice-box table tr.item td {
				border-bottom: 1px solid #eee;
			}

			.invoice-box table tr.item.last td {
				border-bottom: none;
			}

			.invoice-box table tr.total td:nth-child(2) {
				border-top: 2px solid #eee;
				font-weight: bold;
			}

			@media only screen and (max-width: 600px) {
				.invoice-box table tr.top table td {
					width: 100%;
					display: block;
					text-align: center;
				}

				.invoice-box table tr.information table td {
					width: 100%;
					display: block;
					text-align: center;
				}
			}

			/** RTL **/
			.invoice-box.rtl {
				direction: rtl;
				/* font-family: "Cairo", sans-serif; */
			}

			.invoice-box.rtl table {
				text-align: right;
			}

			.invoice-box.rtl  tr td.order_header {
				text-align: left !important;
			}
            .top {
                text-align: center;
            }
		</style>
	</head>

	<body>
		<div class="invoice-box @if($rtl) rtl @endif">
			<table class="table" cellpadding="0" cellspacing="0">
				<tr>
                    <td class="top" colspan="6">
                        @if (get_setting('logo'))
                            <img src="{{ asset(get_setting('logo')) }}" style="width: 500px; height: 200px;" alt="">
                        @else
                            <img src="{{ asset('/images/default.jpg') }}" style="width: 150px; height: 150px;" alt="">
                        @endif
                    </td>
				</tr>

				<tr class="information">
                    <td colspan="3">
                        <table>
                            <tr>
                                <td>
                                    @if($order->branch)
                                        {{ translate('order branch') . ': ' }} {{ translate($order->branch->name) }}<br>
                                    @endif
                                    @if($order->notes)
                                        {{ translate('notes') . ': ' }} {{ $order->notes }}<br>
                                    @endif
                                    {{ translate('order summary') }}<br>
                                    @if($order->customer_name)
                                        {{ translate('customer name') . ': ' }} {{ $order->customer_name }}<br>
                                    @endif
                                    @if($order->customer_phone)
                                        {{ translate('customer phone') . ': ' }} {{ $order->customer_phone }}<br>
                                    @endif
                                    @if($order->customer_address)
                                        {{ translate('customer address') . ': ' }} {{ $order->customer_address }}<br>
                                    @endif
                                    @if($order->city)
                                        {{ translate('city') . ': ' }} {{ $order->city->name }}<br>
                                        {{ translate('country') . ': ' }} {{ $order->city->country->name }}<br>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td colspan="3">
                        <table>
                            <tr>
                                <td>
                                    {{ translate('order number') . ' : ' . $order->id }}<br>
                                    ({{ $order->created_at }})<br>
                                </td>
                            </tr>
                        </table>
                    </td>
				</tr>
                <tr class="heading">
                    <td>{{ translate('food name') }}</td>
                    <td></td>
                    <td>{{ translate('price') }}</td>
                    <td></td>
                    <td>{{ translate('count') }}</td>
                    <td>{{ translate('total price') }} </td>
                </tr>
                @if(isset($order->order_details->groupBy('variant_type')['']))
                    @foreach ($order->order_details->groupBy('variant_type')[''] as $variant)
                        @if($variant)
                            <tr class="item">
                                <td>
                                    <span>{{ $variant->product->name }}</span>
                                    @if(isset($order->order_details->groupBy('variant_type')['extra']))
                                        <table>
                                            @foreach ($order->order_details->groupBy('variant_type')['extra']->groupBy('product_id') as $product_id_from_extra => $val)
                                                @if($variant->product->id == $product_id_from_extra)
                                                    @foreach ($val as $extra)
                                                        <tr>
                                                            <td>
                                                                <span>{{ translate('extra') }} :</span>
                                                                <span>{{ $extra->variant  }}</span>
                                                            </td>
                                                            <td>
                                                                <span>{{ translate('price') }} :</span>
                                                                <span>{{ $extra->price  }}</span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <span>{{ translate('quantity') }} :</span>
                                                                <span>{{ $extra->qty  }}</span>
                                                            </td>
                                                            @if($extra->qty > 1)
                                                                <td>
                                                                    <span>{{ translate('total price') }} :</span>
                                                                    <span>{{ $extra->total_price  }}</span>
                                                                </td>
                                                            @endif
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        </table>
                                    @endif
                                </td>
                                <td></td>
                                <td>
                                    <span>{{ $variant->price }}</span>
                                </td>
                                <td></td>
                                <td><span>{{ $variant->qty }}</span></td>
                                <td><span>{{ $variant->total_price }}</span></td>
                            </tr>
                        @endif
                    @endforeach
                @endif
                @if(isset($order->order_details->groupBy('variant_type')['size']))
                    @foreach ($order->order_details->groupBy('variant_type')['size']->groupBy('product_id') as $product_id_from_size => $value)
                        @if($value)
                            <tr class="item">
                                <td>
                                    <span>{{ App\Models\Product::find($product_id_from_size)->name }}</span>
                                </td>
                                <td></td>
                                <td>
                                    @foreach ($value as $variant)
                                        <div class="mb-2 d-flex align-items-center">
                                            <div class="line">
                                                <span>{{ translate('size') }} :</span>
                                                <span>{{ $variant->variant  }}</span>
                                            </div>
                                            <div class="line">
                                                <span>{{ translate('price') }} :</span>
                                                <span>{{ $variant->price  }}</span>
                                            </div>
                                            <div class="line">
                                                <span>{{ translate('quantity') }} :</span>
                                                <span>{{ $variant->qty  }}</span>
                                            </div>
                                            @if($variant->qty > 1)
                                                <div class="line">
                                                    <span>{{ translate('total price') }} :</span>
                                                    <span>{{ $variant->total_price  }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                    @if(isset($order->order_details->groupBy('variant_type')['extra']))
                                        @foreach ($order->order_details->groupBy('variant_type')['extra']->groupBy('product_id') as $product_id_from_extra => $val)
                                            @if($product_id_from_extra == $product_id_from_size)
                                                @foreach ($val as $variant)
                                                    <div class="mb-2 d-flex align-items-center">
                                                        <div class="line">
                                                            <span>{{ translate('extra') }} :</span>
                                                            <span>{{ $variant->variant  }}</span>
                                                        </div>
                                                        <div class="line">
                                                            <span>{{ translate('price') }} :</span>
                                                            <span>{{ $variant->price  }}</span>
                                                        </div>
                                                        <div class="line">
                                                            <span>{{ translate('quantity') }} :</span>
                                                            <span>{{ $variant->qty  }}</span>
                                                        </div>
                                                        @if($variant->qty > 1)
                                                            <div class="line">
                                                                <span>{{ translate('total price') }} :</span>
                                                                <span>{{ $variant->total_price  }}</span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            @endif
                                        @endforeach
                                    @endif
                                </td>
                                <td></td>
                                <td><span>{{ $value->pluck('qty')->sum() }}</span></td>
                                <td><span>{{ $value->pluck('total_price')->sum() }}</span></td>
                            </tr>
                        @endif
                    @endforeach
                @endif
                @if($order->coupon)
                    <tr class="items">
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
                <tr class="item">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="thick-line text-center">
                        <span>{{ translate('total price withoud extras') }}</span>
                    </td>
                    @if(isset($order->order_details->groupBy('variant_type')['extra']))
                        <td><span>{{  (($order->grand_total  - $order->shipping -  $order->order_details->groupBy('variant_type')['extra']->pluck('total_price')->sum()) + $order->total_discount) }}</span></td>
                    @else
                        <td><span>{{ (( $order->grand_total - $order->shipping) + $order->total_discount)  }}</span></td>
                    @endif
                </tr>
                @if(isset($order->order_details->groupBy('variant_type')['extra']))
                    <tr class="item">
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="text-center"> <span>{{ translate('total price of extras') }}</span></td>
                        <td><span>{{ $order->order_details->groupBy('variant_type')['extra']->pluck('total_price')->sum() }}</span></td>
                    </tr>
                @endif
                @if($order->shipping)
                    <tr class="item">
                        <td class="no-line"></td>
                        <td class="no-line"></td>
                        <td class="no-line"></td>
                        <td class="no-line"></td>
                        <td class="no-line text-center">
                            <span>{{ translate('shipping') }}</span></td>
                        <td class="no-line"><span>{{ $order->shipping }}</span></td>
                    </tr>
                @endif
                @if($order->total_discount)
                    <tr class="item">
                        <td class="no-line"></td>
                        <td class="no-line"></td>
                        <td class="no-line"></td>
                        <td class="no-line"></td>
                        <td class="no-line text-center">
                            <span>{{ translate('discount') }}</span></td>
                        <td class="no-line"><span>{{ $order->total_discount }}</span></td>
                    </tr>
                @endif
                <tr class="item">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="no-line text-center">
                        <span>{{ translate('final price') }}</span></td>
                    <td>
                        <span>{{ $order->grand_total }}</span>
                    </td>
                </tr>
                <tr class="item">
                    <td colspan="6">
                        @php
                            $order_id = $order['id'];
                            \Storage::disk('public')->put('barcodes/' . $order['id'] . '.png',base64_decode(DNS1D::getBarcodePNG("$order_id", 'C128')));
                        @endphp
                        <img src="{{ asset('barcodes/' . $order['id'] . '.png') }}" style="width:200px; height: 30px" alt="">
                    </td>
                </tr>
                <tr>
                    <td colspan="6">
                        شروط الاسترجاع  داخل الفروع
                        خلال 14 يوم
                    </td>
                </tr>
                <tr>
                    <td colspan="6">
                        1- عدم غسل المنتج
                    </td>
                </tr>
                <tr>
                    <td colspan="6">
                        2- عدم استخدام برفيوم علي المنتج
                    </td>
                </tr>
                <tr>
                    <td colspan="6">
                        3- عدم اللبس
                    </td>
                </tr>
                <tr>
                    <td colspan="6">
                        شروط الاستبدال داخل الفروع واون لاين خلال 14 يوم
                        اي مشكله في المنتج بعد اللبس خلال هذه المده بيتم التبديل فور فري ايآ كانت المشكلة ولا يحق للعميل الاسترجاع
                        التبديل فقط
                    </td>
                </tr>
			</table>
            <table>
            </table>
		</div>
	</body>
</html>
