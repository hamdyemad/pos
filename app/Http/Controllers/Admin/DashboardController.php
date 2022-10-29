<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\BranchProductQty;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders_branches =  Order::where('type', 'inhouse')->latest()->limit(10)->get();
        $orders_online = Order::where('type', 'online')->latest()->limit(10)->get();
        $productsCount = Product::all()->count();
        $categoriesCount = Category::all()->count();
        $branchesCount = Branch::all()->count();
        $ordersCount = Order::all()->count();
        $statuses = Status::orderBy('name')->get();

        // if(Auth::user()->type == 'admin') {
        //     $categories = Category::all();
        //     foreach($categories as $category) {
        //         foreach($category->products as $product) {
        //             foreach($product->variants as $variant) {
        //                 $variant->count = 5000;
        //                 $variant->save();
        //                 foreach($category->branches as $branch) {
        //                     BranchProductQty::create([
        //                         'branch_id' => $branch->id,
        //                         'product_id' => $product->id,
        //                         'variant_id' => $variant->id,
        //                         'qty' => 5000
        //                     ]);

        //                 }
        //             }
        //         }
        //     }
        // }
        return view('dashboard.index', compact('productsCount', 'categoriesCount',
        'branchesCount', 'ordersCount', 'orders_branches', 'orders_online'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function destroy($id)
    {
        //
    }
}
