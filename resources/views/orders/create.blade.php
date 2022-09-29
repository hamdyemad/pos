@extends('layouts.master')

@section('title')
{{ translate('create new order') }}
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('title') {{ translate('orders') }} @endslot
        @slot('li1') {{ translate('dashboard') }} @endslot
        @slot('li2') {{ translate('orders') }} @endslot
        @slot('route1') {{ route('dashboard') }} @endslot
        @slot('route2') {{ route('orders.index') }} @endslot
        @slot('li3') {{ translate('create new order') }} @endslot
    @endcomponent
    <div class="create_order">
        <div class="container">
            <div class="card">
                <div class="card-header">
                    {{ translate('create new order') }}
                </div>
                <div class="card-body">
                    <form action="{{ route('orders.create') }}" method="GET" id="orders_create">
                    </form>
                    <form class="order_store" action="{{ route('orders.store') }}" method="POST" enctype="multipart/form-data">
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
                        @else
                            <input type="hidden" name="discount_type" value="amount">
                        @endif

                        @if(Auth::user()->type == 'admin' || Auth::user()->type == 'sub-admin')
                            @if(request('type') =='online')
                                <input type="hidden" name="type" value="online">
                            @elseif(request('type') =='inhouse')
                                <input type="hidden" name="type" value="inhouse">
                            @else
                                <input type="hidden" name="type" value="inhouse">
                            @endif
                        @endif


                        @csrf
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="type">{{ translate('discount type') }}</label>
                                    <select onchange="this.form.submit()" form="orders_create" class="form-control discount_type select2" name="discount_type">
                                        <option value="amount" @if(request('discount_type') == 'amount') selected @endif>{{ translate('amount') }}</option>
                                        <option value="percent" @if(request('discount_type') == 'percent') selected @endif>{{ translate('percent') }}</option>
                                    </select>
                                    @error('type')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            @if(Auth::user()->type == 'admin' || Auth::user()->type == 'sub-admin')
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="type">{{ translate('order type') }}</label>
                                        <select onchange="this.form.submit()" form="orders_create" class="form-control order_type select2" name="type">
                                            <option value="inhouse" @if(request('type') == 'inhouse') selected @endif>{{ translate('receipt from the branch') }}</option>
                                            <option value="online" @if(request('type') == 'online') selected @endif>{{ translate('online order') }}</option>
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
                                        <option value="cash" @if(old('payment_method') == 'cash') selected @endif>{{ translate('cash') }}</option>
                                        <option value="credit" @if(old('payment_method') == 'credit') selected @endif>{{ translate('credit') }}</option>
                                    </select>
                                    @error('payment_method')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            @if(Auth::user()->type == 'admin' || Auth::user()->type == 'sub-admin')
                                @if(request('type') == 'inhouse' || request('type') == '')
                                    <div class="col-12 branch_col">
                                        <div class="form-group">
                                            <label for="branch_id">{{ translate('order branch creation') }}</label>
                                            <select class="form-control select2 branch_select" name="branch_id">
                                                @foreach ($branches as $branch)
                                                <option value="{{ $branch->id }}" @if(old('branch_id') == $branch->id) selected @endif>{{ translate($branch->name) }}</option>
                                                @endforeach
                                            </select>
                                            @error('branch_id')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                @endif
                            @endif
                            @if(Auth::user()->role_type == 'online')
                                <div class="col-12 col-md-6 country_col">
                                    <div class="form-group">
                                        <label for="country">{{ translate('country') }}</label>
                                        <select class="form-control select2 select_country" name="country_id">
                                            @foreach ($countries as $country)
                                            <option value="{{ $country->id }}" @if(old('country_id') == $country->id) selected @endif>{{ $country->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @endif
                            @if(Auth::user()->type == 'admin' || Auth::user()->type == 'sub-admin')
                                @if(request('type') == 'online')
                                    <div class="col-12 col-md-6 country_col">
                                        <div class="form-group">
                                            <label for="country">{{ translate('country') }}</label>
                                            <select class="form-control select2 select_country" name="country_id">
                                                @foreach ($countries as $country)
                                                <option value="{{ $country->id }}" @if(old('country_id') == $country->id) selected @endif>{{ $country->name }}</option>
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
                                            <option value="{{ $customer->id }}" @if(old('customer_id') == $customer->id) selected @endif>{{ $customer->name . ' - ' . $customer->phone }}</option>
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
                                                        <label for="customer_phone">{{ translate('customer phone 2') }}</label>
                                                        <input type="text" class="form-control" name="customer_phone2" value="{{ old('customer_phone2') }}">
                                                        @error('customer_phone2')
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
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="bin_code">{{ translate('pincode') }}</label>
                                    <input type="text" class="form-control" name="bin_code" value="{{ old('bin_code') }}">
                                    @error('bin_code')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="notes">{{ translate('notes') }}</label>
                                    <textarea id="textarea" class="form-control" name="notes" maxlength="225"
                                        rows="3">{{ old('notes') }}</textarea>
                                    @error('notes')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            @if(Auth::user()->role_type == 'inhouse')
                                <div class="col-12">
                                    <div class="form-group form-check">
                                        <input type="checkbox" name="print" value="true" checked class="form-check-input" id="exampleCheck1">
                                        <label class="form-check-label" for="exampleCheck1">print order</label>
                                    </div>
                                </div>
                            @endif
                            @if(Auth::user()->role_type == 'inhouse')
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="notes">{{ translate('scan') }}</label>
                                        <textarea id="scan" class="form-control" maxlength="225"
                                            rows="3"></textarea>
                                    </div>
                                    <audio class="d-none scanner_sound" controls>
                                        <source src="{{ asset('scanner.mp3') }}" type="audio/ogg">
                                        <source src="{{ asset('scanner.mp3') }}" type="audio/mpeg">
                                        Your browser does not support the audio element.
                                    </audio>
                                </div>
                            @endif
                            <div class="col-12">
                                @error('products')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
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
                                        @if(old('products'))
                                            @foreach (old('products') as $product_old)
                                                @php
                                                    $index = $loop->index;
                                                    $variants = App\Models\ProductVariant::where('product_id', $product_old['id'])->get();
                                                @endphp
                                                <tr id="{{ $index }}" product_id="{{ $product_old['id'] }}">
                                                    @php
                                                        if(Auth::user()->type == 'admin' || Auth::user()->type == 'sub-admin' || Auth::user()->role_type == 'online') {
                                                            $products = App\Models\Product::with('variants', 'price_of_currency')->latest()->get();
                                                        }
                                                        if(Auth::user()->role_type == 'inhouse') {
                                                            $categories_ids = App\Models\Category::whereHas('branches', function($query) {
                                                                return $query->where('branch_id', Auth::user()->branch_id);
                                                            })->latest()->pluck('id');
                                                            $products = App\Models\Product::with('variants', 'price_of_currency')->whereHas('categories', function($query) use($categories_ids) {
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
                                                    </td>
                                                    <td>
                                                        <input type="number" class="form-control product_discount" name="products[{{ $index }}][discount]" value="{{ $product_old['discount'] }}">
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
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            <div class="w-100 cart-of-total-container
                            @if(@old('products')) @else d-none @endif">
                                <div class="cart-of-total">
                                    <h5>{{ translate('summary') }}</h5>
                                    <div class="responsive-table">
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <td>{{ translate('total price') }}</td>
                                                    <td class="d-flex">
                                                        <div class="total_prices">0</div>
                                                    </td>
                                                </tr>
                                                <tr class="shipping_tr d-none">
                                                    <td>{{ translate('shipping') }}</td>
                                                    <td class="d-flex">
                                                        <div class="shipping">0</div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ translate('discount') }}</td>
                                                    <td><input class="form-control total_discount" name="total_discount" type="number" placeholder="{{ translate('discount') }}" value="{{ old('total_discount') }}" min="0"></td>
                                                </tr>
                                                <tr>
                                                    <td>{{ translate('coupon') }}</td>
                                                    <td class="coupon_checked d-none">
                                                        <div class="code"></div>
                                                        <div class="price_div">
                                                            <span>{{ translate('price') . ': ' }}</span>
                                                            <span class="price"></span>
                                                        </div>
                                                        <div class="percent_div d-none">
                                                            <span>{{ translate('percent') . ': ' }}</span>
                                                            <span class="percent"></span>
                                                        </div>
                                                        <button class="btn btn-danger coupon_remove" type="button">{{ translate('remove') }}</button>
                                                    </td>
                                                    <td class="coupon_form">
                                                        <input class="form-control coupon" type="text" placeholder="{{ translate('coupon') }}" value="{{ old('coupon_id') }}">
                                                        <button class="btn btn-success coupon_submit mt-2 btn-block" type="button">{{ translate('submit coupon') }}</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ translate('price after discount') }}</td>
                                                    <td class="d-flex">
                                                        <div class="grand_total"></div>
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
                                    <input type="submit" value="{{ translate('create') }}" class="btn btn-success">
                                    <a href="{{ route('orders.index') }}" class="btn btn-info">{{ translate('back to orders') }}</a>
                                </div>
                            </div>
                        </div>
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


        let products = [];
        @if(old('products'))
        let index = {{ count(old('products')) }};
        @else
            let index = -1;
        @endif
        function tr(index, product_id) {
            return `
                <tr id="${index}" product_id="${product_id}">
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

        @if(Auth::user()->role_type == 'inhouse')
            $("#scan").focus();
        @endif

        var scan_value = '';
        $("#scan").bind('paste', function(e) {
            scan_value = e.originalEvent.clipboardData.getData('text');
            let product_id = null;
            if(scan_value !== undefined) {
                product_id = scan_value.split('.')[0];
            }
            let finded_product = products.find((product) => {
                if(product.id == product_id) {
                    return product;
                }
            })
            if(finded_product) {
                $(".scanner_sound")[0].play();
                $(this).val('')
                $(".add_row").click();
            } else {
                toastr.info('there is no product');
            }
        });


        $(".add_row").on('click', function() {
            let product_id = null;
            if(scan_value !== undefined) {
                product_id = scan_value.split('.')[0];
            }
            console.log(product_id)
            index++;
            $(".products_table tbody").append(tr(index, product_id));
            products.forEach(product => {
                $(`.products_table tbody tr#${index}`).find(".products_search").append(`
                    <option value="${product.id}" ${product_id == product.id ? 'selected' : ''}>${product.sku + ' : ' + product.name}</option>
                `);
            });
            $(`.products_table tbody tr#${index}`).find(".select2").select2();
            $(".cart-of-total-container").removeClass('d-none');

            product_search_on_value(index);
            product_search();
            files(index);
            remove_row();
        });

        function files(index, editable=null) {
            let tr = $(`tr#${index}`);
            if(editable) {
                tr.find('.input_files').click();
                tr.find('.input_files').on("change", function(e) {
                    let files = this.files;
                    files.forEach(file => {
                        tr.find(`.customized_files button`).text(files.length);
                    });
                });
            } else {
                tr.find(".files").on('click', function() {
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

        function product_search_on_value(index) {
            let variant_id = null;
            if(scan_value !== undefined) {
                variant_id = scan_value.split('.')[1];
            }

            let tr = $(".products_table tbody").find(`tr#${index}`),
                product_id = tr.find(".products_search").val(),
                product_old_id = tr.find(".products_search").data('product_id');
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
                                    <option value="${size.id}" ${variant_id == size.id ? 'selected' : ''} data-variant='${JSON.stringify(size)}'

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
                        variant_search_on_value(product_id, index);
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
        }

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
                        variant_search_on_value(product_id);
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

        function variant_search_on_value(product_id, index) {
            let tr = $(".products_table tbody").find(`tr#${index}`);
            if(product_id) {
                let product = products.find(obj => obj.id == product_id);
            } else {
                let product = products.find(obj => obj.id == tr.find(".variant_search").attr('product_id'));
            }

            if(scan_value !== undefined) {
                let variant_id = scan_value.split('.')[1];
                let variant = tr.find(".variant_search").find(`option[value=${variant_id}]`).data('variant');
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
        }

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


        $(".coupon_submit").on('click', function() {
            getPriceOfCoupon();
        })

        $(".coupon_remove").on('click', function() {
            let grand_total = parseFloat($(".grand_total").text());
            $(".grand_total").text(grand_total + parseFloat($(".coupon_checked .price").text()));
            $(".order_store .coupon_id").remove()
            $(".coupon_form").removeClass('d-none');
            $(".coupon_checked").addClass('d-none');
            $(".coupon_checked .percent_div").addClass('d-none');

        });

        function getPriceOfCoupon() {
            let token = $("meta[name=_token]").attr('content'),
            coupon_code = $(".coupon").val();
            console.log(coupon_code)
            $.ajax({
                'method': 'POST',
                'data': {
                    '_token': token,
                    'coupon_code': coupon_code
                },
                'url': "{{ route('coupons.show') }}",
                'success': function(res) {
                    if(res.status) {
                        let coupon = res.data;
                        $(".order_store").find('.coupon_id').remove();
                        $(".order_store").prepend(`
                            <input type="hidden" class="coupon_id" name="coupon_id" value="${coupon.id}">
                        `);
                        $(".coupon_form").addClass('d-none');
                        $(".coupon_checked").removeClass('d-none');
                        $(".coupon_checked .code").text(coupon.code);
                        let grand_total = parseFloat($(".grand_total").text()),
                        price = parseFloat(coupon.price);
                        if(coupon.type == 'price') {
                            $(".coupon_checked .price").text(coupon.price);
                            $(".grand_total").text(grand_total - coupon.price);

                        } else if(coupon.type == 'percent') {
                            console.log(coupon.price + '%')
                            let coupon_discount = grand_total * (price / 100);
                            $(".coupon_checked .percent_div").removeClass('d-none');
                            $(".coupon_checked .percent_div .percent").text(coupon.price + '%');
                            $(".coupon_checked .price").text(coupon_discount);
                            $(".grand_total").text(grand_total - coupon_discount);
                        }
                    } else {
                        toastr.error(res.message);
                    }
                },
                'erorr' : function(err) {
                    console.log(err);
                }
            });
        }


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
                    console.log(res);
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
            grandTotal.text(prices + shippping);
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
