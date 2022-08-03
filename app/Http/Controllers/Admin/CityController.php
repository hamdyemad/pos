<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\CityPrice;
use App\Models\Country;
use App\Models\Currency;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Country $country)
    {
        $this->authorize('countries.index');
        Carbon::setLocale(app()->getLocale());
        $cities = City::where('country_id', $country->id)->latest();
        if($request->name) {
            $cities = $cities->where('name', 'like', '%'. $request->name . '%');
        }
        $cities = $cities->paginate(10);
        return view('countries.cities.index', compact('cities', 'country'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Country $country)
    {
        $this->authorize('countries.create');
        $currencies = Currency::all();
        if(count($currencies) > 0) {
            return view('countries.cities.create', compact('country', 'currencies'));
        } else {
            return redirect()->back()->with('error', translate('you should add currency first'));
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
        $this->authorize('countries.create');
        $creation =  [
            'name' => $request->name,
            'country_id' => $request->country_id
        ];
        $rules = [
            'name' => 'required|string|unique:cities,name',
            'prices.*.price' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'prices.*.currency_id' => 'required|exists:currencies,id',
            'country_id' => 'required|exists:countries,id'
        ];
        $messages = [
            'name.required' => translate('the name is required'),
            'name.unique' => translate('you should choose a name is not already exists'),
            'name.regex' => translate('the price should be a number'),
            'prices.*.price.required' => translate('the price is required'),
            'prices.*.price.regex' => translate('the price should be a number'),
            'country_id.required' => translate('the country is required'),
            'country_id.exists' => translate('the name is required'),
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->with('error', translate('there is something error'))->withInput($request->all());
        }
        $city = City::create($creation);
        foreach ($request->prices as $price) {
            CityPrice::create([
                'city_id' => $city->id,
                'currency_id' => $price['currency_id'],
                'price' => $price['price'],
            ]);
        }
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
    public function edit(Country $country,City $city)
    {
        $this->authorize('countries.edit');
        return view('countries.cities.edit', compact('country', 'city'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Country $country, City $city)
    {
        $this->authorize('countries.edit');
        $creation =  [
            'name' => $request->name,
            'country_id' => $request->country_id
        ];
        $rules = [
            'name' => ['required','string', Rule::unique('cities', 'name')->ignore($city->id)],
            'prices.*.price' => 'required|regex:/^\d+(\.\d{1,2})?$/|min:2',
            'prices.*.currency_id' => 'required|exists:currencies,id',
            'country_id' => 'required|exists:countries,id'
        ];
        $messages = [
            'name.required' => translate('the name is required'),
            'name.unique' => translate('you should choose a name is not already exists'),
            'name.regex' => translate('the price should be a number'),
            'prices.*.price.required' => translate('the price is required'),
            'prices.*.price.regex' => translate('the price should be a number'),
            'country_id.required' => translate('the country is required'),
            'country_id.exists' => translate('the name is required'),
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->with('error', translate('there is something error'))->withInput($request->all());
        }
        $city->update($creation);
        CityPrice::where('city_id', $city->id)->delete();
        foreach ($request->prices as $price) {
            CityPrice::create([
                'city_id' => $city->id,
                'currency_id' => $price['currency_id'],
                'price' => $price['price'],
            ]);
        }
        return redirect()->back()->with('info', translate('updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Country $country,City $city)
    {

        $this->authorize('countries.destroy');
        City::destroy($city->id);
        return redirect()->back()->with('error', translate('deleted successfully'));
    }
}
