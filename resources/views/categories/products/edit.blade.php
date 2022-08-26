@extends('layouts.master')

@section('title')
{{ translate('edit food') }}
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('title') {{ $product->name }} @endslot
        @slot('li1') {{ translate('dashboard') }} @endslot
        @slot('li2') {{ translate('foods') }} @endslot
        @slot('route1') {{ route('dashboard') }} @endslot
        @slot('route2') {{ route('products.index') }} @endslot
        @slot('li3') {{ $product->name }} @endslot
    @endcomponent
    <div class="create_product">
        <div class="container">
            <div class="card">
                <div class="card-header">
                    {{ translate('edit food') }}
                </div>
                <div class="card-body">
                    <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data">
                        @method('PATCH')
                        @csrf
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="name">{{ translate('food name') }}</label>
                                    <input type="text" class="form-control @error('name')is-invalid @enderror" name="name"
                                        value="{{ $product->name }}">
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6 categories_col">
                                <div class="form-group">
                                    <label for="category">{{ translate('category') }}</label>
                                    <select class="form-control select2 categories_select" multiple name="category_id[]">
                                        <option value="">{{ translate('choose') }}</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                @if($product->categories->contains($category->id))
                                                    selected
                                                @endif
                                                >{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="count">{{ translate('product count') }}</label>
                                    <input type="text" class="form-control @error('count')is-invalid @enderror" name="count"
                                        value="{{ $product->count }}">
                                    @error('count')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="name">{{ translate('food images') }}</label>
                                    <input type="file" class="form-control input_files" accept="image/*" multiple hidden
                                        name="photos[]">
                                    <button type="button" class="btn btn-primary form-control files">
                                        <span class="mdi mdi-plus btn-lg"></span>
                                    </button>
                                    <div class="text-danger file_error" hidden>{{ translate('you should choose maximum 5 images') }}</div>
                                    <div class="imgs mt-2 d-flex">
                                        @if($product->photos)
                                            @foreach (json_decode($product->photos) as $photo)
                                                <img src="{{ asset($photo) }}" alt="">
                                            @endforeach
                                        @else
                                            <img class="mt-2" src="{{ asset('/images/product_avatar.png') }}" alt="">
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="name">{{ translate('description') }}</label>
                                    <textarea id="textarea" class="form-control description" name="description" maxlength="225"
                                        rows="3">{{ $product->description}}</textarea>
                                </div>
                            </div>
                            @if(count($product->prices) > 0 && !old('sizes'))
                                <div class="col-12 prices_table">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <th>{{ translate('price') }}</th>
                                                <th>{{ translate('discount') }}</th>
                                                <th>{{ translate('price after discount') }}</th>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <input class="form-control price-input" value="{{ $product->prices[0]['price'] }}" onkeyup="getFullPrice(this)" name="product_prices[price]" type="text" placeholder="{{ translate('price') }}">
                                                        @error("product_prices.price")
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </td>
                                                    <td>
                                                        <input class="form-control discount-input"value="{{ $product->prices[0]['discount'] }}" onkeyup="getFullPrice(this)" name="product_prices[discount]" type="text" placeholder="{{ translate('discount') }}">
                                                        @error("product_prices.discount")
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="price_after_discount">
                                                                {{ ($product->prices[0]['price'] - $product->prices[0]['discount']) }}
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endif
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="viewed_number">{{ translate('appearance number') }}</label>
                                    <input type="number" class="form-control" min="1" name="viewed_number"
                                        value="{{ $product->viewed_number }}">
                                    @error('viewed_number')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="extras">{{ translate('extras') }}</label>
                                    <select name="extras_type[]" class="form-control extras select2 select2-multiple"
                                        data-placeholder="{{ translate('choose') }}" multiple>
                                        <option value="extra"
                                        @if(isset($product->variants->groupBy('type')['extra'])) selected @endif
                                        @if(is_array(old('extras_type')) && in_array('extra', old('extras_type'))) selected @endif
                                        >{{ translate('extras') }}</option>
                                        <option value="size"
                                        @if(isset($product->variants->groupBy('type')['size'])) selected @endif
                                        @if(is_array(old('extras_type')) && in_array('size', old('extras_type'))) selected @endif
                                        >{{ translate('sizes') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 tables">
                                @if(isset($product->variants->groupBy('type')['extra']) || old('extras'))
                                    <table class="table extra-table">
                                        <thead>
                                            <th>{{ translate('extra') }}</th>
                                            <th>
                                                <button type="button" class="btn btn-success add-extra">{{ translate('add') }}</button>
                                            </th>
                                        </thead>
                                        <tbody>
                                            @if(old('extras'))
                                                @foreach (old('extras') as $key => $value)
                                                    <tr>
                                                        <td>
                                                            <input class="form-control" name="extras[{{ $key }}][variant]" value="{{ $value['variant'] }}" placeholder="{{ translate('extra') }}" type="text">
                                                            @error("extras.$key.variant")
                                                                <div class="text-danger">{{ $message }}</div>
                                                            @enderror
                                                        </td>
                                                        <td>
                                                            <input class="form-control" name="extras[{{ $key }}][prices][price]" value="{{ $value['prices']['price'] }}" onkeyup="getFullPrice(this)" placeholder="{{ translate('price') }}" type="text">
                                                            @error("extras.$key.prices.price")
                                                                <div class="text-danger">{{ $message }}</div>
                                                            @enderror
                                                        </td>
                                                        @if(count(old('extras')) > 1 && $key !== 0)
                                                        <td>
                                                            <button type="button" class="btn btn-danger remove-extra">
                                                                <span>{{ translate('remove') }}</span>
                                                                <i class="mdi mdi-trash-can-outline"></i>
                                                            </button>
                                                        </td>
                                                        @endif
                                                    </tr>
                                                @endforeach
                                            @endif
                                            @if(isset($product->variants->groupBy('type')['extra']))
                                                @foreach ($product->variants->groupBy('type')['extra'] as $key => $value)
                                                    <tr>
                                                        <td>
                                                            <input class="form-control" name="extras[{{ $key }}][variant]" value="{{ $value['variant'] }}" placeholder="{{ translate('extra') }}" type="text">
                                                            @error("extras.$key.variant")
                                                                <div class="text-danger">{{ $message }}</div>
                                                            @enderror
                                                        </td>
                                                        <td>
                                                            <input class="form-control" name="extras[{{ $key }}][prices][price]" value="{{ $value->price['price'] }}" onkeyup="getFullPrice(this)" placeholder="{{ translate('price') }}" type="text">
                                                            @error("extras.$key.prices.price")
                                                                <div class="text-danger">{{ $message }}</div>
                                                            @enderror
                                                        </td>
                                                        @if(count($product->variants->groupBy('type')['extra']) > 1 && $key !== 0)
                                                            <td>
                                                                <button type="button" class="btn btn-danger remove-extra">
                                                                    <span>{{ translate('remove') }}</span>
                                                                    <i class="mdi mdi-trash-can-outline"></i>
                                                                </button>
                                                            </td>
                                                        @endif
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                @endif
                                @if(isset($product->variants->groupBy('type')['size']) || old('sizes'))
                                    <table class="table size-table">
                                        <thead>
                                            <th>{{ translate('size') }}</th>
                                            <th>
                                                <button type="button" class="btn btn-success add-size">{{ translate('add') }}</button>
                                            </th>
                                        </thead>
                                        <tbody>
                                            @if(old('sizes'))
                                                @foreach (old('sizes') as $key => $value)
                                                    @if(!$product->variants->groupBy('type')['size']->where('variant', $value['variant'])->first())
                                                        <tr>
                                                            <td>
                                                                <table>
                                                                    <thead>
                                                                        <th>
                                                                            <input class="form-control" name="sizes[{{ $key }}][variant]" value="{{ $value['variant'] }}" placeholder="{{ translate('size') }}" type="text">
                                                                            @error("sizes.$key.variant")
                                                                                <div class="text-danger">{{ $message }}</div>
                                                                            @enderror
                                                                        </th>
                                                                        @if(count(old('sizes')) > 1 && $key !== 0)
                                                                            <th>
                                                                                <button type="button" class="btn btn-danger remove-size">
                                                                                    <span>{{ translate('remove') }}</span>
                                                                                    <i class="mdi mdi-trash-can-outline"></i>
                                                                                </button>
                                                                            </th>
                                                                        @endif
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr class="prices_for_size">
                                                                            <td>
                                                                                <input class="form-control price-input" value="{{ $value['prices']['price'] }}" name="sizes[{{ $key }}][prices][price]" onkeyup="getFullPrice(this)" placeholder="{{ translate('price') }}" type="text">
                                                                                @error("sizes.$key.prices.price")
                                                                                    <div class="text-danger">{{ $message }}</div>
                                                                                @enderror
                                                                            </td>
                                                                            <td>
                                                                                <input class="form-control discount-input" value="{{ $value['prices']['discount'] }}" name="sizes[{{ $key }}][prices][discount]" onkeyup="getFullPrice(this)" placeholder="{{ translate('discount') }}" type="text">
                                                                                @error("sizes.$key.prices.discount")
                                                                                    <div class="text-danger">{{ $message }}</div>
                                                                                @enderror
                                                                            </td>
                                                                            <td>
                                                                                <div class="d-flex align-items-center">
                                                                                    <div class="price_after_discount">
                                                                                        {{ $value['prices']['price'] - $value['prices']['discount'] }}
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            @endif
                                            @if(isset($product->variants->groupBy('type')['size']))
                                                @foreach ($product->variants->groupBy('type')['size'] as $key => $value)
                                                    <tr>
                                                        <td>
                                                            <table>
                                                                <thead>
                                                                    <th>
                                                                        <input class="form-control" name="sizes[{{ $key }}][variant]" value="{{ $value['variant'] }}" placeholder="{{ translate('size') }}" type="text">
                                                                        @error("sizes.$key.variant")
                                                                            <div class="text-danger">{{ $message }}</div>
                                                                        @enderror
                                                                    </th>
                                                                    @if(count($product->variants->groupBy('type')['size']) > 1 && $key !== 0)
                                                                        <th>
                                                                            <button type="button" class="btn btn-danger remove-size">
                                                                                <span>{{ translate('remove') }}</span>
                                                                                <i class="mdi mdi-trash-can-outline"></i>
                                                                            </button>
                                                                        </th>
                                                                    @endif
                                                                </thead>
                                                                <tbody>
                                                                    <tr class="prices_for_size">
                                                                        <td>
                                                                            <input class="form-control price-input" value="{{ $value->price['price'] }}" name="sizes[{{ $key }}][prices][price]" onkeyup="getFullPrice(this)" placeholder="{{ translate('price') }}" type="text">
                                                                            @error("sizes.$key.prices.price")
                                                                                <div class="text-danger">{{ $message }}</div>
                                                                            @enderror
                                                                        </td>
                                                                        <td>
                                                                            <input class="form-control discount-input" value="{{ $value->price['discount'] }}" name="sizes[{{ $key }}][prices][discount]" onkeyup="getFullPrice(this)" placeholder="{{ translate('discount') }}" type="text">
                                                                            @error("sizes.$key.prices.discount")
                                                                                <div class="text-danger">{{ $message }}</div>
                                                                            @enderror
                                                                        </td>
                                                                        <td>
                                                                            <div class="d-flex align-items-center">
                                                                                <div class="price_after_discount">
                                                                                    {{ $value->price['price'] - $value->price['discount'] }}
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                @endif
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="{{ translate('available') }}">{{ translate('available') }}</label>
                                <div class="form-group">
                                    <input type="checkbox" name="active" id="switch4" switch="bool"
                                    @if($product->active)
                                        checked
                                    @endif/>
                                    <label for="switch4" data-on-label="{{ translate('yes') }}" data-off-label="{{ translate('yes') }}"></label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for=""></label>
                                    <input type="submit" value="{{ translate('edit') }}" class="btn btn-success">
                                    <a href="{{ route('products.index') }}" class="btn btn-info">{{ translate('back to foods') }}</a>
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

        let extraIndex = 0,
        sizeIndex = 0;
        let extras = `
        <table class="table extra-table">
            <thead>
                <th>{{ translate('extra') }}</th>
                <th>
                    <button type="button" class="btn btn-success add-extra">{{ translate('add') }}</button>
                </th>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <input class="form-control" name="extras[0][variant]" placeholder="{{ translate('extra') }}" type="text">
                        @error('extras')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </td>
                    <td>
                        <input class="form-control" name="extras[0][prices][price]" onkeyup="getFullPrice(this)" placeholder="{{ translate('price') }}" type="text">
                    </td>
                </tr>
            </tbody>
        </table>
        `;
        let sizes = `
        <table class="table size-table">
            <thead>
                <th>{{ translate('size') }}</th>
                <th></th>
                <th></th>
                <th></th>
                <th>
                    <button type="button" class="btn btn-success add-size">{{ translate('add') }}</button>
                </th>
            </thead>
            <tbody>
                ${tr(0, 'size')}
            </tbody>
        </table>
        `;

        let prices_table =  `
            <div class="col-12 prices_table">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <th>{{ translate('price') }}</th>
                            <th>{{ translate('discount') }}</th>
                            <th>{{ translate('price after discount') }}</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <input class="form-control price-input" value="@if(old('product_prices')) {{ old('product_prices')['price'] }} @endif" onkeyup="getFullPrice(this)" name="product_prices[price]" type="text" placeholder="السعر">
                                </td>
                                <td>
                                    <input class="form-control discount-input"value="@if(old('product_prices')) {{ old('product_prices')['discount'] }} @endif" onkeyup="getFullPrice(this)" name="product_prices[discount]" type="text" placeholder="الخصم">
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="price_after_discount">
                                            @if(old('product_prices'))
                                                {{ old('product_prices')['price'] -  old('product_prices')['discount'] }}
                                            @endif
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        `;


        function tr(index, type) {
            let name = '',
                removeTd = '',
                variant = '',
                tr = '';
            if(index !== 0) {
                removeTd = `
                    <td>
                        <button type="button" class="btn btn-danger remove-${type}">
                            <span>{{ translate('remove') }}</span>
                            <i class="mdi mdi-trash-can-outline"></i>
                        </button>
                    </td>
                `;
            } else {
                removeTd = '';
            }
            if(type == 'extra') {
                name = 'extras';
                variant = 'الأضافة';
                tr = `
                    <tr>
                        <td>
                            <input class="form-control" name="${name}[${index}][variant]" placeholder="${variant}" type="text">
                        </td>
                        <td>
                            <input class="form-control" name="${name}[${index}][prices][price]" onkeyup="getFullPrice(this)" placeholder="{{ translate('price') }}" type="text">
                        </td>
                        ${removeTd}
                    </tr>
                `;
            } else if(type == 'size') {
                name = 'sizes';
                variant = 'المقاس';
                tr = `
                    <tr>
                        <td>
                            <table>
                                <thead>
                                    <th>
                                        <input class="form-control" name="${name}[${index}][variant]" placeholder="${variant}" type="text">
                                    </th>
                                    ${removeTd}
                                </thead>
                                <tbody>
                                    <tr class="prices_for_${type}">
                                        <td>
                                            <input class="form-control price-input" name="${name}[${index}][prices][price]" onkeyup="getFullPrice(this)" placeholder="{{ translate('price') }}" type="text">
                                        </td>
                                        <td>
                                            <input class="form-control discount-input" value="0" name="${name}[${index}][prices][discount]" onkeyup="getFullPrice(this)" placeholder="{{ translate('discount') }}" type="text">
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="price_after_discount"></div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                `;
            }
            return tr;
        }
        $(".extras").on('change', function() {
            arrayOfValues = $(this).val();
            if (arrayOfValues.includes('extra')) {
                if($(".extra-table").find('tbody').children().length == 0) {
                    $('.tables').prepend(extras);
                    addRow('extra');
                }
            } else {
                $(".extra-table").remove();
            }
            if (arrayOfValues.includes('size')) {
                $(".prices_table").remove();
                if($(".size-table").find('tbody').children().length == 0) {
                    $('.tables').prepend(sizes);
                    addRow('size');
                }
            } else {
                if($(".description").parent().parent().parent().find('.prices_table').length == 0) {
                    $(".description").parent().parent().after(prices_table);
                }
                $(".size-table").remove();
            }
        });
        function addRow(type) {
            $(`.add-${type}`).on('click', function() {
                let index = $($(`.${type}-table`).find('tbody')[0]).children().length;
                $($(`.${type}-table`).find('tbody')[0]).prepend(tr(index, type));
                removeRow(type);
            });
        }
        function removeRow(type) {
            $(`.remove-${type}`).on('click', function() {
                if(type == 'size') {
                    $(this).parent().parent().parent().parent().parent().parent().remove();
                } else {
                    $(this).parent().parent().remove();
                }
            });
        }
        removeRow('extra');
        removeRow('size');
        addRow('extra');
        addRow('size');

        function getFullPrice(input) {
            let tr = $(input).parent().parent(),
                priceInputVal = parseFloat($(tr).find('.price-input').val()),
                discountInputVal = parseFloat($(tr).find('.discount-input').val());
                if(isNaN(priceInputVal)) {
                    priceInputVal = 0;
                }
                if(isNaN(discountInputVal)) {
                    discountInputVal = 0;
                }
            $(tr).find('.price_after_discount').text((priceInputVal - discountInputVal));
        }
    </script>
@endsection
