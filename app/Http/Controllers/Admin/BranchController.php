<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('branches.index');
        Carbon::setLocale(app()->getLocale());
        $branches = Branch::latest();
        if($request->name) {
           $branches->where('name', 'like', '%' . $request->name . '%');
        }
        if($request->phone) {
            $branches->where('phone', 'like', '%' . $request->phone . '%');
         }
         if($request->address) {
            $branches->where('address', 'like', '%' . $request->address . '%');
         }
        $branches = $branches->paginate(10);
        return view('branches.index', compact('branches'));


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('branches.create');
        return view('branches.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('branches.create');
        $rules = [
            'name' => 'required|string|unique:branches,name',
            'address' => 'required|string',
            'phone' => 'required|string'
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
        Branch::create([
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone
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
    public function edit(Branch $branch)
    {
        $this->authorize('branches.edit');
        return view('branches.edit', compact('branch'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Branch $branch)
    {
        $this->authorize('branches.edit');
        $rules = [
            'name' => ['required','string', Rule::unique('branches', 'name')->ignore($branch->id)],
            'address' => 'required|string',
            'phone' => 'required|string'
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
        $branch->update([
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone
        ]);
        return redirect()->back()->with('info', translate('updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Branch $branch)
    {
        $this->authorize('branches.destroy');
        Branch::destroy($branch->id);
        return redirect()->back()->with('error', translate('deleted successfully'));
    }
}
