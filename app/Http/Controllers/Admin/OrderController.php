<?php

namespace App\Http\Controllers\Admin;

use App\Events\changeOrderStatus;
use App\Events\newOrder;
use App\Exports\OrderExport;
use App\Http\Controllers\Controller;
use App\Models\ApprovalOrder;
use App\Models\Branch;
use App\Models\Category;
use App\Models\City;
use App\Models\Country;
use App\Models\Coupon;
use App\Models\Customer;
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
use Maatwebsite\Excel\Facades\Excel;

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
        if(count(Auth::user()->statuses_permessions()) > 0) {
            $orders = $orders->whereIn('status_id', Auth::user()->statuses_permessions());
        }
        $statuses = Status::all();
        if(Auth::user()->role_type == 'online') {
            $statuses = Status::where('order_type', 'online')->get();
            if(!$request->customer_id) {
                $orders = $orders->where('type', 'online');
            }

        }
        if(Auth::user()->role_type == 'inhouse') {
            $statuses = Status::where('order_type', 'inhouse')->get();
            if(!$request->customer_id) {
                $orders = $orders->where('type', 'inhouse');
            }
        }
        $branches = Branch::all();
        $customers = Customer::all();
        if($request->id) {
            $orders = $orders->where('id', 'like', '%' . $request->id .'%');
        }
        if($request->type) {
            $orders = $orders->where('type', 'like', '%' . $request->type .'%');
        }
        if($request->branch_id) {
            $orders = $orders->where('branch_id', 'like', '%' . $request->branch_id .'%');
        }
        if($request->customer_id) {
            $orders = $orders->where('customer_id', 'like', '%' . $request->customer_id .'%');

        }
        if($request->status_id) {
            $orders = $orders->where('status_id', 'like', '%' . $request->status_id .'%');
        }
        if($request->from) {
            $orders = $orders->whereDate('created_at', '>=', $request->from);
        }
        if($request->to) {
            $orders = $orders->whereDate('created_at', '<=', $request->to);
        }
        if($request->to && $request->from) {
            $orders = $orders
            ->whereDate('created_at', '<=', $request->to)
            ->whereDate('created_at', '>=', $request->from);
        }

        if($request->export == 'excel') {
            return Excel::download(new OrderExport($orders->get(), $request->order_type), 'orders.xlsx');
        }


        $orders = $orders->paginate(10);

        return view('orders.index', compact('orders', 'statuses', 'branches', 'customers'));
    }

    public function with_bin_codes(Request $request) {
        $this->authorize('approval_orders.index');
        Carbon::setLocale(app()->getLocale());
        $orders = Order::where('bin_code', '!=', 'null')->latest();
        if(count(Auth::user()->statuses_permessions()) > 0) {
            $orders->whereIn('status_id', Auth::user()->statuses_permessions());
        }
        $statuses = Status::all();
        $branches = Branch::all();
        $customers = Customer::all();

        if($request->id) {
            $orders = $orders->where('id', 'like', '%' . $request->id .'%');
        }
        if($request->type) {
            $orders = $orders->where('type', 'like', '%' . $request->type .'%');
        }
        if($request->branch_id) {
            $orders = $orders->where('branch_id', 'like', '%' . $request->branch_id .'%');
        }
        if($request->customer_id) {
            $orders = $orders->where('customer_id', 'like', '%' . $request->customer_id .'%');
        }
        if($request->status_id) {
            $orders = $orders->where('status_id', 'like', '%' . $request->status_id .'%');
        }
        if($request->from) {
            $orders = $orders->whereDate('created_at', '>=', $request->from);
        }
        if($request->to) {
            $orders = $orders->whereDate('created_at', '<=', $request->to);
        }

        if($request->to && $request->from) {
            $orders = $orders
            ->whereDate('created_at', '<=', $request->to)
            ->whereDate('created_at', '>=', $request->from);
        }

        if($request->export == 'excel') {
            return Excel::download(new OrderExport($orders->get(), true), 'orders.xlsx');
        }

        $orders = $orders->paginate(10);
        return view('orders.bin_codes', compact('orders', 'statuses', 'branches', 'customers'));
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
            $branches = Branch::orderBy('name')->get();
            $customers = Customer::orderBy('name')->get();
            return view('orders.create', compact('branches', 'countries', 'customers'));
        } else {
            return redirect()->back()->with('error', translate('a default status must be set'));
        }
    }

    public function validateOrder($request) {
        $rules = [
            'type' => 'required|in:inhouse,online',
            'branch_id' => 'required|exists:branches,id',
            'customer_id' => 'required|exists:customers,id',
            'products' => 'required',
            'bin_code' => 'exists:users,bin_code',
            'payment_method' => 'required|in:cash,credit'
        ];
        $mesages = [
            'type.required' => translate('the type is required'),
            'branch_id.required' => translate('the branch is required'),
            'branch_id.exists' => translate('the branch should be exists'),
            'type.in' => translate('you should choose a type from the stock'),
            'products.*.required' => translate('you should choose a minmum 1 product'),
        ];
        if($request->customer_id == null) {
            unset($rules['customer_id']);
            $rules['customer_name'] = 'required';
            $rules['customer_address'] = 'required';
            $rules['customer_phone'] = 'required';
            $rules['customer_type'] = 'in:regular,special';
            $mesages['customer_name.required'] = translate('the name is required');
            $mesages['customer_address.required'] = translate('the address is required');
            $mesages['customer_phone.required'] =translate('the phone is required');
        }
        if($request->type == 'online') {
            unset($rules['branch_id']);
            $rules['city_id'] = 'required';
            $mesages['city_id.required'] = translate('the city is required');
        }
        if($request->products) {
            foreach ($request->products as $i => $productObj) {
                $rules["products.$i.id"] = ['required'];
                $rules["products.$i.amount"] = ['required','integer','min:1'];
                $mesages["products.$i.amount.required"] = translate('the amount is required');
                $mesages["products.$i.amount.min"] = translate('the amount should be at least 1');
                if(isset($productObj['variant_id'])) {
                    $rules["products.$i.variant_id"] = ['required'];
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
                'customer_id' => $request->customer_id,
                'notes' => $request->notes,
                'discount_type' => $request->discount_type,
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
            if($request->customer_id == null) {
                $customer = Customer::create([
                    'name' => $request->customer_name,
                    'phone' => $request->customer_phone,
                    'email' => $request->customer_email,
                    'address' => $request->customer_address,
                    'type' => $request->customer_type,
                ]);
                $creation['customer_id'] = $customer->id;
            }
            $grand_total = [];
            $order = Order::create($creation);
            StatusHistory::create([
                'user_id' => Auth::id(),
                'order_id' => $order->id,
                'status_id' => $status->id
            ]);
            foreach ($request->products as $index => $productObj) {
                $product = Product::find($productObj['id']);
                if($product) {
                    if(isset($productObj['variant_id'])) {
                        $productVariant = ProductVariant::find($productObj['variant_id']);
                        if($productVariant) {
                            $orderDetailCreation = [
                                'order_id' => $order->id,
                                'product_id' => $product->id,
                                'variant' => $productVariant->variant,
                                'variant_type' => $productVariant->type,
                                'price' => $productVariant->currenctPriceOfVariant->price_after_discount,
                                'qty' => $productObj['amount'],
                                'discount' => $productObj['discount'],
                                'notes' => $productObj['notes'],
                                'total_price' => $productVariant->currenctPriceOfVariant->price_after_discount * $productObj['amount']
                            ];
                            if(isset($productObj['files'])) {
                                foreach ($request->file("products.$index.files") as $file) {
                                    $files[] = $this->uploadFiles($file, $this->ordersPath);
                                }
                                $orderDetailCreation['files'] = json_encode($files);
                                $files = [];
                            }
                            OrderDetail::create($orderDetailCreation);
                            $total_price = $productVariant->currenctPriceOfVariant->price_after_discount * $productObj['amount'];
                            if($request->discount_type == 'amount') {
                                $pricePushedToGrand = ($total_price - $productObj['discount']);
                            } else {
                                $pricePushedToGrand = $total_price - (($total_price * $productObj['discount']) / 100);
                            }
                            array_push($grand_total, $pricePushedToGrand);
                        }
                    } else {
                        $price = $product->price_of_currency()->first();
                        $orderDetailCreation = [
                            'order_id' => $order->id,
                            'product_id' => $productObj['id'],
                            'price' => $price->price_after_discount,
                            'discount' => $productObj['discount'],
                            'notes' => $productObj['notes'],
                            'qty' => $productObj['amount'],
                            'total_price' => $price->price_after_discount * $productObj['amount']
                        ];
                        if(isset($productObj['files'])) {
                            foreach ($request->file("products.$index.files") as $file) {
                                $files[] = $this->uploadFiles($file, $this->ordersPath);
                            }
                            $orderDetailCreation['files'] = json_encode($files);
                            $files = [];
                        }
                        OrderDetail::create($orderDetailCreation);
                        $total_price = $price->price_after_discount * $productObj['amount'];
                        if($request->discount_type == 'amount') {
                            $pricePushedToGrand = ($total_price - $productObj['discount']);
                        } else {
                            $pricePushedToGrand = $total_price - (($total_price * $productObj['discount']) / 100);
                        }
                        array_push($grand_total, $pricePushedToGrand);
                    }
                }
            }
            $grand_total = array_reduce($grand_total,
            function($acc, $current) {return $acc + $current;});

            $grand_total_price = $grand_total + $request->shipping;
            if($request->discount_type == 'amount') {
                $grand_total = ($grand_total_price - $creation['total_discount']);
            } else {
                $grand_total = $grand_total_price - (($grand_total_price * $creation['total_discount']) / 100);
            }
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
            if($request->print == 'true') {
                $request['type'] = 'pos';
                return $this->pdf($request, $order);
            }
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
        $approval_orders = ApprovalOrder::where('order_id', $order->id)->latest()->get();
        return view('orders.show', compact('order', 'statuses_history', 'approval_orders'));
    }

    public function pdf(Request $request,Order $order) {
        $currenctLang = Language::where('regional','like', '%' . app()->getLocale() . '%')->first();
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
        $currenctLang = Language::where('regional','like', '%' . app()->getLocale() . '%')->first();
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
            $customers = Customer::orderBy('name')->get();
            $countries = Country::where('active', '1')->get();
            $branches = Branch::orderBy('name')->get();
            if($order->city) {
                $cities = City::where('country_id', $order->city->country_id)->get();
            } else {
                $cities = [];
            }

            if(Auth::user()->type == 'admin' || Auth::user()->type == 'sub-admin' || Auth::user()->role_type == 'online') {
                $products = Product::with('variants', 'price_of_currency')->latest()->get();
            }
            if(Auth::user()->role_type == 'inhouse') {
                $categories_ids = Category::whereHas('branches', function($query) {
                    return $query->where('branch_id', Auth::user()->branch_id);
                })->latest()->pluck('id');
                $products = Product::with('variants', 'price_of_currency')->whereHas('categories', function($query) use($categories_ids) {
                    return $query->whereIn('category_id', $categories_ids);
                })->latest()->get();
            }
            return view('orders.edit', compact('order', 'branches', 'products', 'countries', 'cities', 'customers'));

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
        $creation = [
            'type' => $request->type,
            'branch_id' => $request->branch_id,
            'coupon_id' => $request->coupon_id,
            'user_id' => Auth::id(),
            'payment_method' => $request->payment_method,
            'city_id' => $request->city_id,
            'customer_id' => $request->customer_id,
            'notes' => $request->notes,
            'discount_type' => $request->discount_type,
            'total_discount' => $request->total_discount,
            'shipping' => $request->shipping,
            'grand_total' => 0
        ];
        if($this->validateOrder($request)) {
            return $this->validateOrder($request);
        }

        if($request->customer_id == null) {
            $customer = Customer::create([
                'name' => $request->customer_name,
                'phone' => $request->customer_phone,
                'email' => $request->customer_email,
                'address' => $request->customer_address,
                'type' => $request->customer_type,
            ]);
            $creation['customer_id'] = $customer->id;
        }

        $grand_total = [];
        $order->update($creation);
        foreach ($request->products as $indexOfProduct => $productObj) {
            $product = Product::find($productObj['id']);
            if($product) {
                if(isset($productObj['variant_id'])) {
                    $productVariant = ProductVariant::find($productObj['variant_id']);
                    if($productVariant) {
                        $orderDetailCreation = [
                            'order_id' => $order->id,
                            'product_id' => $product->id,
                            'variant' => $productVariant->variant,
                            'variant_type' => $productVariant->type,
                            'price' => $productVariant->currenctPriceOfVariant->price_after_discount,
                            'qty' => $productObj['amount'],
                            'discount' => $productObj['discount'],
                            'notes' => $productObj['notes'],
                            'total_price' => $productVariant->currenctPriceOfVariant->price_after_discount * $productObj['amount']
                        ];
                        if(isset($productObj['order_detail_id'])) {
                            $order_detail = OrderDetail::find($productObj['order_detail_id']);
                        }
                        if(isset($productObj['files'])) {
                            $files = [];
                            if(isset($productObj['update'])) {
                                if($productObj['old_id'] !== $productObj['id']) {
                                    $order_detail_old = OrderDetail::where(['order_id' => $order->id,
                                        'product_id' => $productObj['old_id']])->first();
                                    if($order_detail_old['files']) {
                                        $files = json_decode($order_detail_old['files']);
                                        foreach ($files as $file) {
                                            if(file_exists($file)) {
                                                unlink($file);
                                            }
                                        }
                                    }
                                    $order_detail_old->delete();
                                }
                                if($order_detail) {
                                    if($order_detail->files) {
                                        $files = json_decode($order_detail->files);
                                    }
                                }
                            }
                            foreach ($request->file("products.$indexOfProduct.files") as $file) {
                                array_push($files, $this->uploadFiles($file, $this->ordersPath));
                            }
                            $orderDetailCreation['files'] = json_encode($files);
                        }
                        if(isset($productObj['update'])) {
                            if($order_detail) {
                                $order_detail->update($orderDetailCreation);
                            }
                        } else {
                            OrderDetail::create($orderDetailCreation);
                        }

                        $total_price = $productVariant->currenctPriceOfVariant->price_after_discount * $productObj['amount'];
                        if($request->discount_type == 'amount') {
                            $pricePushedToGrand = ($total_price - $productObj['discount']);
                        } else {
                            $pricePushedToGrand = $total_price - (($total_price * $productObj['discount']) / 100);
                        }
                        array_push($grand_total, $pricePushedToGrand);
                    }
                } else {
                    $orderDetailCreation = [
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'price' => $product->price_of_currency->price_after_discount,
                        'qty' => $productObj['amount'],
                        'discount' => $productObj['discount'],
                        'notes' => $productObj['notes'],
                        'total_price' => $product->price_of_currency->price_after_discount * $productObj['amount']
                    ];
                    $order_detail = OrderDetail::where(['order_id' => $order->id, 'product_id' => $product->id, 'variant' => null])->first();
                    if(isset($productObj['files'])) {
                        $files = [];
                        if(isset($productObj['update'])) {
                            if($order_detail) {
                                if($order_detail->files) {
                                    $files = json_decode($order_detail->files);
                                }
                            }
                        }
                        foreach ($request->file("products.$indexOfProduct.files") as $file) {
                            array_push($files, $this->uploadFiles($file, $this->ordersPath));
                        }
                        $orderDetailCreation['files'] = json_encode($files);
                    }
                    if(isset($productObj['update'])) {
                        if($productObj['old_id'] !== $productObj['id']) {
                            $order_detail_old = OrderDetail::where(['order_id' => $order->id,
                                'product_id' => $productObj['old_id']])->first();
                            if($order_detail_old['files']) {
                                $files = json_decode($order_detail_old['files']);
                                foreach ($files as $file) {
                                    if(file_exists($file)) {
                                        unlink($file);
                                    }
                                }
                            }
                            $order_detail_old->delete();
                        }
                        if($order_detail) {
                            $order_detail->update($orderDetailCreation);
                        } else {
                            OrderDetail::create($orderDetailCreation);
                        }
                    } else {
                        OrderDetail::create($orderDetailCreation);
                    }
                    $total_price = $product->price_of_currency->price_after_discount * $productObj['amount'];
                    if($request->discount_type == 'amount') {
                        $pricePushedToGrand = ($total_price - $productObj['discount']);
                    } else {
                        $pricePushedToGrand = $total_price - (($total_price * $productObj['discount']) / 100);
                    }
                    array_push($grand_total, $pricePushedToGrand);
                }
            } else {
                return redirect()->back()->with('error', translate('product is not exists'));
            }
        }
        $grand_total = array_reduce($grand_total,
        function($acc, $current) {return $acc + $current;});
        $grand_total_price = $grand_total + $request->shipping;
        if($request->discount_type == 'amount') {
            $grand_total = ($grand_total_price - $creation['total_discount']);
        } else {
            $grand_total = $grand_total_price - (($grand_total_price * $creation['total_discount']) / 100);
        }
        $order->grand_total = $grand_total;
        $order->save();
        return redirect()->back()->with('info', translate('updated successfully'));
    }

    public function order_details_destroy(Request $request) {
        $order_detail = OrderDetail::find($request->id);
;
        $order_detail->order->grand_total -= $order_detail->total_price;
        $order_detail->order->save();
        if($order_detail['files']) {
            $files = json_decode($order_detail['files']);
            foreach ($files as $file) {
                if(file_exists($file)) {
                    unlink($file);
                }
            }
        }
        $order_detail->delete();
        return redirect()->back()->with('success', translate('deleted successfully'));
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
        if($request->type == 'unapprove') {
            $order->update([
                'under_approve' => '1'
            ]);
            ApprovalOrder::create([
                'user_id' => Auth::id(),
                'order_id' => $order->id,
                'approved' => '1'
            ]);
        } else {
            $order->update([
                'under_approve' => '0'
            ]);
            ApprovalOrder::create([
                'user_id' => Auth::id(),
                'order_id' => $order->id,
                'approved' => '0'
            ]);
        }
        return redirect()->back()->with('success', translate('updated successfuly'));
    }

    public function unbin(Request $request, Order $order) {
        $this->authorize('orders.unbin');
        $order->update([
            'bin_code' => null
        ]);
        return redirect()->back()->with('success', translate('updated successfuly'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    public function remove_files(Request $request,Order $order) {
        if($request->variant == 'undefined') {
            $order_detail = OrderDetail::where(['order_id' => $order->id, 'product_id' => $request->product])->first();
        } else {
            $order_detail = OrderDetail::find($request->variant);
        }
        if($order_detail->files) {
            $files = json_decode($order_detail->files);
            if(count($files) > 0) {
                $index = array_search($request->file, $files);
                if(file_exists($request->file)) {
                    array_splice($files, $index, 1);
                    unlink($request->file);
                }
                $order_detail->update([
                    'files' => json_encode($files)
                ]);
            }
        }
        return redirect()->back()->with('success', translate('file removed successfully'));

    }

    public function destroy(Order $order)
    {
        $this->authorize('orders.destroy');
        foreach ($order->order_details as $detail) {
            if($detail->files) {
                $files = json_decode($detail->files);
                if(count($files) > 0) {
                    foreach ($files as $file) {
                        if(file_exists($file)) {
                            unlink($file);
                        }
                    }
                }
            }
        }
        Order::destroy($order->id);
        return redirect()->back()->with('success', translate('deleted successfully'));
    }
}
