<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('customers.index');
        $customers = Customer::latest();
        if($request->name) {
        $customers->where('name', 'like', '%' . $request->name . '%');
        }
        if($request->phone) {
            $customers->where('phone', 'like', '%' . $request->phone . '%');
        }
        if($request->email) {
            $customers->where('email', 'like', '%' . $request->email . '%');
        }
        if($request->type) {
            $customers->where('type', 'like', '%' . $request->type . '%');
        }
        if($request->address) {
            $customers->where('address', 'like', '%' . $request->address . '%');
        }
        $customers = $customers->paginate(10);
        return view('customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('customers.create');
        return view('customers.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('customers.create');
        $rules = [
            'name' => 'required|string',
            'address' => 'required|string',
            'phone' => 'required|string',
            'email' => 'string',
            'type' => 'in:regular,special'
        ];
        $messages = [
            'name.required' => translate('the name is required'),
            'name.unique' => translate('you should choose a name is not already exists'),
            'address.required' => translate('the address is required'),
            'phone.required' => translate('the phone is required'),
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->with('error', 'يوجد مشكلة ما')->withInput($request->all());
        }
        Customer::create([
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
            'type' => $request->type
        ]);
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
    public function edit(Request $request, Customer $customer)
    {
        $this->authorize('customers.edit');
        return view('customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        $this->authorize('customers.edit');
        $rules = [
            'name' => ['required','string'],
            'address' => 'required|string',
            'phone' => 'required|string',
            'email' => 'string',
            'type' => 'in:regular,special'
        ];
        $messages = [
            'name.required' => translate('the name is required'),
            'name.unique' => translate('you should choose a name is not already exists'),
            'address.required' => translate('the address is required'),
            'phone.required' => translate('the phone is required'),
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->with('error', translate('there is something error'))->withInput($request->all());
        }
        $customer->update([
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
            'type' => $request->type
        ]);
        return redirect()->back()->with('success', translate('updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        $this->authorize('customers.destroy');
        $customer->delete();
        return redirect()->back()->with('error', translate('deleted successfully'));
    }
}
