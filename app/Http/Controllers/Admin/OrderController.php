<?php

namespace App\Http\Controllers\Admin;

use App\Events\changeOrderStatus;
use App\Events\newOrder;
use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Category;
use App\Models\City;
use App\Models\Country;
use App\Models\Coupon;
use App\Models\Language;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderView;
use App\Models\Payment;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Status;
use App\Models\StatusHistory;
use App\Traits\File;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use PDF;
use Mpdf\Mpdf;

class OrderController extends Controller
{
    use File;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('orders.index');
        Carbon::setLocale(app()->getLocale());
        $orders = Order::where('under_approve', 0)->latest();
        $statuses = Status::all();
        $branches = Branch::all();
        if($request->customer_name) {
            $orders = $orders->where('customer_name', 'like', '%' . $request->customer_name .'%');
        }
        if($request->customer_phone) {
            $orders = $orders->where('customer_phone', 'like', '%' . $request->customer_phone .'%');
        }
        if($request->type) {
            $orders = $orders->where('type', 'like', '%' . $request->type .'%');
        }
        if($request->branch_id) {
            $orders = $orders->where('branch_id', 'like', '%' . $request->type .'%');
        }
        if($request->status_id) {
            $orders = $orders->where('status_id', 'like', '%' . $request->status_id .'%');
        }
        if($request->from) {
            $orders = $orders->where('created_at', '>=', $request->from);
        }
        if($request->to) {
            $orders = $orders->where('created_at', '<=', $request->to);
        }
        if($request->to && $request->from) {
            $orders = $orders
            ->where('created_at', '<=', $request->to)
            ->where('created_at', '>=', $request->from);
        }
        $orders = $orders->paginate(10);
        return view('orders.index', compact('orders', 'statuses', 'branches'));
    }

    public function with_bin_codes(Request $request) {
        $this->authorize('orders.index');
        Carbon::setLocale(app()->getLocale());
        $orders = Order::where('bin_code', '!=', 'null')->latest();
        $statuses = Status::all();
        $branches = Branch::all();
        if($request->customer_name) {
            $orders = $orders->where('customer_name', 'like', '%' . $request->customer_name .'%');
        }
        if($request->customer_phone) {
            $orders = $orders->where('customer_phone', 'like', '%' . $request->customer_phone .'%');
        }
        if($request->type) {
            $orders = $orders->where('type', 'like', '%' . $request->type .'%');
        }
        if($request->branch_id) {
            $orders = $orders->where('branch_id', 'like', '%' . $request->type .'%');
        }
        if($request->status_id) {
            $orders = $orders->where('status_id', 'like', '%' . $request->status_id .'%');
        }
        if($request->from) {
            $orders = $orders->where('created_at', '>=', $request->from);
        }
        if($request->to) {
            $orders = $orders->where('created_at', '<=', $request->to);
        }
        if($request->to && $request->from) {
            $orders = $orders
            ->where('created_at', '<=', $request->to)
            ->where('created_at', '>=', $request->from);
        }
        $orders = $orders->paginate(10);
        return view('orders.bin_codes', compact('orders', 'statuses', 'branches'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('orders.create');
        $status = Status::where('default_val', 1)->first();
        if($status) {
            $countries = Country::where('active', '1')->get();
            if(Auth::user()->role_type == 'inhouse') {
                $categories_ids = Category::whereHas('branches', function($query) {
                    return $query->where('branch_id', Auth::user()->branch_id);
                })->latest()->pluck('id');
                $products = Product::whereHas('categories', function($query) use($categories_ids) {
                    return $query->whereIn('category_id', $categories_ids);
                })->latest()->get();
            } else {
                $products = null;
            }
            $branches = Branch::orderBy('name')->get();
            return view('orders.create', compact('products', 'branches', 'countries'));
        } else {
            return redirect()->back()->with('error', translate('a default status must be set'));
        }
    }

    public function validateOrder($request) {
        $rules = [
            'type' => 'required|in:inhouse,online',
            'branch_id' => 'required|exists:branches,id',
            'products_search' => 'required',
            'products' => 'required',
            'bin_code' => 'exists:users,bin_code',
            'payment_method' => 'required|in:cash,credit'
        ];
        $mesages = [
            'type.required' => translate('the type is required'),
            'branch_id.required' => translate('the branch is required'),
            'branch_id.exists' => translate('the branch should be exists'),
            'type.in' => translate('you should choose a type from the stock'),
            'products_search.required' => translate('you should choose a minmum 1 product'),
            'products.*.required' => translate('you should choose a minmum 1 product'),
        ];
        if($request->type == 'online') {
            unset($rules['branch_id']);
            $rules['customer_name'] = 'required';
            $rules['customer_address'] = 'required';
            $rules['customer_phone'] = 'required';
            $rules['city_id'] = 'required';
            $mesages['customer_name.required'] = translate('the name is required');
            $mesages['customer_address.required'] = translate('the address is required');
            $mesages['customer_phone.required'] =translate('the phone is required');
            $mesages['city_id.required'] = translate('the city is required');
        }
        if($request->products) {
            foreach ($request->products as $productId => $productObj) {
                if(isset($productObj['amount'])) {
                    $rules["products.$productId.amount"] = ['required','integer','min:1'];
                    $mesages["products.$productId.amount.required"] = translate('the amount is required');
                    $mesages["products.$productId.amount.min"] = translate('the amount should be at least 1');
                }
                if(isset($productObj['variants'])) {
                    foreach ($productObj['variants'] as $variantId => $variant) {
                        $rules["products.$productId.variants.$variantId.amount"] = ['required', 'integer','min:1'];
                        $mesages["products.$productId.variants.$variantId.amount.required"] = translate('the amount is required');
                        $mesages["products.$productId.variants.$variantId.amount.min"] = translate('the amount should be at least 1');
                    }
                }
            }
        }
        $validator = Validator::make($request->all(),$rules, $mesages);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())
            ->withInput($request->all())
            ->with('error', translate('there is something error'));
        }
    }


    public function removePhotos(Order $order) {
        if($order->customized_files) {
            foreach (json_decode($order->customized_files) as $file) {
                if(file_exists($file)) {
                    unlink($file);
                }
            }
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('orders.create');
        $city = City::find($request->city_id);
        if($city) {
            $request['shipping'] = $city->price;
        }
        if($request->type == 'online') {
            $request['branch_id'] = null;
        }
        $status = Status::where('default_val', 1)->first();
        if($status) {
            $creation = [
                'type' => $request->type,
                'branch_id' => $request->branch_id,
                'coupon_id' => $request->coupon_id,
                'user_id' => Auth::id(),
                'bin_code' => $request->bin_code,
                'payment_method' => $request->payment_method,
                'status_id' => $status->id,
                'city_id' => $request->city_id,
                'customer_name' => $request->customer_name,
                'customer_phone' => $request->customer_phone,
                'customer_address' => $request->customer_address,
                'notes' => $request->notes,
                'total_discount' => $request->total_discount,
                'shipping' => $request->shipping,
                'grand_total' => 0
            ];
            if($request->bin_code) {
                $creation['under_approve'] = 1;
            }
            if($this->validateOrder($request)) {
                return $this->validateOrder($request);
            }

            if($request->has('customized_files')) {
                foreach ($request->file('customized_files') as $customized_file) {
                    $customized_files[] = $this->uploadFiles($customized_file, $this->ordersPath);
                }
                $creation['customized_files'] = json_encode($customized_files);
            }

            $grand_total = [];
            $order = Order::create($creation);
            StatusHistory::create([
                'user_id' => Auth::id(),
                'order_id' => $order->id,
                'status_id' => $status->id
            ]);
            foreach ($request->products as $productId => $productObj) {
                $product = Product::find($productId);
                if($product) {
                    if(isset($productObj['amount'])) {
                        $price = $product->price_of_currency()->first();
                        OrderDetail::create([
                            'order_id' => $order->id,
                            'product_id' => $productId,
                            'price' => $price->price_after_discount,
                            'discount' => $productObj['discount'],
                            'qty' => $productObj['amount'],
                            'total_price' => $price->price_after_discount * $productObj['amount']
                        ]);
                        array_push($grand_total, (($price->price_after_discount * $productObj['amount']) - $productObj['discount']));
                    }
                    if(isset($productObj['variants'])) {
                        foreach ($productObj['variants'] as $variantId => $variant) {
                            $productVariant = ProductVariant::find($variantId);
                            if($productVariant) {
                                OrderDetail::create([
                                    'order_id' => $order->id,
                                    'product_id' => $productId,
                                    'variant' => $productVariant->variant,
                                    'variant_type' => $productVariant->type,
                                    'price' => $productVariant->currenctPriceOfVariant->price_after_discount,
                                    'qty' => $variant['amount'],
                                    'discount' => $variant['discount'],
                                    'total_price' => $productVariant->currenctPriceOfVariant->price_after_discount * $variant['amount']
                                ]);
                                array_push($grand_total, (($productVariant->currenctPriceOfVariant->price_after_discount * $variant['amount']) - $variant['discount']));
                            }
                        }
                    }
                }
            }
            $grand_total = array_reduce($grand_total,
            function($acc, $current) {return $acc + $current;});
            $grand_total = (($grand_total + $request->shipping) - $creation['total_discount']);
            if($request->coupon_id) {
                $coupon = Coupon::find($request->coupon_id);
                if($coupon) {
                    $coupon_price = floatval($coupon->price);
                    if($coupon->type == 'price') {
                        $grand_total = $grand_total - $coupon_price;
                    } else if($coupon->type == 'percent') {
                        $grand_total = ($grand_total - ($grand_total * $coupon_price / 100));
                    }
                }
            }
            $order->grand_total = $grand_total;
            $order->save();
            event(new newOrder([
                'order' => $order,
                'products_count' => $order->order_details->groupBy('product_id')->count(),
                'status' => $order->status
            ]));
            return redirect()->back()->with('success', translate('created successfully'));
        } else {
            return redirect()->back()->with('error', translate('you should choose a default status'));
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {

        $order_view = OrderView::where(['order_id' =>  $order->id, 'user_id' => Auth::id()])->first();
        if(!$order_view) {
            OrderView::create([
                'order_id' => $order->id,
                'user_id' => Auth::id()
            ]);
        }

        Carbon::setLocale(app()->getLocale());
        $statuses_history = StatusHistory::where('order_id', $order->id)->latest()->get();
        return view('orders.show', compact('order', 'statuses_history'));
    }

    public function pdf(Request $request,Order $order) {
        $currenctLang = Language::where('code', app()->getLocale())->first();
        Carbon::setLocale(app()->getLocale());
        if($request->type == 'pos') {
            $file = 'orders.pos_pdf';

        } else {
            $file = 'orders.pdf';
        }
        $pdf = PDF::loadView($file, ['order' => $order, 'rtl' => $currenctLang->rtl]);
        return $pdf->stream($order->id. '.pdf');
    }


    public function all_pdf(Request $request) {
        $currenctLang = Language::where('code', app()->getLocale())->first();
        Carbon::setLocale(app()->getLocale());
        if(!isset($request->orders)) {
            return redirect()->back()->with('error', translate('you should choose a 1 minimum of orders'));
        } else {
            $orders = Order::whereIn('id', $request->orders)->get();
            $mpdf = new Mpdf();
            $mpdf->autoScriptToLang = true;
            $mpdf->autoLangToFont = true;
            if($request->type == 'pos') {
                $file = 'orders.pos_pdf';

            } else {
                $file = 'orders.pdf';
            }
            foreach ($orders as $order) {
                $mpdf->WriteHTML(view($file, ['order' => $order,'rtl' => $currenctLang->rtl])->render());
            }
            $mpdf->Output('invoices/orders.pdf');
            return redirect()->to(asset('invoices/' . 'orders' . '.pdf'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        $this->authorize('orders.edit');
        $status = Status::where('default_val', 1)->first();
        if($status) {
            $countries = Country::where('active', '1')->get();
            if($order->city) {
                $cities = City::where('country_id', $order->city->country_id)->get();
            } else {
                $cities = [];
            }
            $products = Product::orderBy('name')->get();
            $branches = Branch::orderBy('name')->get();
            return view('orders.edit', compact('order', 'branches', 'products', 'countries', 'cities'));
        } else {
            return redirect()->back()->with('error', translate('you should choose a default status'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {

        $this->authorize('orders.edit');
        $city = City::find($request->city_id);
        if($city) {
            $request['shipping'] = $city->price;
        }
        $status = Status::where('default_val', 1)->first();
        if($status) {
            $creation = [
                'type' => $request->type,
                'branch_id' => $request->branch_id,
                'status_id' => $status->id,
                'customer_name' => $request->customer_name,
                'customer_phone' => $request->customer_phone,
                'customer_address' => $request->customer_address,
                'notes' => $request->notes,
                'total_discount' => $request->total_discount,
                'shipping' => $request->shipping,
                'grand_total' => 0
            ];
            if($this->validateOrder($request)) {
                return $this->validateOrder($request);
            }
            $grand_total = [];
            if($request->has('customized_files')) {
                // Remove Current Photo
                $this->removePhotos($order);
                foreach ($request->file('customized_files') as $customized_file) {
                    $customized_files[] = $this->uploadFiles($customized_file, $this->ordersPath);
                }
                $creation['customized_files'] = json_encode($customized_files);
            }
            $order->update($creation);
            OrderDetail::where('order_id', $order->id)->delete();
            foreach ($request->products as $productId => $productObj) {
                $product = Product::find($productId);
                if($product) {
                    if(isset($productObj['amount'])) {
                        OrderDetail::create([
                            'order_id' => $order->id,
                            'product_id' => $productId,
                            'price' => $product->price_of_currency->price_after_discount,
                            'qty' => $productObj['amount'],
                            'discount' => $productObj['discount'],
                            'total_price' => $product->price_of_currency->price_after_discount * $productObj['amount']
                        ]);
                        array_push($grand_total, (($product->price_of_currency->price_after_discount * $productObj['amount']) - $productObj['discount']));
                    }
                    if(isset($productObj['variants'])) {
                        foreach ($productObj['variants'] as $variantId => $variant) {
                            $productVariant = ProductVariant::find($variantId);
                            if($productVariant) {
                                OrderDetail::create([
                                    'order_id' => $order->id,
                                    'product_id' => $productId,
                                    'variant' => $productVariant->variant,
                                    'variant_type' => $productVariant->type,
                                    'price' => $productVariant->currenctPriceOfVariant->price_after_discount,
                                    'qty' => $variant['amount'],
                                    'discount' => $variant['discount'],
                                    'total_price' => $productVariant->currenctPriceOfVariant->price_after_discount * $variant['amount']
                                ]);
                                array_push($grand_total, (($productVariant->currenctPriceOfVariant->price_after_discount * $variant['amount']) - $variant['discount']));
                            }
                        }
                    }
                }
            }
            $grand_total = array_reduce($grand_total,
            function($acc, $current) {return $acc + $current;});
            $order->grand_total = ($grand_total + $request->shipping) - $creation['total_discount'];
            $order->save();
            return redirect()->back()->with('info', translate('updated successfully'));
        } else {
            return redirect()->back()->with('error', translate('you should choose a default status'));
        }
    }

    // Update Order Status
    public function updateStatus(Request $request) {
        $order = Order::find($request->order_id);
        if($order) {
            $order->update([
                'status_id' => $request->status_id
            ]);
            StatusHistory::create([
                'user_id' => Auth::id(),
                'order_id' => $order->id,
                'status_id' => $order->status_id
            ]);
            event(new changeOrderStatus([
                'user_id' => Auth::id(),
                'status_id' => $request->status_id,
                'order' => $order,
                'status_name' => $order->status->name
            ]));
            return response()->json(['msg' => translate('updated successfully'), 'status' => true]);
        }
    }

    // Update Orders Status
    public function updateStatusOfOrders(Request $request) {
        if(!isset($request->orders)) {
            return redirect()->back()->with('error', translate('you should choose a 1 minimum of orders'));
        } else {
            $status = Status::find($request->status_id);
            if(!$status) {
                return redirect()->back()->with('error', translate('you should choose status'));
            }
            $orders = explode(',', $request->orders);
            foreach ($orders as $order_id) {
                $order = Order::find($order_id);
                if($order) {
                    $order->update([
                        'status_id' => $request->status_id,
                    ]);
                    StatusHistory::create([
                        'user_id' => Auth::id(),
                        'order_id' => $order->id,
                        'status_id' => $request->status_id
                    ]);
                    event(new changeOrderStatus([
                        'user_id' => Auth::id(),
                        'status_id' => $request->status_id,
                        'order' => $order,
                        'status_name' => $order->status->name
                    ]));
                }
            }
            return redirect()->back()->with('success', translate('updated successfuly'));
        }
    }


    public function approve(Request $request, Order $order) {
        $order->update([
            'under_approve' => 0
        ]);
        return redirect()->back()->with('success', translate('updated successfuly'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        $this->authorize('orders.destroy');
        Order::destroy($order->id);
        return redirect()->back()->with('success', translate('deleted successfully'));
    }
}
