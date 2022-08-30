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
                        @if(request('discount_type') == 'percent')
                            <input type="hidden" name="discount_type" value="percent">
                        @elseif(request('discount_type') == 'amount')
                            <input type="hidden" name="discount_type" value="amount">
                        @else
                            <input type="hidden" name="discount_type" value="amount">
                        @endif

                        @if(request('type') =='online')
                            <input type="hidden" name="type" value="online">
                        @elseif(request('type') =='inhouse')
                            <input type="hidden" name="type" value="inhouse">
                        @else
                            <input type="hidden" name="type" value="inhouse">
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
                            <div class="col-12">
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
                                    <select class="form-control select_products select2 select2-multiple"data-placeholder="{{ translate('choose') }}" name="products_search[]" multiple></select>
                                    @error("products_search")
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
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
                            <div class="col-12">
                                <div class="responsive-table products_table"></div>
                            </div>
                            <div class="w-100 cart-of-total-container d-none">
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
@include('orders.orders_scripts')
    <script>


        @if(request('type') == 'inhouse')
            getProductsByBranchId($('.branch_select').val(), 'inhouse');
        @elseif(request('type') == 'online')
            getProductsByBranchId($('.branch_select').val(), null);
        @else
            getProductsByBranchId($('.branch_select').val(), 'inhouse');
        @endif


        $(".branch_select").on('change', function() {
            getProductsByBranchId($(this).val(), 'inhouse');
        });


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
                    $(".select_products").select2().html('');
                    if(res.status) {
                        res.data.forEach((obj) => {
                            $(".select_products").append(`
                                <option value="${obj.id}" data-name="${obj.name}">
                                    ${obj.name + ' : ' + obj.sku}
                                    </option>
                            `);
                        });

                    } else {
                        toastr.error(res.message);
                    }
                },
                'erorr' : function(err) {
                    console.log(err);
                }
            });
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


        if($(".select_products").val().length !== 0) {
            $('.cart-of-total-container').removeClass('d-none');
            $('.cart-of-total-container').addClass('d-block d-md-flex flex-row-reverse ');
            getProductsWithAjax($(".select_products").val());
        }



        $(".select_products").on('change', function() {
            arrayOfValues = $(this).val();
            if(arrayOfValues.length !== 0) {
                $('.cart-of-total-container').removeClass('d-none');
                $('.cart-of-total-container').addClass('d-block d-md-flex flex-row-reverse ');
                getProductsWithAjax(arrayOfValues);
            } else {
                $(".products_table").empty();
                $('.cart-of-total-container').removeClass('d-block d-md-flex flex-row-reverse ');
                $('.cart-of-total-container').addClass('d-none');
            }
        });


        getFullPrice();


    </script>
@endsection
