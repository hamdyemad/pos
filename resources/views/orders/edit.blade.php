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
    <div class="create_order">
        <div class="container">
            <div class="card">
                <div class="card-header">
                    {{ translate('edit order') }}
                </div>
                <div class="card-body">
                    <form action="{{ route('orders.update', $order) }}" method="POST">
                        @method("PATCH")
                        @csrf
                        <div class="row">
                            @if(Auth::user()->type == 'admin')
                                <div class="col-12 col-md-6 branch_col">
                                    <div class="form-group">
                                        <label for="branch_id">{{ translate('order branch creation') }}</label>
                                        <select class="form-control select2 branch_select" name="branch_id">
                                            @foreach ($branches as $branch)
                                                <option value="{{ $branch->id }}" @if($order->branch_id == $branch->id) selected @endif>{{ translate($branch->name) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @else
                                <input type="hidden" name="branch_id" value="{{ Auth::user()->branch_id }}">
                            @endif
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="type">{{ translate('order type') }}</label>
                                    <select class="form-control order_type select2" name="type">
                                        <option value="inhouse" @if($order->type == 'inhouse') selected @endif>{{ translate('receipt from the branch') }}</option>
                                        <option value="online" @if($order->type == 'online') selected @endif>{{ translate('online order') }}</option>
                                    </select>
                                </div>
                            </div>
                            @if($order->type == 'online')
                                <div class="col-12 col-md-6 country_col">
                                    <div class="form-group">
                                        <label for="country">{{ translate('country') }}</label>
                                        <select class="form-control select2 select_country" name="country_id">
                                            @foreach ($countries as $country)
                                            <option value="{{ $country->id }}" @if($order->city->country_id == $country->id) selected @endif>{{ $country->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 city_col">
                                    <div class="form-group">
                                        <label for="city_id">{{ translate('city') }}</label>
                                        <select class="form-control select_city" name="city_id">
                                            @foreach ($cities as $city)
                                            <option value="{{ $city->id }}" data-shipping="{{ $city->price }}" @if($order->city->id == $city->id) selected @endif>{{ $city->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('city_id')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 address_col">
                                    <div class="form-group">
                                        <label for="customer_address">{{ translate('customer address') }}</label>
                                        <input type="text" class="form-control" name="customer_address" value="{{ $order->customer_address }}">
                                        @error('customer_address')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            @endif
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="customer_name">{{ translate('customer name') }}</label>
                                    <input type="text" class="form-control" name="customer_name" value="{{ $order->customer_name }}">
                                    @error('customer_name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md">
                                <div class="form-group">
                                    <label for="customer_phone">{{ translate('customer phone') }}</label>
                                    <input type="number" class="form-control" name="customer_phone" value="{{ $order->customer_phone }}">
                                    @error('customer_phone')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="products">{{ translate('products') }}</label>
                                    <select class="form-control select_products select2 select2-multiple"data-placeholder="{{ translate('choose') }}" name="products_search[]" multiple>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}" @if(in_array($product->id,$order->order_details->pluck('product_id')->toArray())) selected @endif>{{ $product->name }}</option>
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
                                            <th>{{ translate('food name') }}</th>
                                            <th>{{ translate('price') }}</th>
                                            <th>{{ translate('quantity') }}</th>
                                            <th>{{ translate('total price') }}</th>
                                            <th>{{ translate('size') }}</th>
                                            <th>{{ translate('extra') }}</th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                        </thead>
                                        <tbody>
                                            @foreach ($order->order_details->groupBy('product_id') as $key => $orderProductDetails)
                                                @php
                                                    $product = \App\Models\Product::find($key);
                                                @endphp
                                                <tr class="{{ $product->id }}">
                                                    <input type="hidden" value="products[{{ $product->id }}}]">
                                                    <td>
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
                                                            <div class="total_price">{{ $nullableOrderDetail->total_price }}</div>
                                                        </td>
                                                    @else
                                                        <td>
                                                            {{ translate('there is no price') }}
                                                        </td>
                                                        <td>
                                                            {{ translate('there is no quantity') }}
                                                        </td>
                                                        <td>
                                                            {{ translate('there is no total price') }}
                                                        </td>
                                                    @endif
                                                    <td>
                                                        @if(count($product->variants->where('type', 'size')) > 0)
                                                            <ul class="select_variant size_select">
                                                                @foreach ($product->variants->where('type', 'size') as $variant)
                                                                    <li class="variant @if($order->order_details->where('variant', $variant->variant)->first()) active @endif" data-variant="{{ $variant->type }}" data-variant_value='{{ $variant }}' data-product_value='{{ $product }}' data-id="size-{{ $variant->id }}">
                                                                        {{ $variant->variant }}
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        @else
                                                        {{ translate('there is no sizes') }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if(count($product->variants->where('type', 'extra')) > 0)
                                                            <ul class="select_variant extra_select">
                                                                @foreach ($product->variants->where('type', 'extra') as $variant)
                                                                    <li class="variant @if($order->order_details->where('variant', $variant->variant)->first()) active @endif" data-variant="{{ $variant->type }}" data-variant_value='{{ $variant }}' data-product_value='{{ $product }}' data-id="extra-{{ $variant->id }}">
                                                                        {{ $variant->variant }}
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        @else
                                                        {{ translate('there is no extras') }}
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    @if(count($order->order_details->where('variant_type', '!=', null)->where('variant_type', 'size')) > 0)
                                        <table class="table size-table">
                                            <thead>
                                                <th>{{ translate('food name') }}</th>
                                                <th>{{ translate('sizes') }}</th>
                                                <th>{{ translate('price') }}</th>
                                                <th>{{ translate('quantity') }}</th>
                                                <th>{{ translate('total price') }}</th>
                                                <th></th>
                                                <th></th>
                                            </thead>
                                            <tbody>
                                                @foreach ($order->order_details->where('variant_type', '!=', null)->where('variant_type', 'size') as $order_detail)
                                                    <tr class="{{ $order_detail->product_id }}" id="{{ \App\Models\ProductVariant::where('variant', $order_detail->variant)->where('product_id', $order_detail->product_id)->first()->id}}">
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
                                                            @php
                                                                $variant = \App\Models\ProductVariant::where('product_id', $order_detail->product_id)->where('variant', $order_detail->variant)->first();
                                                            @endphp
                                                            <input class="form-control amount" name="products[{{ $order_detail->product_id }}][variants][{{ $variant->id }}][amount]" type="number" placeholder="{{ translate('quantity') }}" value="{{ $order_detail->qty }}" min="1">
                                                            @error("products.*.$order_detail->variant_type.amount")
                                                                <div class="text-danger">{{ $message }}</div>
                                                            @enderror
                                                        </td>

                                                        <td>
                                                            <div class="total_price">{{ $order_detail->total_price }}</div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @endif
                                    @if(count($order->order_details->where('variant_type', '!=', null)->where('variant_type', 'extra')) > 0)
                                        <table class="table extra-table">
                                            <thead>
                                                <th>{{ translate('food name') }}</th>
                                                <th>{{ translate('extras') }}</th>
                                                <th>{{ translate('price') }}</th>
                                                <th>{{ translate('quantity') }}</th>
                                                <th>{{ translate('total price') }}</th>
                                                <th></th>
                                                <th></th>
                                            </thead>
                                            <tbody>
                                                @foreach ($order->order_details->where('variant_type', '!=', null)->where('variant_type', 'extra') as $order_detail)
                                                    <tr class="{{ $order_detail->product_id }}" id="{{ \App\Models\ProductVariant::where('variant', $order_detail->variant)->where('product_id', $order_detail->product_id)->first()->id}}">
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
                                                        @php
                                                            $variant = \App\Models\ProductVariant::where('product_id', $order_detail->product_id)->where('variant', $order_detail->variant)->first();
                                                        @endphp
                                                        <td>
                                                            <input class="form-control amount" name="products[{{ $order_detail->product_id }}][variants][{{ $variant->id }}][amount]" type="number" placeholder="{{ translate('quantity') }}" value="{{ $order_detail->qty }}" min="1">
                                                            @error("products.*.$order_detail->variant_type.amount")
                                                                <div class="text-danger">{{ $message }}</div>
                                                            @enderror
                                                        </td>

                                                        <td>
                                                            <div class="total_price">{{ $order_detail->total_price }}</div>
                                                        </td>
                                                    </tr>
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
                                                        <div class="currency">{{ $order->currency->code }}</div>
                                                    </td>
                                                </tr>
                                                @if($order->shipping)
                                                    <tr class="shipping_tr">
                                                        <td>{{ translate('shipping') }}</td>
                                                        <td class="d-flex">
                                                            <div class="shipping">{{ $order->shipping }}</div>
                                                            <div class="currency">{{ $order->currency->code }}</div>
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
                                                        <div class="grand_total">{{ $order->grand_total - $order->total_discount }}</div>
                                                        <div class="currency">{{ $order->currency->code }}</div>
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
        $(".order_type").on('change', function() {
            arrayOfValues = $(this).val();
            if (arrayOfValues.includes('online')) {
                $(this).parent().parent().after(address_col);
                $(this).parent().parent().after(country_col);
                $(".select_country").select2();
                @foreach ($countries as $country)
                    $(".select_country").append(`<option value="{{ $country->id }}" @if(old('country_id') == $country->id) selected @endif>{{ $country->name }}</option>`);
                @endforeach
                getCitiesByCountryId()
            } else {
                $('.shipping_tr').addClass('d-none');
                $(".address_col").remove();
                $(".country_col").remove();
                $(".city_col").remove();
                if($('.shipping_tr').hasClass('d-none')) {
                    $(".shipping_tr .shipping").text(0);
                }
            }
            getFullPrice();
        })

        $(".branch_select").on('change', function() {
            $(".products_table").empty();
            $(".select_products").empty();
            $(".cart-of-total-container").addClass('d-none');
            $('.cart-of-total-container').removeClass('d-block d-md-flex flex-row-reverse');
            getFullPrice();
            getProductsByBranchId($(".branch_select").val());
        });
        function getProductsByBranchId(branch_id) {
            let token = $("meta[name=_token]").attr('content');
            $.ajax({
                'method': 'POST',
                'data': {
                    '_token': token,
                    'branch_id': branch_id
                },
                'url': "{{ route('products.all') }}",
                'success': function(res) {
                    if(res.status) {
                        $(".select_products").select2().html('');
                        res.data.forEach((obj) => {
                            $(".select_products").append(`
                            <option value="${obj.id}" @if(is_array(old('products_search')) && in_array(${obj.id}, old('products_search'))) selected @endif>${obj.name}</option>
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
                    country_id: country_id,
                    currency_id: $("[name=currency_id]").val()
                },
                'url' : `{{ route('countries.cities.all') }}`,
                'success': function(res) {
                    if(res.status) {
                        $(".select_city").select2().html('');
                        res.data.forEach((obj) => {
                            $(".select_city").append(`<option value="${obj.id}" data-shipping="${obj.current_price.price}">${obj.name}</option>`);
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

    function getTrOfProductVariantTable(product,obj) {
        let photo = '';
        if(product.photos) {
            photo = ` <img src="{{ asset('${JSON.parse(product.photos)[0]}') }}" alt="">`;
        } else {
            photo = `<img src="{{ asset('/images/product_avatar.png') }}" alt="">`;
        }
        return `<tr id="${obj.id}">
                <td>
                    <div class="d-flex align-items-center">
                        ${photo}
                        <span> ${product.name}</span>
                    </div>
                </td>
                <td>
                    ${obj.variant }
                </td>
                <td>
                    <div class="price">${obj.currenct_price_of_variant.price_after_discount }</div>
                </td>
                <td>
                    <input class="form-control amount" name="products[${product.id}][variants][${obj.id}][amount]" min="1" type="number" placeholder="{{ translate('quantity') }}" value="1">
                    @error("products.*.*.amount")
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </td>

                <td>
                    <div class="total_price">${obj.currenct_price_of_variant.price_after_discount }</div>
                </td>
            </tr>
        `;
    }

    function getProductVariantTable(variant) {
        if(variant == 'size')  {
            return `
            <table class="table size-table">
                <thead>
                    <th>{{ translate('food name') }}</th>
                    <th>{{ translate('sizes') }}</th>
                    <th>{{ translate('price') }}</th>
                    <th>{{ translate('quantity') }}</th>
                    <th>{{ translate('total price') }}</th>
                    <th></th>
                    <th></th>
                </thead>
                <tbody>
                </tbody>
            </table>
            `;
        } else if(variant == 'extra') {
            return `
            <table class="table extra-table">
                <thead>
                    <th>{{ translate('food name') }}</th>
                    <th>{{ translate('extras') }}</th>
                    <th>{{ translate('price') }}</th>
                    <th>{{ translate('quantity') }}</th>
                    <th>{{ translate('total price') }}</th>
                    <th></th>
                    <th></th>
                </thead>
                <tbody>
                </tbody>
            </table>
            `;
        }
    }

    function getProductVariantHeadingTr(product) {
        let photo = '';
        if(product.photos) {
            photo = ` <img src="{{ asset('${JSON.parse(product.photos)[0]}') }}" alt="">`;
        } else {
            photo = `<img src="{{ asset('/images/product_avatar.png') }}" alt="">`;
        }
        return `
            <tr class="${product.id}">
                <input type="hidden" value="products[${product.id}]">
                <td>
                    <div class="d-flex align-items-center">
                        ${photo}
                        <span>${product.name}</span>
                    </div>
                </td>
            </tr>
        `;
    }

    function getProductVariantHeadingTable() {
        return `
        <table class="table variant_table">
            <thead>
                <th>{{ translate('food name') }}</th>
                <th>{{ translate('price') }}</th>
                <th>{{ translate('quantity') }}</th>
                <th>{{ translate('total price') }}</th>
                <th>{{ translate('size') }}</th>
                <th>{{ translate('extra') }}</th>
            </thead>
            <tbody>
            </tbody>
        </table>
        `;
    }

    $(".select_products").on('change', function() {
        if($(".select_products").val().length !== 0) {
            $('.cart-of-total-container').removeClass('d-none');
            $('.cart-of-total-container').addClass('d-block d-md-flex flex-row-reverse');
        } else {
            $('.cart-of-total-container').addClass('d-none');
            $('.cart-of-total-container').removeClass('d-block d-md-flex flex-row-reverse');
        }
        getFullPrice();
    });

    function getProductsWithAjax(productsIds) {

        $.ajax({
            'method': 'GET',
            'data': {
                ids: productsIds,
                currency_id: "{{ $order->currency_id }}"
            },
            'url' : "{{ route('products.all_by_ids') }}",
            'success': function(products) {
                if(products.length !== 0) {
                    products.forEach(product => {
                        if(product.variants.length !==0) {
                            if($(".products_table").find('.variant_table').length == 0) {
                                $(".products_table").append(getProductVariantHeadingTable());
                            }
                            $(".products_table .variant_table tbody").append(getProductVariantHeadingTr(product))
                            let extraTypeArray = product.variants.filter((obj) => {
                                return obj.type == 'extra';
                            });
                            let sizeTypeArray = product.variants.filter((obj) => {
                                return obj.type == 'size';
                            });
                            if(sizeTypeArray.length !==0) {
                                $(`.${product.id}`).append(`<td>{{ translate('there is no price') }}</td>`);
                                $(`.${product.id}`).append(`<td>{{ translate('there is no quantity') }}</td>`);
                                $(`.${product.id}`).append(`<td>{{ translate('there is no total price') }}</td>`);
                                $(`.${product.id}`).append(`
                                    <td><ul class="select_variant size_select"></ul></td>
                                `);
                                sizeTypeArray.forEach((size) => {
                                    $(`.${product.id} .size_select`).append(`
                                        <li class="variant" data-variant="${size.type}" data-variant_value='${JSON.stringify(size)}' data-product_value='${JSON.stringify(product)}'>
                                            ${size.variant}
                                        </li>
                                    `);
                                });
                            } else {
                                $(`.${product.id}`).append(`<td><div class="price">${product.price_of_currency.price_after_discount}</div></td>`);
                                $(`.${product.id}`).append(`<td><input class="form-control amount" value="1" min="1" type="number" name="products[${product.id}][amount]"></td>`);
                                $(`.${product.id}`).append(`<td><div class="total_price">${product.price_of_currency.price_after_discount}</div></td>`);
                                $(`.${product.id}`).append(`<td>{{ translate('there is no sizes') }}</td>`);
                            }
                            if(extraTypeArray.length !==0) {
                                $(`.${product.id}`).append(`
                                    <td><ul class="select_variant extra_select"></ul></td>
                                `);
                                extraTypeArray.forEach((extra) => {
                                    $(`.${product.id} .extra_select`).append(`
                                        <li class="variant" data-variant="${extra.type}" data-variant_value='${JSON.stringify(extra)}' data-product_value='${JSON.stringify(product)}'>
                                            ${extra.variant}
                                        </li>
                                    `);
                                });
                            } else {
                                $(`.${product.id}`).append(`<td>{{ translate('there is no extras') }}</td>`);
                            }

                        } else {
                            if($(".products_table").find('.variant_table').length == 0) {
                                $(".products_table").append(getProductVariantHeadingTable());
                            }
                            $(".products_table .variant_table tbody").append(getProductVariantHeadingTr(product))
                            $(`.${product.id}`).append(`<td><div class="price">${product.price_of_currency.price_after_discount}</div></td>`);
                            $(`.${product.id}`).append(`<td><input class="form-control amount" value="1" min="1" type="number" name="products[${product.id}][amount]"></td>`);
                            $(`.${product.id}`).append(`<td><div class="total_price">${product.price_of_currency.price_after_discount}</div></td>`);
                            $(`.${product.id}`).append(`<td>{{ translate('there is no sizes') }}</td>`);
                            $(`.${product.id}`).append(`<td>{{ translate('there is no extras') }}</td>`);
                            getFullPrice();
                        }
                    });
                    $(".variant").click('click', function() {
                        let product = $(this).data('product_value');
                        $(this).toggleClass("active");
                        let variant = $(this).data('variant');
                        if($(".products_table").find(`.${variant}-table`).length == 0) {
                            $(".products_table").append(getProductVariantTable(variant))
                        }
                        if($(this).hasClass("active")) {
                            $(`.products_table .${variant}-table tbody`).append(getTrOfProductVariantTable(product,$(this).data('variant_value')));
                        } else {
                            $(`.products_table .${variant}-table tbody #${$(this).data('variant_value').id}`).remove();
                        }
                        if($(".products_table").find(`.${variant}-table tbody`).children().length == 0) {
                            $(`.products_table .${variant}-table`).remove();
                        }
                        amountChange();
                        getFullPrice();
                    })
                    getFullPrice();
                    amountChange();
                }
            },
            'error': function(error) {
                console.log(error)
            }
        });
    }
    getVariants();
    amountChange();


    function getVariants() {
        $(".variant").click('click', function() {
            let product = $(this).data('product_value');
            $(this).toggleClass("active");
            let variant = $(this).data('variant');
            if($(".products_table").find(`.${variant}-table`).length == 0) {
                $(".products_table").append(getProductVariantTable(variant))
            }
            if($(this).hasClass("active")) {
                $(`.products_table .${variant}-table tbody`).append(getTrOfProductVariantTable(product,$(this).data('variant_value')));
            } else {
                $(`.products_table .${variant}-table tbody #${$(this).data('variant_value').id}`).remove();
            }
            if($(".products_table").find(`.${variant}-table tbody`).children().length == 0) {
                $(`.products_table .${variant}-table`).remove();
            }
            amountChange();
            getFullPrice();
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
            $(`.${optionClicked.val()}`).remove();
            if($(".variant_table tbody").children().length < 1) {
                $(".variant_table").remove();
                $(`.size-table tbody #${optionClicked.val()}`).remove();
                $(`.extra-table tbody #${optionClicked.val()}`).remove();
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
        choice_on_click();
    });

    function getFullPrice() {
        let prices = [],
            total_prices = $(".total_prices"),
            grandTotal = $(".grand_total"),
            shippping = parseFloat($(".shipping").text()),
            total_discount = $('.total_discount');
        if(isNaN(shippping)) {
            shippping = 0;
        }
        let discount = 0;
        if(!isNaN(parseFloat(total_discount.val()))) {
            discount = parseFloat(total_discount.val())
        }
        if($(".variant_table tbody").children().length !== 0) {
            $(".variant_table tbody").children().each((index, tr) => {
                if(!isNaN(parseFloat($(tr).find('.total_price').text()))) {
                    prices.push(parseFloat($(tr).find('.total_price').text()));
                }
            });
        }

        if($(".variant_table .select_variant").children().length !== 0) {
            $(".variant_table .select_variant").each((index, variant_ul) => {
                $(variant_ul).children().each((index, selected) => {
                    if($(selected).hasClass('active')) {
                        prices.push(parseFloat($(`#${$(selected).data('variant_value').id}`).find('.total_price').text()))
                    }
                });
            });
        }
        if(prices.length !== 0) {
            prices = prices.reduce((acc, current) => acc + current);
        }

        total_prices.text(prices);
        grandTotal.text((prices + shippping) - discount);
        total_discount.on('keyup', function() {
            let full_price = (prices +  shippping);
            full_price = full_price - $(this).val();
            grandTotal.text(full_price);
        });
    }
    getFullPrice();

    function amountChange() {
        $(".amount").on('keyup', function() {
            let priceVal = parseFloat($(this).parent().parent().find('.price').text()),
            amountVal = parseFloat($(this).val());
            $(this).parent().parent().find('.total_price').text(priceVal * amountVal);
            getFullPrice();
        });
    }

    </script>
@endsection
