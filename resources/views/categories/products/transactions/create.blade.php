@extends('layouts.master')

@section('title')
{{ translate('create new transaction') }}
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('title') {{ translate('transactions') }} @endslot
        @slot('li1') {{ translate('dashboard') }} @endslot
        @slot('li2') {{ translate('transactions') }} @endslot
        @slot('route1') {{ route('dashboard') }} @endslot
        @slot('route2') {{ route('products.transactions.index') }} @endslot
        @slot('li3') {{ translate('create new transaction') }} @endslot
    @endcomponent
    <div class="create_transaction">
        <div class="container">
            <div class="card">
                <div class="card-header">
                    {{ translate('create new transaction') }}
                </div>
                <div class="card-body">
                    <form class="order_store" action="{{ route('products.transactions.store') }}" method="POST" enctype="multipart/form-data">
                        @if(Auth::user()->role_type == 'inhouse')
                            <input type="hidden" name="branch_id" value="{{ Auth::user()->branch_id }}">
                        @endif

                        @csrf
                        <div class="row">
                            @if(Auth::user()->type == 'admin' || Auth::user()->type == 'sub-admin')
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
                            <div class="col-12">
                                @error('products')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                                <table class="table d-block d-md-table overflow-auto products_table">
                                    <thead>
                                        <th>
                                            <button type="button" class="btn btn-success add_row">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </th>
                                        <th width="200">{{ translate('product name') }}</th>
                                        <th width="200">{{ translate('sizes') }}</th>
                                        <th>{{ translate('qty') }}</th>
                                        <th>{{ translate('notes') }}</th>
                                    </thead>
                                    <tbody>
                                        @if(old('products'))
                                            @foreach (old('products') as $product_old)
                                                @php
                                                    $index = $loop->index;
                                                    $variants = App\Models\ProductVariant::where('product_id', $product_old['id'])->get();
                                                @endphp
                                                <tr id="{{ $index }}">
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
                                                    <td>
                                                        <button type="button" class="btn btn-danger remove_row">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </td>
                                                    <td width="200">
                                                        <select class="form-control select2 products_search" name="products[{{ $index }}][id]">
                                                            <option value="">{{ translate('choose') }}</option>
                                                            @foreach ($products as $product)
                                                                <option value="{{ $product->id }}" @if($product_old['id'] == $product->id) selected @endif>{{ $product->sku . ' : ' . $product->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error("products.$index.id")
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </td>
                                                    <td width="200" class="sizes_td">

                                                        @if($variants->count() > 0)
                                                            <select class="form-control select2 products_search" name="products[{{ $index }}][variant_id]" data-product_id="{{ $product_old['id'] }}">
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
                                                    <td>
                                                        <input type="number" class="form-control amount" name="products[{{ $index }}][amount]" value="{{ $product_old['amount'] }}">
                                                        @error("products.$index.amount")
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </td>
                                                    <td><textarea class="form-control" name="products[{{ $index }}][notes]">{{ $product_old['notes'] }}</textarea></td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for=""></label>
                                    <input type="submit" value="{{ translate('create') }}" class="btn btn-success">
                                    <a href="{{ route('products.transactions.index') }}" class="btn btn-info">{{ translate('back to transactions') }}</a>
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


        let products = [];
        @if(old('products'))
            let index = {{ count(old('products')) - 1 }};
        @else
            let index = -1;
        @endif
        function tr(index) {
            return `
                <tr id="${index}">
                    <td>
                        <button type="button" class="btn btn-danger remove_row">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                    <td width="200">
                        <select class="select2 products_search form-control" name="products[${index}][id]">
                            <option value="">{{ translate('choose') }}</option>
                        </select>
                    </td>
                    <td width="200" class="sizes_td">--</td>
                    <td>
                        <input type="number" class="form-control amount" name="products[${index}][amount]" value="1">
                    </td>
                    <td><textarea class="form-control" name="products[${index}][notes]"></textarea></td>
                </tr>
            `;
        }


        $(".add_row").on('click', function() {
            index++;
            $(".products_table tbody").append(tr(index));
            products.forEach(product => {
                $(".products_search").append(`
                    <option value="${product.id}">${product.sku + ' : ' + product.name}</option>
                `);
            });
            $(".products_table .select2").select2();
            $(".cart-of-total-container").removeClass('d-none');
            product_search();
            remove_row();
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
                                <select class="select2 variant_search form-control" name="products[${index}][variant_id]">
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
                    }
                }
                amountChange();
            })
        }
        product_search();

        function remove_row() {
            $(".remove_row").on('click', function() {
                $(this).parent().parent().remove();
            });
        }
        remove_row();


        $(".branch_select").on('change', function() {
            getProductsByBranchId($(this).val(), 'inhouse');
        });

        @if(Auth::user()->role_type == 'inhouse')
            getProductsByBranchId("{{ Auth::user()->branch_id }}", 'inhouse')
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
                'url': "{{ route('products.all.categories') }}",
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


        function amountChange() {
            $(".amount").on('keyup, change', function() {
                let priceVal = parseFloat($(this).parent().parent().find('.price').text()),
                amountVal = parseFloat($(this).val());
                $(this).parent().parent().find('.total_price').text(priceVal * amountVal);
            });
        }
        amountChange();



    </script>
@endsection
