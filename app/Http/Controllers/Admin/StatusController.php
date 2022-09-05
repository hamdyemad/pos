<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permession;
use App\Models\Status;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('statuses.index');
        Carbon::setLocale(app()->getLocale());
        $statuses = Status::latest();
        if($request->name) {
           $statuses->where('name', 'like', '%' . $request->name . '%');
        }
        if($request->order_type) {
            $statuses->where('order_type', 'like', '%' . $request->order_type . '%');
         }
        $statuses = $statuses->paginate(10);
        return view('orders.statuses.index', compact('statuses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('statuses.create');
        return view('orders.statuses.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('statuses.create');
        $creation = [
            'name' => $request->name,
            'order_type' => $request->order_type
        ];
        $rules = [
            'name' => 'required|unique:statuses,name',
            'order_type' => 'required|in:inhouse,online'
        ];
        $validator = Validator::make($request->all(), $rules, [
            'name.required' => translate('the name is required'),
            'name.unique' => translate('the name is already exists'),
            'order_type.required' => translate('the order type is required'),

        ]);

        if($request->type) {
            $rules['type'] = 'in:paid,under_collection,returned,default';
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
            } else if($request->type == 'paid') {
                $creation['paid'] = 1;
                $type = 'paid';

            } else if($request->type == 'returned') {
                $creation['returned'] = 1;
                $type = 'returned';

            } else if($request->type == 'under_collection') {
                $creation['under_collection'] = 1;
                $type = 'under_collection';
            }
            $finded = Status::where($type, 1)->first();
            if($finded) {
                $finded->update([
                    $type => 0
                ]);
            }
        }
        $status = Status::create($creation);
        permession_maker($request->name, $status->id, 'الحالات');
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
    public function edit(Status $status)
    {
        $this->authorize('statuses.edit');
        return view('orders.statuses.edit', compact('status'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Status $status)
    {
        $this->authorize('statuses.edit');
        $creation = [
            'name' => $request->name,
            'order_type' => $request->order_type
        ];
        $validator = Validator::make($request->all(), [
            'name' => ['required', Rule::unique('statuses', 'name')->ignore($status->id)],
            'order_type' => 'required|in:inhouse,online'
        ], [
            'name.required' => translate('the name is required'),
            'name.unique' => translate('the name is already exists'),
            'order_type.required' => translate('the order type is required'),
        ]);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())
            ->withInput($request->all())
            ->with('error', translate('there is some thing error'));
        }
        $status->update([
            'default_val' => 0,
            'paid' => 0,
            'returned' => 0,
            'under_collection' => 0,
        ]);

        if($request->type) {
            if($request->type == 'default') {
                $type = 'default_val';
                $creation['default_val'] = 1;
            } else if($request->type == 'paid') {
                $creation['paid'] = 1;
                $type = 'paid';

            } else if($request->type == 'returned') {
                $creation['returned'] = 1;
                $type = 'returned';

            } else if($request->type == 'under_collection') {
                $creation['under_collection'] = 1;
                $type = 'under_collection';
            }
            $finded = Status::where($type, 1)->first();
            if($finded) {
                $finded->update([
                    $type => 0
                ]);
            }
        }
        $permession = Permession::where('key', $status->id)->first();
        if(!$permession) {
            permession_maker($request->name, $status->id, 'الحالات');
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
    public function destroy(Status $status)
    {
        $this->authorize('statuses.destroy');
        Status::destroy($status->id);
        Permession::where('key', $status->id)->delete();
        return redirect()->back()->with('success', translate('deleted successfully'));
    }
}
