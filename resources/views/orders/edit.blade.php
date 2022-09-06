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
                        @if(Auth::user()->role_type == 'inhouse')
                            <input type="hidden" name="type" value="inhouse">
                            <input type="hidden" name="branch_id" value="{{ Auth::user()->branch_id }}">
                        @elseif(Auth::user()->role_type == 'online')
                            <input type="hidden" name="type" value="online">
                        @endif
                        @if(request('discount_type') == 'percent')
                            <input type="hidden" name="discount_type" value="percent">
                        @elseif(request('discount_type') == 'amount')
                            <input type="hidden" name="discount_type" value="amount">
                        @endif

                        @if(Auth::user()->type == 'admin' || Auth::user()->type == 'sub-admin')
                            @if(request('type') =='online')
                                <input type="hidden" name="type" value="online">
                            @elseif(request('type') =='inhouse')
                                <input type="hidden" name="type" value="inhouse">
                            @endif
                        @endif
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="type">{{ translate('discount type') }}</label>
                                    <select class="form-control discount_type select2" name="discount_type">
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
                            @if(Auth::user()->type == 'admin' || Auth::user()->type == 'sub-admin')
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="type">{{ translate('order type') }}</label>
                                        <select class="form-control order_type select2" name="type">
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
                            @endif
                            <div class="col-12 @if(Auth::user()->role_type == 'inhouse' || Auth::user()->role_type == 'online') col-md-6 @endif">
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
                            @if(Auth::user()->type == 'admin' || Auth::user()->type == 'sub-admin')
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
                            @endif
                            @if(Auth::user()->type == 'admin' || Auth::user()->type == 'sub-admin' || Auth::user()->role_type == 'online')
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
                                    <label for="notes">{{ translate('notes') }}</label>
                                    <textarea id="textarea" class="form-control" name="notes" maxlength="225"
                                        rows="3">{{ $order->notes }}</textarea>
                                    @error('notes')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <table class="table d-block overflow-auto products_table">
                                    <thead>
                                        <th>
                                            <button type="button" class="btn btn-success add_row">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </th>
                                        <th>{{ translate('product name') }}</th>
                                        <th>{{ translate('sizes') }}</th>
                                        <th>{{ translate('extras') }}</th>
                                        <th>{{ translate('price') }}</th>
                                        <th>{{ translate('qty') }}</th>
                                        <th>{{ translate('discount') }}</th>
                                        @can('orders.files')
                                            <th>{{ translate('files') }}</th>
                                        @endcan
                                        <th>{{ translate('notes') }}</th>
                                        <th>{{ translate('total price') }}</th>
                                    </thead>
                                    <tbody>
                                        @if($order->order_details->count() > 0)
                                            @foreach ($order->order_details as $order_detail)
                                                @php
                                                    $index = $loop->index;
                                                    $variants = App\Models\ProductVariant::where(['product_id' => $order_detail['product_id']])->get();
                                                @endphp
                                                <tr id="{{ $index }}">
                                                    @php
                                                        if(old('type') == 'inhouse') {
                                                            $categories_ids = App\Models\Category::whereHas('branches', function($query) {
                                                               return $query->where('branch_id', old('branch_id'));
                                                           })->latest()->pluck('id');
                                                           $products = App\Models\Product::whereHas('categories', function($query) use($categories_ids) {
                                                               return $query->whereIn('category_id', $categories_ids);
                                                           })->latest()->get();
                                                        }
                                                    @endphp
                                                    <input type="hidden" class="form-control" name="products[{{ $index }}][update]" value="true">
                                                    <input type="hidden" class="form-control" name="products[{{ $index }}][old_id]" value="{{ $order_detail->product_id }}">

                                                    @if(isset($order_detail['price']))
                                                        <input type="hidden" class="form-control input_price" name="products[{{ $index }}][price]" value="{{ $order_detail['price'] }}">
                                                    @endif
                                                    <td>
                                                        <button type="button" class="btn btn-danger delete_row" data-id="{{ $order_detail->id }}">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </td>
                                                    <td>
                                                        <select class="select2 products_search" name="products[{{ $index }}][id]">
                                                            <option value="">{{ translate('choose') }}</option>
                                                            @foreach ($products as $product)
                                                                <option value="{{ $product->id }}" @if($order_detail['product_id'] == $product->id) selected @endif>{{ $product->sku . ' : ' . $product->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error("products.$index.id")
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </td>
                                                    <td class="sizes_td">
                                                        @if($variants->count() > 0)
                                                            <select class="select2 products_search" name="products[{{ $index }}][variant_id]">
                                                                <option value="">{{ translate('choose') }}</option>
                                                                @foreach ($variants as $product_variant)
                                                                    @php
                                                                        $variant_prod = App\Models\ProductVariant::where(['product_id' => $order_detail['product_id'],
                                                                         'variant' => $order_detail['variant']])->first();
                                                                    @endphp
                                                                    <option value="{{ $product_variant->id }}"
                                                                        @if($variant_prod->id == $product_variant->id) selected @endif>{{ $product_variant->variant }}</option>
                                                                @endforeach
                                                            </select>
                                                            @error("products.$index.variant_id")
                                                                <div class="text-danger">{{ $message }}</div>
                                                            @enderror
                                                        @else
                                                            --
                                                        @endif
                                                    </td>
                                                    <td class="extras_td">
                                                        --
                                                    </td>
                                                    <td>
                                                        <div class="price">
                                                            @if(isset($order_detail['price']))
                                                                {{ $order_detail['price'] }}
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <input type="number" class="form-control amount" name="products[{{ $index }}][amount]" value="{{ $order_detail['qty'] }}">
                                                        @error("products.$index.amount")
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </td>
                                                    <td>
                                                        <input type="number" class="form-control product_discount" name="products[{{ $index }}][discount]" value="{{ $order_detail['discount'] }}">
                                                        @error("products.$index.discount")
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </td>
                                                    @can('orders.files')
                                                        <td>
                                                            <div class="customized_files">
                                                                <div class="form-group">
                                                                    <input type="file" class="form-control input_files" multiple accept="image/*" hidden name="products[{{ $index }}][files][]">
                                                                    <button type="button" class="btn btn-primary form-control files" onclick="files('{{ $index }}', true)">
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
                                                    @endcan
                                                    <td><textarea class="form-control" name="products[{{ $index }}][notes]">{{ $order_detail['notes'] }}</textarea></td>
                                                    <td>
                                                        <div class="total_price">
                                                            @if(old('discount_type') == 'percent')
                                                                @if($order_detail['discount'] !== null)
                                                                    {{ ($order_detail['price'] * $order_detail['qty']) * ($order_detail['discount'] / 100) }}
                                                                @else
                                                                    {{ ($order_detail['price'] * $order_detail['qty']) }}
                                                                @endif
                                                            @else
                                                                @if($order_detail['discount'] !== null)
                                                                    {{ ($order_detail['price'] * $order_detail['qty']) - $order_detail['discount'] }}
                                                                @else
                                                                    {{ ($order_detail['price'] * $order_detail['qty']) }}
                                                                @endif
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                        @if(old('products'))
                                            @foreach (old('products') as $product_old)
                                                @if(!isset($product_old['update']))
                                                    @php
                                                        $index = $loop->index;
                                                        $variants = App\Models\ProductVariant::where('product_id', $product_old['id'])->get();
                                                    @endphp
                                                    <tr id="{{ $index }}">
                                                        @php
                                                            if(old('type') == 'inhouse') {
                                                                $categories_ids = App\Models\Category::whereHas('branches', function($query) {
                                                                return $query->where('branch_id', old('branch_id'));
                                                            })->latest()->pluck('id');
                                                            $products = App\Models\Product::whereHas('categories', function($query) use($categories_ids) {
                                                                return $query->whereIn('category_id', $categories_ids);
                                                            })->latest()->get();
                                                            }
                                                        @endphp
                                                        @if(isset($product_old['price']))
                                                            <input type="hidden" class="form-control input_price" name="products[{{ $index }}][price]" value="{{ $product_old['price'] }}">
                                                        @endif
                                                        <td>
                                                            <button type="button" class="btn btn-danger remove_row">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </td>
                                                        <td>
                                                            <select class="select2 products_search" name="products[{{ $index }}][id]">
                                                                <option value="">{{ translate('choose') }}</option>
                                                                @foreach ($products as $product)
                                                                    <option value="{{ $product->id }}" @if($product_old['id'] == $product->id) selected @endif>{{ $product->sku . ' : ' . $product->name }}</option>
                                                                @endforeach
                                                            </select>
                                                            @error("products.$index.id")
                                                                <div class="text-danger">{{ $message }}</div>
                                                            @enderror
                                                        </td>
                                                        <td class="sizes_td">

                                                            @if($variants->count() > 0)
                                                                <select class="select2 products_search" name="products[{{ $index }}][variant_id]" data-product_id="{{ $product_old['id'] }}">
                                                                    <option value="">{{ translate('choose') }}</option>
                                                                    @foreach ($variants as $product_variant)
                                                                        <option value="{{ $product_variant->id }}"
                                                                            @if($product_old['variant_id'] == $product_variant->id) selected @endif data-variant="{{ $product_variant }}">{{ $product_variant->variant }}</option>
                                                                    @endforeach
                                                                </select>
                                                                @error("products.$index.variant_id")
                                                                    <div class="text-danger">{{ $message }}</div>
                                                                @enderror
                                                            @else
                                                                --
                                                            @endif
                                                        </td>
                                                        <td class="extras_td">
                                                            --
                                                        </td>
                                                        <td>
                                                            <div class="price">
                                                                @if(isset($product_old['price']))
                                                                    {{ $product_old['price'] }}
                                                                @endif
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <input type="number" class="form-control amount" name="products[{{ $index }}][amount]" value="{{ $product_old['amount'] }}">
                                                            @error("products.$index.amount")
                                                                <div class="text-danger">{{ $message }}</div>
                                                            @enderror
                                                        </td>
                                                        <td>
                                                            <input type="number" class="form-control product_discount" name="products[{{ $index }}][discount]" value="{{ $product_old['discount'] }}">
                                                            @error("products.$index.discount")
                                                                <div class="text-danger">{{ $message }}</div>
                                                            @enderror
                                                        </td>
                                                        @can('orders.files')
                                                            <td>
                                                                <div class="customized_files">
                                                                    <div class="form-group">
                                                                        <input type="file" class="form-control input_files" multiple accept="image/*" hidden name="products[{{ $index }}][files][]">
                                                                        <button type="button" class="btn btn-primary form-control files">
                                                                            <span class="mdi mdi-plus btn-lg"></span>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        @endcan
                                                        <td><textarea class="form-control" name="products[{{ $index }}][notes]">{{ $product_old['notes'] }}</textarea></td>
                                                        <td>
                                                            <div class="total_price">
                                                                @if(isset($product_old['price']))
                                                                    @if(old('discount_type') == 'percent')
                                                                        {{ ($product_old['price'] * $product_old['amount']) * ($product_old['discount'] / 100) }}
                                                                    @else
                                                                        {{ ($product_old['price'] * $product_old['amount']) - $product_old['discount'] }}
                                                                    @endif
                                                                @endif
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
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
                                                        <div class="total_prices"></div>
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

                    <div class="modal fade" id="modal" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">
                                            {{ translate('remove item') }}
                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        {{ translate('are you sure to remove it') .' ?' }}
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ translate('no') }}</button>
                                        <form action="" method="POST">
                                            <div class="form-info">

                                            </div>
                                            @csrf
                                            <button type="submit" class="btn btn-danger">{{ translate('yes') }}</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <form class="remove_files_form d-none" action="{{ route('orders.remove_files', $order) }}" method="POST">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footerScript')
    <script>
                    let address_col = `
                <div class="col-12 col-md-6 address_col">
                    <div class="form-group">
                        <label for="customer_address">{{ translate('customer address') }}</label>
                        <input type="text" class="form-control" name="customer_address" value="{{ old('customer_address') }}">
                        @error('customer_address')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                `,
                country_col = `
                <div class="col-12 col-md-6 country_col">
                    <div class="form-group">
                        <label for="country">{{ translate('country') }}</label>
                        <select class="form-control select_country" name="country_id"></select>
                    </div>
                </div>
                `,
                city_col = `
                <div class="col-12 col-md-6 city_col">
                    <div class="form-group">
                        <label for="city_id">{{ translate('city') }}</label>
                        <select class="form-control select_city" name="city_id"></select>
                        @error('city_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            `;

    @error('customer_name')
        $("#modal_customers").modal();
    @enderror
    @error('customer_phone')
        $("#modal_customers").modal();
    @enderror
    @error('customer_address')
        $("#modal_customers").modal();
    @enderror


    $(".delete_row").on('click', function() {
        let id = $(this).data('id');

        $("#modal form .form-info").empty();
        $("#modal form .form-info").append(`<input type="hidden" name="id" value="${id}">`);
        $("#modal form").attr('action', "{{ route('orders.order_details.destroy') }}")
        console.log($("#modal form"))
        $("#modal").modal();
    });
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

    function files(index, editable=null) {
        if(index) {
            console.log(index)
            if(editable) {
                let tr = $(`tr#${index}`);
                tr.find('.input_files').click();
                tr.find('.input_files').on("change", function(e) {
                    let files = this.files;
                    files.forEach(file => {
                        tr.find(`.customized_files button`).text(files.length);
                    });
                });
            } else {
                $(".files").on('click', function() {
                    let tr = $(this).parent().parent().parent().parent();
                    tr.find('.input_files').click();
                    tr.find('.input_files').on("change", function(e) {
                        let files = this.files;
                        files.forEach(file => {
                            tr.find(`.customized_files button`).text(files.length);
                        });
                    });
                });
            }
        }
    }



        let products = [];
        @if(old('products'))
            let index = {{ count(old('products')) + count($order->order_details) }};
        @else
            let index = {{ count($order->order_details) - 1 }};
        @endif
        function trOfTable(index) {
            return `
                <tr id="${index}">
                    <td>
                        <button type="button" class="btn btn-danger remove_row">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                    <td>
                        <select class="select2 products_search" name="products[${index}][id]">
                            <option value="">{{ translate('choose') }}</option>
                        </select>
                    </td>
                    <td class="sizes_td">--</td>
                    <td class="extras_td">--</td>
                    <td>
                        <div class="price"></div>
                    </td>
                    <td>
                        <input type="number" class="form-control amount" name="products[${index}][amount]" value="1">
                    </td>
                    <td>
                        <input type="number" class="form-control product_discount" name="products[${index}][discount]">
                    </td>
                    @can('orders.files')
                        <td>
                            <div class="customized_files">
                                <div class="form-group">
                                    <input type="file" class="form-control input_files" multiple accept="image/*" hidden name="products[${index}][files][]">
                                    <button type="button" class="btn btn-primary form-control files">
                                        <span class="mdi mdi-plus btn-lg"></span>
                                    </button>
                                </div>
                            </div>
                        </td>
                    @endcan
                    <td><textarea class="form-control" name="products[${index}][notes]"></textarea></td>
                    <td>
                        <div class="total_price"></div>
                    </td>
                </tr>
            `;
        }


        $(".add_row").on('click', function() {
            index++;
            $(".products_table tbody").append(trOfTable(index));
            products.forEach(product => {
                $(".products_search").append(`
                    <option value="${product.id}">${product.sku + ' : ' + product.name}</option>
                `);
            });
            $(".select2").select2();
            $(".cart-of-total-container").removeClass('d-none');
            product_search();
            remove_row();
            files(index);
        });

        function product_search() {
            $(".products_search").on('change', function() {
                let product_id = $(this).val(),
                    tr = $(this).parent().parent(),
                    product_old_id = $(this).data('product_id'),
                    index = tr.attr('id');
                if(product_old_id) {
                    product = products.find(obj => obj.id == product_old_id);
                } else {
                    product = products.find(obj => obj.id == product_id);
                }
                if(product) {
                    if(product.price_of_currency) {
                        $(`.products_table tbody tr#${index} input.price_input`).remove();

                        $(`.products_table tbody tr#${index}`).append(`
                            <input class="price_input" type="hidden" name="products[${index}][price]" value="${product.price_of_currency.price_after_discount}">
                        `);
                        $(`.products_table tbody tr#${index} .price`).text(product.price_of_currency.price_after_discount);
                        $(`.products_table tbody tr#${index} .total_price`).text(product.price_of_currency.price_after_discount * 1);
                    } else {
                        $(`.products_table tbody tr#${index} input.price_input`).remove();
                        $(`.products_table tbody tr#${index}`).append(`
                            <input class="price_input" type="hidden" name="products[${index}][price]" value="0">
                        `);
                        $(`.products_table tbody tr#${index} .price`).text(0);
                        $(`.products_table tbody tr#${index} .total_price`).text(0);
                    }
                    if(product.variants) {
                        let sizes = [],
                            extras = [];
                        product.variants.forEach((variant) => {
                            if(variant.type == 'size') {
                                sizes.push(variant);
                            }
                            if(variant.type == 'extra') {
                                extras.push(variant);
                            }
                        });
                        if(sizes.length !== 0) {
                            $(`.products_table tbody tr#${index} .sizes_td`).empty();
                            $(`.products_table tbody tr#${index} .sizes_td`).append(`
                                <select class="select2 variant_search" name="products[${index}][variant_id]">
                                    <option value="">{{ translate('choose') }}</option>
                                </select>
                            `);
                            $(`.products_table tbody tr#${index} .sizes_td .variant_search`).select2();
                            sizes.forEach((size) => {
                                $(`.products_table tbody tr#${index} .sizes_td .variant_search`).append(`
                                    <option value="${size.id}" data-variant='${JSON.stringify(size)}'

                                    >${size.variant}</option>
                                `);
                            });
                        } else if(sizes.length == 0) {
                            $(`.products_table tbody tr#${index} .sizes_td`).empty();
                            $(`.products_table tbody tr#${index} .sizes_td`).append('--');
                        }
                        if(extras.length !== 0) {
                            $(`.products_table tbody tr#${index} .extras_td`).empty();
                            $(`.products_table tbody tr#${index} .extras_td`).append(`
                                <select class="select2 variant_search" name="products[${index}][variant_id]">
                                    <option value="">{{ translate('choose') }}</option>
                                </select>
                            `);
                            $(`.products_table tbody tr#${index} .extras_td .variant_search`).select2();

                            extras.forEach((extra) => {
                                $(`.products_table tbody tr#${index} .extras_td .variant_search`).append(`
                                    <option value="${extra.id}" data-variant='${JSON.stringify(extra)}'

                                    >${extra.variant}</option>
                                `);
                            });
                        } else if(extras.length == 0) {
                            $(`.products_table tbody tr#${index} .extras_td`).empty();
                            $(`.products_table tbody tr#${index} .extras_td`).append('--');
                        }
                        variant_search(product_id);
                    }
                } else {
                    $(`.products_table tbody tr#${index} input.price_input`).remove();
                    $(`.products_table tbody tr#${index}`).append(`
                        <input class="price_input" type="hidden" name="products[${index}][price]" value="0">
                    `);
                    $(`.products_table tbody tr#${index} .price`).text(0);
                    $(`.products_table tbody tr#${index} .total_price`).text(0);
                }
                amountChange();
                product_price();
                getFullPrice();
            })
        }
        product_search();

        function remove_row() {
            $(".remove_row").on('click', function() {
                $(this).parent().parent().remove();
                getFullPrice();
            });
        }
        remove_row();

        function variant_search(product_id) {
            $(".variant_search").on('change', function() {
                if(product_id) {
                    let product = products.find(obj => obj.id == product_id);
                } else {
                    let product = products.find(obj => obj.id == $(this).attr('product_id'));
                }
                let tr = $(this).parent().parent();
                let index = tr.attr('id');
                variant_id = $(this).val();
                if(variant_id) {
                    let variant = $(this).find(`option[value=${variant_id}]`).data('variant');
                    $.ajax({
                        'method': 'GET',
                        'data': {
                            variant_id: variant_id,
                        },
                        'url' : `{{ route('products.variant_price') }}`,
                        'success': function(res) {
                            let price = res.price_after_discount;
                            tr.find('input.price_input').remove();
                            tr.append(`
                                <input class="price_input" type="hidden" name="products[${index}][price]" value="${price}">
                            `);
                            tr.find(`.price`).text(price);
                            tr.find(`.total_price`).text(price * 1);
                            amountChange();
                            product_price();
                            getFullPrice();
                        },
                        'erorr' : function(err) {
                            console.log(err);
                        }
                    });
                } else {
                    $(`.products_table tbody tr#${index} input.price_input`).remove();
                    if(product.price_of_currency) {
                        $(`.products_table tbody tr#${index}`).append(`
                            <input class="price_input" type="hidden" name="products[${index}][price]" value="${product.price_of_currency.price_after_discount}">
                        `);
                        $(`.products_table tbody tr#${index} .price`).text(product.price_of_currency.price_after_discount);
                        $(`.products_table tbody tr#${index} .total_price`).text(product.price_of_currency.price_after_discount * 1);
                    } else {
                        $(`.products_table tbody tr#${index}`).append(`
                            <input class="price_input" type="hidden" name="products[${index}][price]" value="0">
                        `);
                        $(`.products_table tbody tr#${index} .price`).text(0);
                        $(`.products_table tbody tr#${index} .total_price`).text(0);
                    }
                }
                amountChange();
                product_price();
                getFullPrice();
            })
        }
        variant_search(null);



        $(".order_type").on('change', function() {
            location.href = '{{ route('orders.edit', $order) }}' + '?type=' + $(this).val();
        });



        $(".branch_select").on('change', function() {
            getProductsByBranchId($(this).val(), 'inhouse');
        });

        @if(Auth::user()->role_type == 'inhouse')
            getProductsByBranchId("{{ Auth::user()->branch_id }}", 'inhouse')
        @elseif(Auth::user()->role_type == 'online')
            getProductsByBranchId(null, null)
        @else
            getProductsByBranchId(null, null)
        @endif




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
                        products = res.data;
                    } else {
                        toastr.error(res.message);
                    }
                },
                'erorr' : function(err) {
                    console.log(err);
                }
            });
        }
        if($(".branch_select").val()) {
            getProductsByBranchId($(".branch_select").val(), 'inhouse');
        }



        function getCitiesByCountryIdAjax(country_id) {
            let token = $("meta[name=_token]").attr('content');
            $.ajax({
                'method': 'POST',
                'data': {
                    '_token': token,
                    country_id: country_id,
                },
                'url' : `{{ route('countries.cities.all') }}`,
                'success': function(res) {
                    if(res.status) {
                        $(".select_city").select2().html('');
                        res.data.forEach((obj) => {
                            $(".select_city").append(`<option value="${obj.id}" data-shipping="${obj.price}">${obj.name}</option>`);
                        });
                        $('.shipping_tr').removeClass('d-none');
                        $(".shipping_tr .shipping").text($(".select_city option:selected").data('shipping'))
                        $(".select_city").on('change', function() {
                            $(".shipping_tr .shipping").text($(".select_city option:selected").data('shipping'))
                            getFullPrice();
                        })
                        getFullPrice();
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
        getCitiesByCountryId();

        function getFullPrice() {
            let prices = [],
                total_prices = $(".total_prices"),
                grandTotal = $(".grand_total"),
                shippping = parseFloat($(".shipping").text()),
                total_discount = $('.total_discount');
            if(isNaN(shippping)) {
                shippping = 0;
            }
            if($(".products_table tbody").children().length !== 0) {
                $(".products_table tbody").children().each((index, tr) => {
                    if(!isNaN(parseFloat($(tr).find('.total_price').text()))) {
                        prices.push(parseFloat($(tr).find('.total_price').text()));
                    }
                });
            }

            if(prices.length !== 0) {
                prices = prices.reduce((acc, current) => acc + current);
            }
            total_prices.text(prices);
            if(total_discount.val() !== '') {
                let full_price = (prices +  shippping);
                let grand_total = full_price - total_discount.val();
                @if(request('discount_type') == 'percent')
                    grand_total = full_price - ((full_price * $(total_discount).val()) / 100);
                @endif
                if($(".discount_type").val() == 'percent') {
                    grand_total = full_price - ((full_price * $(total_discount).val()) / 100);
                }
                grandTotal.text(grand_total);
            } else {
                grandTotal.text(prices + shippping);
            }
            total_discount.on('keyup', function() {
                let full_price = (prices +  shippping);
                let grand_total = full_price - $(this).val();

                @if(request('discount_type') == 'percent')
                    grand_total = full_price - ((full_price * $(this).val()) / 100);
                @endif
                if($(".discount_type").val() == 'percent') {
                    grand_total = full_price - ((full_price * $(this).val()) / 100);
                }
                grandTotal.text(grand_total);
            });
        }
        function amountChange() {
            $(".amount").on('keyup, change', function() {
                let priceVal = parseFloat($(this).parent().parent().find('.price').text()),
                amountVal = parseFloat($(this).val());
                $(this).parent().parent().find('.total_price').text(priceVal * amountVal);
                getFullPrice();
            });
        }
        amountChange();
        function product_price() {
            $(".product_discount").on('keyup, change', function() {
                let priceVal = parseFloat($(this).parent().parent().find('.price').text()),
                    amount = parseFloat($(this).parent().parent().find('.amount').val()),
                    discountVal = parseFloat($(this).val()),
                    full_price = priceVal * amount;
                let price_after_discount = full_price - discountVal;
                @if(request('discount_type') == 'percent')
                    price_after_discount = full_price - ((full_price * discountVal) / 100);
                @endif
                if($(".discount_type").val() == 'percent') {
                    price_after_discount = full_price - ((full_price * discountVal) / 100);
                }
                $(this).parent().parent().find('.total_price').text(price_after_discount);
                if(isNaN(price_after_discount)) {
                    $(this).parent().parent().find('.total_price').text(full_price);
                }
                getFullPrice();
            });
        }
        product_price();


        getFullPrice();


    </script>
@endsection
