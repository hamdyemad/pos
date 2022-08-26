<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Order;
use App\Traits\Res;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Framework\Constraint\Count;

class CouponController extends Controller
{
    use Res;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $coupons = Coupon::latest();
        if($request->code) {
            $coupons->where('code', 'like', '%' . $request->code . '%');
        }
        $coupons = $coupons->paginate(10);
        return view('coupons.index', compact('coupons'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('coupons.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|unique:coupons,code',
            'type' => 'required|in:price,percent',
            'price' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'count' => 'required|integer',
            'valid_before' => 'date'
        ]);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->with('error', translate('there is something error'))->withInput($request->all());
        }
        Coupon::create([
            'code' => $request->code,
            'type' => $request->type,
            'price' => $request->price,
            'count' => $request->count,
            'valid_before' => $request->valid_before,
        ]);
        return redirect()->back()->with('success', translate('created successfully'));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $coupon = Coupon::where('code', $request->coupon_code)->first();

        $ordersCountForCoupon = Order::where('coupon_id', $coupon->id)->count();

        $coupon = Coupon::where('code', $request->coupon_code)
        ->where('count', '>', $ordersCountForCoupon)
        ->whereDate('valid_before', '>', Carbon::now())
        ->first();
        if($coupon) {
            return $this->sendRes('', true, $coupon);
        } else {
            return $this->sendRes(translate('coupon is invalid'), false);
        }
        return $coupon;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Coupon $coupon)
    {
        $coupon->delete();
        return redirect()->back()->with('success', translate('deleted successfully'));
    }
}
