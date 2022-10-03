<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>{{ $product->id }}</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Cairo&display=swap" rel="stylesheet">
		<style>
			.invoice-box {
                width: 188.97637795px;
                height: 100%;
                padding: 20px 0;
				font-size: 16px;
				font-family: "Cairo", sans-serif;
			}

		</style>
	</head>

	<body>
        <div class="invoice-box @if($rtl) rtl @endif">
            <table>
                <tr>
                    <td colspan="2"  style="text-align: center">
                        <span>{{ $product->name . '-' . $product->sku }}</span>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        @if($variant)
                            <img style="width: 100%; height: 50px" src="{{ asset('products_barcodes/' . $variant->barcode) }}" alt="">
                        @else
                            <img style="width: 100%; height: 50px" src="{{ asset('products_barcodes/' . $product->barcode) }}" alt="">
                        @endif
                    </td>
                </tr>

                @if(isset($variant))
                    <tr>
                        <td colspan="2"  style="text-align: center">
                            <span>{{ $variant->variant . '-' . $variant->price->price_after_discount }}</span>
                        </td>
                    </tr>
                @else
                    <tr>
                        <td colspan="2"  style="text-align: center">
                            <span>{{ $variant->variant . '-' . $product->price_of_currency->price_after_discount }}</span>
                        </td>
                    </tr>
                @endif
            </table>
		</div>
	</body>
</html>
