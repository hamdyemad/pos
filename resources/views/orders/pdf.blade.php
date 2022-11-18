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
				text-align: left;
			}

			.invoice-box table td {
				padding: 5px;
				vertical-align: top;
			}

			.invoice-box table tr td:nth-child(2) {
				text-align: left;
			}

			.invoice-box table tr.top table td {
				padding-bottom: 20px;
			}

			.invoice-box table tr.top table td.title {
				font-size: 45px;
				line-height: 45px;
				color: #333;
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

            .top {
                text-align: center;
            }
		</style>
	</head>

	<body>
		<div class="invoice-box @if($rtl) rtl @endif">
			<table class="table" cellpadding="0" cellspacing="0">
				<tr>
                    <td class="top" colspan="7">
                        @if (get_setting('logo'))
                            <img src="{{ asset(get_setting('logo')) }}" style="width: 500px; height: 200px;" alt="">
                        @else
                            <img src="{{ asset('/images/default.jpg') }}" style="width: 150px; height: 150px;" alt="">
                        @endif
                    </td>
				</tr>

				<tr class="information">
                    <td colspan="4">
                        <table>
                            <tr>
                                <td>
                                    @if($order->branch)
                                        {{ translate('order branch') . ': ' }} {{ translate($order->branch->name) }}<br>
                                    @endif
                                    @if($order->customer)
                                        {{ translate('name') . ': ' }} {{ $order->customer->name }}<br>
                                        {{ translate('phone') . ': ' }} {{ $order->customer->phone }}<br>
                                        {{ translate('phone2') . ': ' }} {{ $order->customer->phone2 }}<br>
                                    @endif
                                    {{ translate('address') . ': ' }} {{ $order->customer->address }}<br>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td colspan="3">
                        <table style="direction: rtl; text-align:right">
                            <tr>
                                <td>
                                    {{ translate('order number') . ' : ' . $order->id }}<br>
                                    {{ Carbon\Carbon::createFromDate($order->created_at)->format('Y-m-d')}}<br>
                                    @if($order->notes)
                                        {{ translate('notes') . ': ' }} {{ $order->notes }}<br>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </td>
				</tr>
                <tr class="heading">
                    <td>{{ translate('name') }}</td>
                    <td>{{ translate('variant') }}</td>
                    <td>{{ translate('price') }}</td>
                    <td>{{ translate('qty') }}</td>
                    <td>{{ translate('discount') }}</td>
                    <td>{{ translate('notes') }}</td>
                    <td>{{ translate('total price') }}</td>
                </tr>
                @foreach ($order->order_details as $order_detail)
                    <tr>
                        <td>
                            {{ $order_detail->product->name }}
                        </td>
                        <td>
                            {{ $order_detail->variant }}
                        </td>
                        <td>
                            {{ $order_detail->price }}
                        </td>
                        <td>
                            {{ $order_detail->qty }}
                        </td>
                        <td>
                            @if($order->discount_type == 'percent')
                                {{ '%' . $order_detail->discount }}

                            @else
                                {{ $order_detail->discount }}
                            @endif
                        </td>
                        <td>
                            {{ $order_detail->notes }}
                        </td>
                        <td>
                            @if($order->discount_type == 'percent')
                                {{ $order_detail->total_price - ($order_detail->total_price * ($order_detail->discount / 100)) }}
                            @else
                                {{ $order_detail->total_price - $order_detail->discount }}
                            @endif
                        </td>
                    </tr>
                @endforeach
                @if($order->coupon)
                    <tr class="items">
                        <td></td>
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
                @if($order->shipping)
                    <tr class="item">
                        <td class="no-line"></td>
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
                        <td class="no-line"></td>
                        <td class="no-line text-center">
                            <span>{{ translate('discount') }}</span></td>
                        <td class="no-line">
                            @if($order->discount_type == 'percent')
                                <span>{{ '%' . $order->total_discount }}</span>
                            @else
                                <span>{{ $order->total_discount }}</span>
                            @endif
                        </td>
                    </tr>
                @endif
                <tr class="item">
                    <td></td>
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
                    <td colspan="7">
                        @php
                            $order_id = $order['id'];
                            \Storage::disk('public')->put('barcodes/' . $order['id'] . '.png',base64_decode(DNS1D::getBarcodePNG("$order_id", 'C128')));
                        @endphp
                        <img src="{{ asset('barcodes/' . $order['id'] . '.png') }}" style="width:200px; height: 30px" alt="">
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right"  colspan="7">
                        شروط الاسترجاع  داخل الفروع
                        خلال 14 يوم
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right"  colspan="7">
                        1- عدم غسل المنتج
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right"  colspan="7">
                        2- عدم استخدام برفيوم علي المنتج
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right"  colspan="7">
                        3- عدم اللبس
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right" colspan="7">
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
