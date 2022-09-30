@php
    // Generate Barcode For Products and sizes
    $products = \App\Models\Product::where('barcode', null)->get();
    foreach ($products as $product) {
        $product_barcode = $product['id'];
            \Storage::disk('public')->put('products_barcodes/' . $product_barcode . '.png',base64_decode(DNS1D::getBarcodePNG("$product_barcode", 'C128')));
        $product->barcode = $product_barcode . '.png';
        $product->save();
        if($product->variants) {
            if(isset($product->variants->where('barcode', null)->groupBy('type')['size'])) {
                foreach($product->variants->groupBy('type')['size'] as $variant) {
                    $variant_barcode = $product['id'] . '.' . $variant['id'];
                        \Storage::disk('public')->put('products_barcodes/' . $variant_barcode . '.png',base64_decode(DNS1D::getBarcodePNG("$variant_barcode", 'C128')));
                    $variant->barcode = $variant_barcode . '.png';
                    $variant->save();
                }
            }
        }
    }


    // Auto View Orders After 3 days Without view
    $orders_views_ids = \App\Models\OrderView::where('user_id', auth()->user()->id)->pluck('order_id');
    $orders = \App\Models\Order::whereNotIn('id', $orders_views_ids)->get();
    foreach ($orders as $order) {

        if(\Carbon\Carbon::now()->diffInDays($order['created_at']) > 3) {
            \App\Models\OrderView::create([
                'order_id' => $order->id,
                'user_id' => auth()->user()->id,
            ]);
        }

    }

@endphp
