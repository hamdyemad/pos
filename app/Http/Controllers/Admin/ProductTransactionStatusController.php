<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permession;
use App\Models\ProductTransactionStatus;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProductTransactionStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('products.statuses.index');
        Carbon::setLocale(app()->getLocale());
        $statuses = ProductTransactionStatus::latest();
        if($request->name) {
           $statuses->where('name', 'like', '%' . $request->name . '%');
        }
        $statuses = $statuses->paginate(10);
        return view('categories.products.statuses.index', compact('statuses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('products.statuses.create');
        return view('categories.products.statuses.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('products.statuses.create');
        $creation = [
            'name' => $request->name
        ];
        $rules = [
            'name' => 'required|unique:product_transactions_statuses,name'
        ];
        $validator = Validator::make($request->all(), $rules, [
            'name.required' => translate('the name is required'),
            'name.unique' => translate('the name is already exists')

        ]);

        if($request->type) {
            $rules['type'] = 'in:accepted,returned,default';
        }
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())
            ->withInput($request->all())
            ->with('error', translate('there is some thing error'));
        }
        if($request->type) {
            if($request->type == 'default') {
                $type = 'default_val';
                $creation['default_val'] = 1;
            } else if($request->type == 'accepted') {
                $creation['accepted'] = 1;
                $type = 'accepted';

            } else if($request->type == 'returned') {
                $creation['returned'] = 1;
                $type = 'returned';

            }
            $finded = ProductTransactionStatus::where($type, 1)->first();
            if($finded) {
                $finded->update([
                    $type => 0
                ]);
            }
        }
        $status = ProductTransactionStatus::create($creation);
        return redirect()->back()->with('success', translate('created successfully'));

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
    public function edit(ProductTransactionStatus $status)
    {
        $this->authorize('products.statuses.edit');
        return view('categories.products.statuses.edit', compact('status'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductTransactionStatus $status)
    {
        $this->authorize('products.statuses.edit');
        $creation = [
            'name' => $request->name,
        ];
        $validator = Validator::make($request->all(), [
            'name' => ['required', Rule::unique('statuses', 'name')->ignore($status->id)],
        ], [
            'name.required' => translate('the name is required'),
            'name.unique' => translate('the name is already exists'),
        ]);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())
            ->withInput($request->all())
            ->with('error', translate('there is some thing error'));
        }
        $status->update([
            'default_val' => 0,
            'accepted' => 0,
            'returned' => 0,
        ]);

        if($request->type) {
            if($request->type == 'default') {
                $type = 'default_val';
                $creation['default_val'] = 1;
            } else if($request->type == 'accepted') {
                $creation['accepted'] = 1;
                $type = 'accepted';

            } else if($request->type == 'returned') {
                $creation['returned'] = 1;
                $type = 'returned';

            }
            $finded = ProductTransactionStatus::where($type, 1)->first();
            if($finded) {
                $finded->update([
                    $type => 0
                ]);
            }
        }
        $status->update($creation);
        return redirect()->back()->with('info', translate('updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductTransactionStatus $status)
    {
        $this->authorize('products.statuses.destroy');
        ProductTransactionStatus::destroy($status->id);
        Permession::where('key', $status->id)->delete();
        return redirect()->back()->with('success', translate('deleted successfully'));
    }
}
