<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\BranchProductQty;
use App\Models\Product;
use App\Models\ProductTransaction;
use App\Models\ProductTransactionItem;
use App\Models\ProductTransactionStatus;
use App\Models\ProductVariant;
use App\Traits\Res;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductTransactioController extends Controller
{
    use Res;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('products.transactions.index');
        $transactions = ProductTransaction::latest();
        $statuses = ProductTransactionStatus::all();
        $branches = Branch::all();
        if($request->main_status_id) {
            $transactions = $transactions->where('main_status_id', $request->main_status_id);
        }
        if($request->branch_status_id) {
            $transactions = $transactions->where('branch_status_id', $request->branch_status_id);
        }
        if($request->branch_id) {
            $transactions = $transactions->where('branch_id', $request->branch_id);
        }

        $transactions = $transactions->paginate(10);
        return view('categories.products.transactions.index', compact('transactions', 'statuses', 'branches'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('products.transactions.create');
        $branches = Branch::all();
        return view('categories.products.transactions.create', compact('branches'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('products.transactions.create');
        $status = ProductTransactionStatus::where('default_val', 1)->first();
        if($status) {
            $rules = [
                'branch_id' => ['required'],
                'products' => ['required'],
                'products.*.id' => ['required', 'exists:products,id'],
                'products.*.variant_id' => ['exists:products_variations,id'],
                'products.*.amount' => ['required', 'integer'],
            ];
            $messages = [
                'branch_id.required' => translate('branch is required'),
                'products.*.id.required' => translate('product is required'),
                'products.*.amount.required' => translate('product amount is required'),
                'products.*.amount.integer' => translate('product amount should be integer'),
                'branch_id.required' => translate('branch is required'),
                'branch_id.required' => translate('branch is required'),
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())
                ->withInput($request->all())
                ->with('error', translate('there is something error'));
            }

            $transaction = ProductTransaction::create([
                'branch_status_id' => $status->id,
                'main_status_id' => $status->id,
                'branch_id' => $request->branch_id
            ]);

            foreach($request->products as $product) {
                $item = [
                    'transaction_id' => $transaction->id,
                    'product_id' => $product['id'],
                    'variant_id' => $product['variant_id'],
                    'qty' => $product['amount'],
                    'notes' => $product['notes'],
                ];
                ProductTransactionItem::create($item);
            }
            return redirect()->to(route('products.transactions.index'))->with('success', translate('created successfully !'));

        } else {
            return redirect()->to(route('products.statuses.create'))->with('info', translate('you should add default status first !'));
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(ProductTransaction $transaction)
    {
        $this->authorize('products.transactions.show');
        return view('categories.products.transactions.show', compact('transaction'));
    }

    public function update_main_status(Request $request) {
        $transaction = ProductTransaction::find($request->transaction_id);
        if($request->type == 'main') {
            $transaction->main_status_id = $request->status_id;
        } else {
            $transaction->branch_status_id = $request->status_id;
        }
        $transaction->save();
        return $this->sendRes(translate('status updated successfully'), true);
    }

    public function update_status(Request $request) {
        $item = ProductTransactionItem::find($request->item_id);
        if($item) {
            $search = [
                'variant_id' => $item->variant_id,
                'branch_id' => $item->transaction->branch_id,
                'product_id' => $item['product_id'],
            ];
            $creation = [
                'branch_id' => $item->transaction->branch_id,
                'product_id' => $item['product_id'],
                'variant_id' => $item['variant_id'],
                'qty' => $item['qty']
            ];
            $branchQtyModel = BranchProductQty::where(
                $search
             )->first();

            if($request->status_text == 'accepted') {
                if($request->type == 'main') {
                    $item->main_accepted= 1;
                    $item->main_refused = 0;
                    if($item->variant_id) {
                        $product_variant = ProductVariant::find($item->variant_id);
                        $product_variant->count -= $item['qty'];
                        $product_variant->save();
                    } else {
                        unset($search['variant_id']);
                        unset($creation['variant_id']);
                        $productModel = Product::find($item['product_id']);
                        $productModel->count -= $item['qty'];
                        $productModel->save();
                    }


                    if($branchQtyModel) {
                        $branchQtyModel->update([
                            'qty' => $branchQtyModel['qty'] + $item['qty']
                        ]);
                    } else {
                        BranchProductQty::create($creation);
                    }
                } else {
                    $item->branch_accepted= 1;
                    $item->branch_refused = 0;
                }
            }
            if($request->status_text == 'refused') {
                if($request->type == 'main') {
                    $item->main_refused = 1;
                    $item->main_accepted= 0;

                    if($item->variant_id) {
                        $product_variant = ProductVariant::find($item->variant_id);
                        $product_variant->count += $item['qty'];
                        $product_variant->save();
                    } else {
                        unset($search['variant_id']);
                        unset($creation['variant_id']);
                        $productModel = Product::find($item['product_id']);
                        $productModel->count += $item['qty'];
                        $productModel->save();
                    }
                } else {
                    $item->branch_refused = 1;
                    $item->branch_accepted= 0;
                }

                if($branchQtyModel) {
                    $branchQtyModel->update([
                        'qty' => $branchQtyModel['qty'] - $item['qty']
                    ]);
                } else {
                    BranchProductQty::create($creation);
                }

            }
            $item->reason = $request->reason;
            $item->save();
            return redirect()->back()->with('success', translate('status changed successfully !'));

        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductTransaction $transaction)
    {
        $this->authorize('products.transactions.edit');
        $branches = Branch::all();
        return view('categories.products.transactions.edit', compact('branches', 'transaction'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductTransaction $transaction)
    {
        $this->authorize('products.transactions.edit');
        $rules = [
            'branch_id' => ['required'],
            'products' => ['required'],
            'products.*.id' => ['required', 'exists:products,id'],
            'products.*.variant_id' => ['exists:products_variations,id'],
            'products.*.amount' => ['required', 'integer'],
        ];
        $messages = [
            'branch_id.required' => translate('branch is required'),
            'products.*.id.required' => translate('product is required'),
            'products.*.amount.required' => translate('product amount is required'),
            'products.*.amount.integer' => translate('product amount should be integer'),
            'branch_id.required' => translate('branch is required'),
            'branch_id.required' => translate('branch is required'),
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())
            ->withInput($request->all())
            ->with('error', translate('there is something error'));
        }

        $transaction->update([
            'branch_id' => $request->branch_id
        ]);

        $transaction->items()->delete();
        foreach($request->products as $product) {
            $item = [
                'transaction_id' => $transaction->id,
                'product_id' => $product['id'],
                'variant_id' => $product['variant_id'],
                'qty' => $product['amount'],
                'notes' => $product['notes'],
            ];
            ProductTransactionItem::create($item);
        }
        return redirect()->to(route('products.transactions.index'))->with('success', translate('created successfully !'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductTransaction $transaction)
    {
        $this->authorize('products.transactions.destroy');
        $transaction->delete();
        return redirect()->back()->with('success', translate('deleted successfully !'));

    }
}
