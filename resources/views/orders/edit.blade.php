@extends('layouts.master')

@section('title')
{{ translate('edit order') }}
@endsection
@section('content')
    @component('common-components.breadcrumb')
        @slot('title') {{ translate('orders') }} @endslot
        @slot('li1') {{ translate('dashboard') }} @endslot
        @slot('li2') {{ translate('orders') }} @endslot
        @slot('route1') {{ route('dashboard') }} @endslot
        @slot('route2') {{ route('orders.index') }} @endslot
        @slot('li3') {{ translate('edit order') }} @endslot
    @endcomponent
    <div class="create_order edit_order">
        <div class="container">
            <div class="card">
                <div class="card-header">
                    {{ translate('edit order') }}
                </div>
                <div class="card-body">
                    <form action="{{ route('orders.edit', $order) }}" method="GET" id="orders_create">
                    </form>
                    <form action="{{ route('orders.update', $order) }}" method="POST" enctype="multipart/form-data">
                        @method("PATCH")
                        @csrf
                        @if(request('discount_type') == 'percent')
                            <input type="hidden" name="discount_type" value="percent">
                        @elseif(request('discount_type') == 'amount')
                            <input type="hidden" name="discount_type" value="amount">
                        @endif

                        @if(request('type') =='online')
                            <input type="hidden" name="type" value="online">
                        @elseif(request('type') =='inhouse')
                            <input type="hidden" name="type" value="inhouse">
                        @endif
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="type">{{ translate('discount type') }}</label>
                                    <select onchange="add_references('discount_type', $(this).val())" class="form-control discount_type select2" name="discount_type">
                                        <option value="amount"
                                        @if(request('discount_type') == 'amount')
                                            selected
                                        @elseif(request('discount_type') == null)
                                            @if($order->discount_type == 'amount') selected @endif
                                        @endif
                                        >{{ translate('amount') }}</option>
                                        <option value="percent"
                                        @if(request('discount_type') == 'percent')
                                            selected
                                        @elseif(request('discount_type') == null)
                                            @if($order->discount_type == 'percent') selected @endif
                                        @endif
                                        >{{ translate('percent') }}</option>
                                    </select>
                                    @error('discount_type')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="type">{{ translate('order type') }}</label>
                                    <select onchange="add_references('type', $(this).val())" class="form-control order_type select2" name="type">
                                        <option value="inhouse"
                                        @if(request('type') == 'inhouse')
                                            selected
                                        @elseif(request('type') == null)
                                            @if($order->type == 'inhouse') selected @endif
                                        @endif
                                        @if($order->type == 'inhouse') selected @endif
                                        >{{ translate('receipt from the branch') }}</option>
                                        <option value="online"
                                        @if(request('type') == 'online')
                                            selected
                                        @elseif(request('type') == null)
                                            @if($order->type == 'online') selected @endif
                                        @endif
                                        >{{ translate('online order') }}</option>
                                    </select>
                                    @error('type')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="payment_method">{{ translate('payment method') }}</label>
                                    <select class="form-control select2" name="payment_method">
                                        <option value="cash" @if($order->payment_method == 'cash') selected @endif>{{ translate('cash') }}</option>
                                        <option value="credit" @if($order->payment_method == 'credit') selected @endif>{{ translate('credit') }}</option>
                                    </select>
                                    @error('payment_method')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            @if(request('type') == 'inhouse' || $order->type == 'inhouse')
                                <div class="col-12 branch_col">
                                    <div class="form-group">
                                        <label for="branch_id">{{ translate('order branch creation') }}</label>
                                        <select class="form-control select2 branch_select" name="branch_id">
                                            @foreach ($branches as $branch)
                                                <option value="{{ $branch->id }}" @if($order->branch_id == $branch->id) selected @endif>{{ translate($branch->name) }}</option>
                                            @endforeach
                                        </select>
                                        @error('branch_id')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            @endif
                            @if(request('type') == 'online' || $order->type == 'online')
                                <div class="col-12 col-md-6 country_col">
                                    <div class="form-group">
                                        <label for="country">{{ translate('country') }}</label>
                                        <select class="form-control select2 select_country" name="country_id">
                                            @foreach ($countries as $country)
                                            <option value="{{ $country->id }}"
                                                @if($order->city)
                                                    @if($order->city->country_id == $country->id) selected @endif
                                                @endif
                                                >{{ $country->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @endif
                            <div class="col-12 d-flex align-items-end">
                                <div class="form-group w-100">
                                    <label for="customer_name">{{ translate('search for customer') }}</label>
                                    <select name="customer_id" class="form-control select2">
                                        <option value="">{{ translate('choose') }}</option>
                                        @foreach ($customers as $customer)
                                            <option value="{{ $customer->id }}" @if($order->customer_id == $customer->id) selected @endif>{{ $customer->name . ' - ' . $customer->phone }}</option>
                                        @endforeach
                                    </select>
                                    @error('customer_id')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group ml-2">
                                    <button class="btn btn-primary max" type="button" data-toggle="modal"
                                    data-target="#modal_customers">{{ translate('add new customer') }}</button>
                                </div>
                                <!--  Customer Creation Modal  -->
                                <div class="modal fade" id="modal_customers" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">
                                                        {{ translate('create new customer') }}
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="customer_name">{{ translate('customer name') }}</label>
                                                        <input type="text" class="form-control" name="customer_name" value="{{ old('customer_name') }}">
                                                        @error('customer_name')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="customer_email">{{ translate('customer email') }}</label>
                                                        <input type="email" class="form-control" name="customer_email" value="{{ old('customer_email') }}">
                                                        @error('customer_email')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="customer_phone">{{ translate('customer phone') }}</label>
                                                        <input type="text" class="form-control" name="customer_phone" value="{{ old('customer_phone') }}">
                                                        @error('customer_phone')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="customer_address">{{ translate('customer address') }}</label>
                                                        <input type="text" class="form-control" name="customer_address" value="{{ old('customer_address') }}">
                                                        @error('customer_address')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="customer_type">{{ translate('customer type') }}</label>
                                                        <select name="customer_type" class="form-control select2">
                                                            <option value="regular" @if(old('customer_type') == 'regular') selected @endif>{{ translate('regular') }}</option>
                                                            <option value="special">@if(old('customer_type') == 'special') selected @endif{{ translate('special') }}</option>
                                                        </select>
                                                        @error('customer_type')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="products">{{ translate('products') }}</label>
                                    <select class="form-control select_products select2 select2-multiple"data-placeholder="{{ translate('choose') }}" name="products_search[]" multiple>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}" data-name="{{ $product->name }}" @if(in_array($product->id,$order->order_details->pluck('product_id')->toArray())) selected @endif>
                                                {{ $product->name . ' : ' . $product->sku }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error("products_search")
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="notes">{{ translate('notes') }}</label>
                                    <textarea id="textarea" class="form-control" name="notes" maxlength="225"
                                        rows="3">{{ $order->notes }}</textarea>
                                    @error('notes')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="table-responsive products_table">
                                    <table class="table variant_table">
                                        <thead>
                                            <th>{{ translate('product name') }}</th>
                                            <th>{{ translate('price') }}</th>
                                            <th>{{ translate('qty') }}</th>
                                            <th>{{ translate('discount') }}</th>
                                            <th>{{ translate('files') }}</th>
                                            <th>{{ translate('notes') }}</th>
                                            <th>{{ translate('total price') }}</th>
                                        </thead>
                                        <tbody>
                                            @foreach ($order->order_details->groupBy('product_id') as $key => $orderProductDetails)
                                                @php
                                                    $product = \App\Models\Product::find($key);
                                                @endphp
                                                @if($product)
                                                    <tr id="product_tr_{{ $product->id }}">
                                                        <td>
                                                            <input type="hidden" name="products[{{ $product->id }}][update]" value="true">
                                                            <div class="d-flex align-items-center">
                                                                @if($product->photos)
                                                                    <img src="{{ asset(json_decode($product->photos)[0]) }}" alt="">
                                                                @else
                                                                    <img src="{{ asset('/images/product_avatar.png') }}" alt="">
                                                                @endif
                                                                <span>{{ $product->name }}</span>
                                                            </div>
                                                        </td>
                                                        @php
                                                            $nullableOrderDetail = $orderProductDetails->where('variant_type', null)->first();
                                                        @endphp
                                                        @if($nullableOrderDetail)
                                                            <td>
                                                                <div class="price">{{ $nullableOrderDetail->price }}</div>
                                                            </td>
                                                            <td>
                                                                <input class="form-control amount" value="{{ $nullableOrderDetail->qty }}" min="1" type="number" name="products[{{ $product->id }}][amount]">
                                                            </td>
                                                            <td>
                                                                <input class="form-control product_discount" value="{{ $nullableOrderDetail->discount }}" type="number" name="products[{{ $product->id }}][discount]">
                                                            </td>
                                                            <td>
                                                                <div class="customized_files">
                                                                    <div class="form-group">
                                                                        <input type="file" class="form-control input_files" multiple accept="image/*" hidden name="products[{{ $product->id }}][files][]">
                                                                        <button type="button" class="btn btn-primary form-control" onclick="files('product_tr_{{ $product->id }}', true)">
                                                                            <span class="mdi mdi-plus btn-lg"></span>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                                @if($nullableOrderDetail->files)
                                                                    <ul class="all_files list-unstyled">
                                                                        @foreach (json_decode($nullableOrderDetail->files) as $file)
                                                                            <li>
                                                                                <a target="_blank" href="{{ asset($file) }}">
                                                                                    {{ $loop->index + 1 }}
                                                                                </a>
                                                                                <i class="fas fa-times remove_file" data-product="{{ $product->id }}" data-file="{{ $file }}"></i>
                                                                            </li>
                                                                        @endforeach
                                                                    </ul>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <textarea name="products[{{ $product->id }}][notes]" class="form-control">{{ $nullableOrderDetail->notes}}</textarea>
                                                            </td>
                                                            <td>
                                                                <div class="total_price">
                                                                    @if($order->discount_type == 'percent')
                                                                        {{ $nullableOrderDetail->total_price - (($nullableOrderDetail->total_price * $nullableOrderDetail->discount) / 100) }}
                                                                    @else
                                                                        {{ $nullableOrderDetail->total_price - $nullableOrderDetail->discount }}
                                                                    @endif
                                                                </div>
                                                            </td>
                                                        @endif
                                                        <td>
                                                            @if(count($product->variants->where('type', 'size')) > 0)
                                                                <ul class="select_variant size_select">
                                                                    @foreach ($product->variants()->with('currenctPriceOfVariant')->where('type', 'size')->get() as $variant)
                                                                        <li class="variant @if($order->order_details->where('variant', $variant->variant)->first()) active @endif"
                                                                            data-variant="{{ $variant->type }}" data-variant_value='{{ $variant}}' data-variant_price="{{ $variant->currenctPriceOfVariant }}" data-product_value='{{ $product }}' data-id="size-{{ $variant->id }}">
                                                                            {{ $variant->variant }}
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if(count($product->variants->where('type', 'extra')) > 0)
                                                                <ul class="select_variant extra_select">
                                                                    @foreach ($product->variants()->with('currenctPriceOfVariant')->where('type', 'extra')->get() as $variant)
                                                                        <li class="variant @if($order->order_details->where('variant', $variant->variant)->first()) active @endif" data-variant="{{ $variant->type }}" data-variant_value='{{ $variant }}' data-variant_price="{{ $variant->currenctPriceOfVariant }}" data-product_value='{{ $product }}' data-id="extra-{{ $variant->id }}">
                                                                            {{ $variant->variant }}
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                    @if(count($order->order_details->where('variant_type', '!=', null)->where('variant_type', 'size')) > 0)
                                        <table class="table size-table">
                                            <thead>
                                                <th>{{ translate('product name') }}</th>
                                                <th>{{ translate('sizes') }}</th>
                                                <th>{{ translate('price') }}</th>
                                                <th>{{ translate('quantity') }}</th>
                                                <th>{{ translate('discount') }}</th>
                                                <th>{{ translate('files') }}</th>
                                                <th>{{ translate('notes') }}</th>
                                                <th>{{ translate('total price') }}</th>
                                            </thead>
                                            <tbody>
                                                @foreach ($order->order_details->where('variant_type', '!=', null)->where('variant_type', 'size') as $order_detail)
                                                    @php
                                                        $variant = \App\Models\ProductVariant::where('product_id', $order_detail->product_id)->where('variant', $order_detail->variant)->first();
                                                    @endphp
                                                    @if($variant)
                                                    <tr id="{{ 'size_' . \App\Models\ProductVariant::where('variant', $order_detail->variant)->where('product_id', $order_detail->product_id)->first()->id}}">
                                                        <input type="hidden" name="products[{{ $order_detail->product_id }}][variants][{{ $variant->id }}][update]" value="true">
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    @if($order_detail->product->photos)
                                                                        <img src="{{ asset(json_decode($order_detail->product->photos)[0]) }}" alt="">
                                                                    @else
                                                                        <img src="{{ asset('/images/product_avatar.png') }}" alt="">
                                                                    @endif
                                                                    <span>{{ $order_detail->product->name }}</span>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                {{ $order_detail->variant }}
                                                            </td>
                                                            <td>
                                                                <div class="price">{{ $order_detail->price }}</div>
                                                            </td>
                                                            <td>
                                                                <input class="form-control amount" name="products[{{ $order_detail->product_id }}][variants][{{ $variant->id }}][amount]" type="number" placeholder="{{ translate('quantity') }}" value="{{ $order_detail->qty }}" min="1">
                                                                @error("products.*.$order_detail->variant_type.amount")
                                                                <div class="text-danger">{{ $message }}</div>
                                                                @enderror
                                                            </td>
                                                            <td>
                                                                <input class="form-control product_discount" name="products[{{ $order_detail->product_id }}][variants][{{ $variant->id }}][discount]"  type="number" placeholder="{{ translate('discount') }}" value="{{ $order_detail->discount }}">
                                                                @error("products.*.$order_detail->variant_type.discount")
                                                                    <div class="text-danger">{{ $message }}</div>
                                                                @enderror
                                                            </td>
                                                            <td>
                                                                <div class="customized_files">
                                                                    <div class="form-group">
                                                                        <input type="file" class="form-control input_files" multiple accept="image/*" hidden name="products[{{ $order_detail->product_id }}][variants][{{ $variant->id }}][files][]">
                                                                        <button type="button" class="btn btn-primary form-control" onclick="files('{{ 'size_' . \App\Models\ProductVariant::where('variant', $order_detail->variant)->where('product_id', $order_detail->product_id)->first()->id}}',true)">
                                                                            <span class="mdi mdi-plus btn-lg"></span>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                                @if($order_detail->files)
                                                                    <ul class="all_files list-unstyled">
                                                                        @foreach (json_decode($order_detail->files) as $file)
                                                                            <li>
                                                                                <a target="_blank" href="{{ asset($file) }}">
                                                                                    {{ $loop->index + 1 }}
                                                                                </a>
                                                                                <i class="fas fa-times remove_file" data-variant="{{ $order_detail->id }}" data-file="{{ $file }}"></i>
                                                                            </li>
                                                                        @endforeach
                                                                    </ul>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <textarea name="products[{{ $order_detail->product_id }}][variants][{{ $variant->id }}][notes]" class="form-control">{{ $order_detail->notes}}</textarea>
                                                            </td>
                                                            <td>
                                                                <div class="total_price">
                                                                    @if($order->discount_type == 'percent')
                                                                        {{ $order_detail->total_price - (($order_detail->total_price * $order_detail->discount) / 100) }}
                                                                    @else
                                                                        {{ $order_detail->total_price - $order_detail->discount }}
                                                                    @endif
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @endif
                                    @if(count($order->order_details->where('variant_type', '!=', null)->where('variant_type', 'extra')) > 0)
                                        <table class="table extra-table">
                                            <thead>
                                                <th>{{ translate('product name') }}</th>
                                                <th>{{ translate('extras') }}</th>
                                                <th>{{ translate('price') }}</th>
                                                <th>{{ translate('quantity') }}</th>
                                                <th>{{ translate('discount') }}</th>
                                                <th>{{ translate('files') }}</th>
                                                <th>{{ translate('notes') }}</th>
                                                <th>{{ translate('total price') }}</th>
                                            </thead>
                                            <tbody>
                                                @foreach ($order->order_details->where('variant_type', '!=', null)->where('variant_type', 'extra') as $order_detail)
                                                    @php
                                                        $variant = \App\Models\ProductVariant::where('product_id', $order_detail->product_id)->where('variant', $order_detail->variant)->first();
                                                    @endphp
                                                    @if($variant)
                                                    <tr id="{{ 'extra_' . \App\Models\ProductVariant::where('variant', $order_detail->variant)->where('product_id', $order_detail->product_id)->first()->id }}"
                                                        >
                                                        <input type="hidden" name="products[{{ $order_detail->product_id }}][variants][{{ $variant->id }}][update]" value="true">
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    @if($order_detail->product->photos)
                                                                        <img src="{{ asset(json_decode($order_detail->product->photos)[0]) }}" alt="">
                                                                    @else
                                                                        <img src="{{ asset('/images/product_avatar.png') }}" alt="">
                                                                    @endif
                                                                    <span>{{ $order_detail->product->name }}</span>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                {{ $order_detail->variant }}
                                                            </td>
                                                            <td>
                                                                <div class="price">{{ $order_detail->price }}</div>
                                                            </td>
                                                            <td>
                                                                <input class="form-control amount" name="products[{{ $order_detail->product_id }}][variants][{{ $variant->id }}][amount]" type="number" placeholder="{{ translate('quantity') }}" value="{{ $order_detail->qty }}" min="1">
                                                                @error("products.*.$order_detail->variant_type.amount")
                                                                    <div class="text-danger">{{ $message }}</div>
                                                                @enderror
                                                            </td>
                                                            <td>
                                                                <input class="form-control product_discount" name="products[{{ $order_detail->product_id }}][variants][{{ $variant->id }}][discount]" type="number" placeholder="{{ translate('discount') }}" value="{{ $order_detail->discount }}">
                                                                @error("products.*.$order_detail->variant_type.discount")
                                                                    <div class="text-danger">{{ $message }}</div>
                                                                @enderror
                                                            </td>
                                                            <td>
                                                                <div class="customized_files">
                                                                    <div class="form-group">
                                                                        <input type="file" class="form-control input_files" multiple accept="image/*" hidden name="products[{{ $order_detail->product_id }}][variants][{{ $variant->id }}][files][]">
                                                                        <button type="button" class="btn btn-primary form-control" onclick="files('{{ 'extra_' . \App\Models\ProductVariant::where('variant', $order_detail->variant)->where('product_id', $order_detail->product_id)->first()->id }}', true)">
                                                                            <span class="mdi mdi-plus btn-lg"></span>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                                @if($order_detail->files)
                                                                    <ul class="all_files list-unstyled">
                                                                        @foreach (json_decode($order_detail->files) as $file)
                                                                            <li>
                                                                                <a target="_blank" href="{{ asset($file) }}">
                                                                                    {{ $loop->index + 1 }}
                                                                                </a>
                                                                                <i class="fas fa-times remove_file" data-variant="{{ $order_detail->id }}" data-file="{{ $file }}"></i>
                                                                            </li>
                                                                        @endforeach
                                                                    </ul>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <textarea name="products[{{ $order_detail->product_id }}][variants][{{ $variant->id }}][notes]" class="form-control">{{ $order_detail->notes}}</textarea>
                                                            </td>
                                                            <td>
                                                                <div class="total_price">
                                                                    @if($order->discount_type == 'percent')
                                                                        {{ $order_detail->total_price - (($order_detail->total_price * $order_detail->discount) / 100) }}
                                                                    @else
                                                                        {{ $order_detail->total_price - $order_detail->discount }}
                                                                    @endif
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @endif
                                </div>
                            </div>
                            <div class="w-100 d-block d-md-flex flex-row-reverse cart-of-total-container">
                                <div class="cart-of-total">
                                    <h5>{{ translate('summary') }}</h5>
                                    <div class="responsive-table">
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <td>{{ translate('total price') }}</td>
                                                    <td class="d-flex">
                                                        <div class="total_prices">{{ ($order->grand_total - $order->shipping) + $order->total_discount }}</div>
                                                    </td>
                                                </tr>
                                                @if($order->shipping)
                                                    <tr class="shipping_tr">
                                                        <td>{{ translate('shipping') }}</td>
                                                        <td class="d-flex">
                                                            <div class="shipping">{{ $order->shipping }}</div>
                                                        </td>
                                                    </tr>
                                                @endif
                                                <tr>
                                                    <td>{{ translate('discount') }}</td>
                                                    <td><input class="form-control total_discount" name="total_discount" type="number" placeholder="{{ translate('discount') }}" min="0" value="{{ $order->total_discount }}"></td>
                                                </tr>
                                                <tr>
                                                    <td>{{ translate('price after discount') }}</td>
                                                    <td class="d-flex">
                                                        <div class="grand_total">
                                                            @if($order->discount_type == 'percent')
                                                                {{ $order->grand_total - (($order->grand_total * $order->total_discount) / 100) }}
                                                            @else
                                                                {{ $order->grand_total - $order->total_discount }}
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for=""></label>
                                    <input type="submit" value="{{ translate('edit') }}" class="btn btn-success">
                                    <a href="{{ route('orders.index') }}" class="btn btn-info">{{ translate('back to orders') }}</a>
                                </div>
                            </div>
                        </div>
                    </form>

                    <form class="remove_files_form d-none" action="{{ route('orders.remove_files', $order) }}" method="POST">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footerScript')
@include('orders.orders_scripts')
    <script>

    function add_references(type, value) {

        $("#orders_create").children().each((index, child) => {
            if($(child).hasClass(type)) {
                $(child).remove();
            }
        })

        $("#orders_create").append(`
            <input type="hidden" class="${type}" name="${type}" value="${value}">
        `);

        $("#orders_create").submit();
    }
        $(".remove_file").on('click', function() {
            let file = $(this).data('file'),
             variant = $(this).data('variant'),
             product = $(this).data('product');

            $(".remove_files_form").append(`
                <input type="hidden" name="file" value="${file}">
            `);
            $(".remove_files_form").append(`
                <input type="hidden" name="variant" value="${variant}">
            `);
            $(".remove_files_form").append(`
                <input type="hidden" name="product" value="${product}">
            `);
            $(".remove_files_form").submit();
        });



        $(".branch_select").on('change', function() {
            $(".products_table").empty();
            $(".select_products").empty();
            $(".cart-of-total-container").addClass('d-none');
            $('.cart-of-total-container').removeClass('d-block d-md-flex flex-row-reverse');
            getFullPrice();
            getProductsByBranchId($(".branch_select").val(), 'inhouse');
        });


        function getProductsByBranchId(branch_id, type) {
            let token = $("meta[name=_token]").attr('content');
            $.ajax({
                'method': 'POST',
                'data': {
                    '_token': token,
                    'branch_id': branch_id,
                    'type': type
                },
                'url': "{{ route('products.all') }}",
                'success': function(res) {
                    if(res.status) {
                        $(".select_products").select2().html('');
                        res.data.forEach((obj) => {
                            $(".select_products").append(`
                            <option value="${obj.id}">
                                ${obj.name + ' : ' + obj.sku}
                            </option>
                            `);
                        })

                    } else {
                        toastr.error(res.message);
                    }
                },
                'erorr' : function(err) {
                    console.log(err);
                }
            });
        }

        $(".branch_select").on('change', function() {
            getProductsByBranchId($(this).val(), 'inhouse');
        })


        $(".select_city").on('change', function() {
            $(".shipping_tr .shipping").text($(".select_city option:selected").data('shipping'));
            getFullPrice();
        })
        // Get Cities By Country id
        function getCitiesByCountryIdAjax(country_id) {
            let token = $("meta[name=_token]").attr('content');
            $.ajax({
                'method': 'POST',
                'data': {
                    '_token': token,
                    country_id: country_id
                },
                'url' : `{{ route('countries.cities.all') }}`,
                'success': function(res) {
                    if(res.status) {
                        $(".select_city").select2().html('');
                        res.data.forEach((obj) => {
                            $(".select_city").append(`<option value="${obj.id}" data-shipping="${obj.price}">${obj.name}</option>`);
                        });
                        $(".select_city").val("{{ $order->city_id }}")
                        $('.shipping_tr').removeClass('d-none');
                        $(".shipping_tr .shipping").text($(".select_city option:selected").data('shipping'))
                        $(".select_city").on('change', function() {
                            $(".shipping_tr .shipping").text($(".select_city option:selected").data('shipping'))
                            getFullPrice();
                        })

                    }
                },
                'erorr' : function(err) {
                    console.log(err);
                }
            });
        }
        // Get Cities By Country id
        function getCitiesByCountryId() {
            let country_id = $('.select_country option:selected').val();
            if(country_id) {
                $('.select_country').parent().parent().after(city_col);
                getCitiesByCountryIdAjax(country_id);
            }
            $(".select_country").on('change', function() {
                country_id = $(this).val();
                getCitiesByCountryIdAjax(country_id);
            });
        }

        @if(request('type') == 'online' || $order->type="online")
            getCitiesByCountryId();
        @endif

        getVariants();
        amountChange();

        function getVariants() {
            $(".variant").click('click', function() {
                let product = $(this).data('product_value');
                $(this).toggleClass("active");
                let variant = $(this).data('variant'),
                variant_id = $(this).data('variant_value').id;
                if($(".products_table").find(`.${variant}-table`).length == 0) {
                    $(".products_table").append(getProductVariantTable(variant))
                }
                if($(this).hasClass("active")) {
                    $(`.products_table .${variant}-table tbody`).append(getTrOfProductVariantTable(product,variant,$(this).data('variant_value')));
                } else {
                    $(`.products_table .${variant}-table tbody`).find(`#${variant + '_' + variant_id}`).remove();
                }
                if($(".products_table").find(`.${variant}-table tbody`).children().length == 0) {
                    $(`.products_table .${variant}-table`).remove();
                }
                getFullPrice();
                amountChange();
                product_price();
                files(variant + '_' + variant_id);
            })
        }

    function choice_on_click() {
        $(".select2-selection__choice__remove").on('click', function() {
            let optionClicked = $(`option:contains(${$(this).parent().attr('title')})`);
            array = array.filter((val) => {
                if(val !== optionClicked.val()) {
                    return val;
                }
            })
            $(`#product_tr_${optionClicked.val()}`).remove();
            if($(".variant_table tbody").children().length < 1) {
                $(".variant_table").remove();
                $(`.size-table tbody #size_${optionClicked.val()}`).remove();
                $(`.extra-table tbody #extra_${optionClicked.val()}`).remove();
                $(".extra-table").remove();
            }
            if($(".extra-table tbody").children().length < 1) {
                $(".extra-table").remove();
            }
            if($(".size-table tbody").children().length < 1) {
                $(".size-table").remove();
            }
            getFullPrice();
        })
    }
    choice_on_click();

    let array = [];
    $(".select_products option:selected").each((index, child) => {
        array.push($(child).val());
    })


    $(".select_products").on('change', function() {
        let arrayOfValues = $(this).val();

        if(array.length > 0) {
            filteredValues = arrayOfValues.filter((val) => {
                if(!array.includes(val)) {
                    return val;
                }
            })
            if(filteredValues.length !== 0) {
                $('.cart-of-total-container').removeClass('d-none');
                $('.cart-of-total-container').addClass('d-block d-md-flex flex-row-reverse ');
                getProductsWithAjax(filteredValues);
            }
        } else {
            if(arrayOfValues.length !== 0) {
                $('.cart-of-total-container').removeClass('d-none');
                 $('.cart-of-total-container').addClass('d-block d-md-flex flex-row-reverse ');
                getProductsWithAjax(arrayOfValues);
            }
        }

        if($(".select_products").val().length !== 0) {
            $('.cart-of-total-container').removeClass('d-none');
            $('.cart-of-total-container').addClass('d-block d-md-flex flex-row-reverse');
        } else {
            $('.cart-of-total-container').addClass('d-none');
            $('.cart-of-total-container').removeClass('d-block d-md-flex flex-row-reverse');
        }
        getFullPrice();

        choice_on_click();
    });


    product_price();

    </script>
@endsection
