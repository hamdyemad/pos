
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

    function files(id, editable=null) {
        if(id) {
            if(editable) {
                $(`#${id}`).find('.input_files').click();
            } else {
                $(`#${id} .files`).on('click', function() {
                    $(this).parent().find('.input_files').click();
                })
            }
            $(`#${id} .input_files`).on("change", function(e) {
                let files = this.files;
                files.forEach(file => {
                    $(`#${id} button`).text(files.length);
                });
            });
        }
    }


    function getTrOfProductVariantTable(product,variant,obj) {
        let photo = '';
        if(product.photos) {
            photo = ` <img src="{{ asset('${JSON.parse(product.photos)[0]}') }}" alt="">`;
        } else {
            photo = `<img src="{{ asset('/images/product_avatar.png') }}" alt="">`;
        }
        return `<tr id="${variant + '_' + obj.id}">
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
                    <input class="form-control amount" name="products[${product.id}][variants][${obj.id}][amount]"  min="1"  type="number" placeholder="{{ translate('quantity') }}" value="1">
                    @error("products.*.variants.*.amount")
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </td>
                <td>
                    <input class="form-control product_discount" name="products[${product.id}][variants][${obj.id}][discount]"  type="number" placeholder="{{ translate('quantity') }}">
                </td>
                @can('orders.files')
                    <td>
                        <div class="customized_files">
                            <div class="form-group">
                                <input type="file" class="form-control input_files" multiple accept="image/*" hidden name="products[${product.id}][variants][${obj.id}][files][]">
                                <button type="button" class="btn btn-primary form-control files">
                                    <span class="mdi mdi-plus btn-lg"></span>
                                </button>
                            </div>
                        </div>
                    </td>
                @endcan
                <td><textarea class="form-control" name="products[${product.id}][variants][${obj.id}][notes]"></textarea></td>
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
                    <th>{{ translate('product name') }}</th>
                    <th>{{ translate('sizes') }}</th>
                    <th>{{ translate('price') }}</th>
                    <th>{{ translate('quantity') }}</th>
                    <th>{{ translate('discount') }}</th>
                    @can('orders.files')
                        <th>{{ translate('files') }}</th>
                    @endcan
                    <th>{{ translate('notes') }}</th>
                    <th>{{ translate('total price') }}</th>
                </thead>
                <tbody>
                </tbody>
            </table>
            `;
        } else if(variant == 'extra') {
            return `
            <table class="table extra-table">
                <thead>
                    <th>{{ translate('product name') }}</th>
                    <th>{{ translate('extras') }}</th>
                    <th>{{ translate('price') }}</th>
                    <th>{{ translate('quantity') }}</th>
                    <th>{{ translate('discount') }}</th>
                    @can('orders.files')
                        <th>{{ translate('files') }}</th>
                    @endcan
                    <th>{{ translate('notes') }}</th>
                    <th>{{ translate('total price') }}</th>
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
            <tr id="product_tr_${product.id}">
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
        <div class="table-responsive">
            <table class="table variant_table">
                <thead>
                    <th>{{ translate('product name') }}</th>
                    <th class="noraml_th">{{ translate('price') }}</th>
                    <th class="noraml_th">{{ translate('quantity') }}</th>
                    <th class="noraml_th">{{ translate('discount') }}</th>
                    @can('orders.files')
                        <th class="noraml_th">{{ translate('files') }}</th>
                    @endcan
                    <th class="noraml_th">{{ translate('notes') }}</th>
                    <th class="noraml_th">{{ translate('total price') }}</th>
                    <th class="size_th d-none">{{ translate('size') }}</th>
                    <th class="extra_th d-none">{{ translate('extra') }}</th>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        `;
    }

    function getProductsWithAjax(productsIds) {
        $.ajax({
            'method': 'GET',
            'data': {
                ids: productsIds
            },
            'url' : "{{ route('products.all_by_ids') }}",
            'success': function(products) {
                if(products.length !== 0) {
                    $(".products_table").empty();
                    products.forEach(product => {

                        if(product.variants.length !==0) {
                            console.log(product.variants);
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

                            if(sizeTypeArray.length !==0 && extraTypeArray.length !==0) {
                                $(".noraml_th").addClass('d-none');
                                $(".size_th").removeClass('d-none');
                                $(".extra_th").removeClass('d-none');
                            }
                            if(sizeTypeArray.length !==0  && extraTypeArray.length ==0) {
                                $(".noraml_th").addClass('d-none');
                                $(".size_th").removeClass('d-none');
                                $(".extra_th").removeClass('d-none');
                            }
                            if(extraTypeArray.length !== 0) {
                                $(".extra_th").removeClass('d-none');
                            }

                            if(sizeTypeArray.length !==0) {
                                $(`#product_tr_${product.id}`).append(`
                                    <td><ul class="select_variant size_select"></ul></td>
                                `);
                                sizeTypeArray.forEach((size) => {
                                    $(`#product_tr_${product.id} .size_select`).append(`
                                        <li class="variant" data-variant="${size.type}" data-variant_value='${JSON.stringify(size)}' data-product_value='${JSON.stringify(product)}'>
                                            ${size.variant}
                                        </li>
                                    `);
                                });
                            } else {
                                $(`#product_tr_${product.id}`).append(`<td><div class="price">${product.price_of_currency.price_after_discount}</div></td>`);
                                $(`#product_tr_${product.id}`).append(`<td><input class="form-control amount" value="1" min="1" type="number" name="products[${product.id}][amount]"></td>`);
                                $(`#product_tr_${product.id}`).append(`<td><input class="form-control product_discount" type="number" name="products[${product.id}][discount]"></td>`);
                                @can('orders.files')
                                    $(`#product_tr_${product.id}`).append(`<td>
                                        <div class="customized_files">
                                            <div class="form-group">
                                                <input type="file" class="form-control input_files" multiple accept="image/*" hidden name="products[${product.id}][files][]">
                                                <button type="button" class="btn btn-primary form-control files">
                                                    <span class="mdi mdi-plus btn-lg"></span>
                                                </button>
                                            </div>
                                        </div>
                                    </td>`);
                                @endcan
                                $(`#product_tr_${product.id}`).append(`<td><textarea class="form-control" name="products[${product.id}][notes]"></textarea></td>`);
                                $(`#product_tr_${product.id}`).append(`<td><div class="total_price">${product.price_of_currency.price_after_discount}</div></td>`);
                            }
                            if(extraTypeArray.length !==0) {
                                $(`#product_tr_${product.id}`).append(`
                                    <td><ul class="select_variant extra_select"></ul></td>
                                `);
                                extraTypeArray.forEach((extra) => {
                                    $(`#product_tr_${product.id} .extra_select`).append(`
                                        <li class="variant" data-variant="${extra.type}" data-variant_value='${JSON.stringify(extra)}' data-product_value='${JSON.stringify(product)}'>
                                            ${extra.variant}
                                        </li>
                                    `);
                                });
                            }

                        } else {
                            if($(".products_table").find('.variant_table').length == 0) {
                                $(".products_table").append(getProductVariantHeadingTable());
                            }
                            $(".products_table .variant_table tbody").append(getProductVariantHeadingTr(product))
                            $(`#product_tr_${product.id}`).append(`<td><div class="price">${product.price_of_currency.price_after_discount}</div></td>`);
                            $(`#product_tr_${product.id}`).append(`<td><input class="form-control amount" value="1" min="1" type="number" name="products[${product.id}][amount]"></td>`);
                            $(`#product_tr_${product.id}`).append(`<td><input class="form-control product_discount" type="number" name="products[${product.id}][discount]"></td>`);
                            @can('orders.files')
                                $(`#product_tr_${product.id}`).append(`<td>
                                        <div class="customized_files">
                                            <div class="form-group">
                                                <input type="file" class="form-control input_files" multiple accept="image/*" hidden name="products[${product.id}][files][]">
                                                <button type="button" class="btn btn-primary form-control files">
                                                    <span class="mdi mdi-plus btn-lg"></span>
                                                </button>
                                            </div>
                                        </div>
                                    </td>`);
                            @endcan
                            $(`#product_tr_${product.id}`).append(`<td><textarea class="form-control" name="products[${product.id}][notes]"></textarea></td>`);
                            $(`#product_tr_${product.id}`).append(`<td><div class="total_price">${product.price_of_currency.price_after_discount}</div></td>`);
                        }
                        getFullPrice();
                        product_price();
                        files('product_tr_' + product.id);
                    });
                    $(".variant").click('click', function() {
                        let product = $(this).data('product_value');
                        $(this).toggleClass("active");
                        let variant = $(this).data('variant'),
                            variant_id = $(this).data('variant_value').id;
                        if($(".products_table").find(`.${variant}-table`).length == 0) {
                            $(".products_table").append(getProductVariantTable(variant))
                        }
                        console.log(variant)
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
                    getFullPrice();
                    product_price();
                    amountChange();
                }
            },
            'error': function(error) {
                console.log(error)
            }
        });

    }

    function getFullPrice() {
        let prices = [],
            total_prices = $(".total_prices"),
            grandTotal = $(".grand_total"),
            shippping = parseFloat($(".shipping").text()),
            total_discount = $('.total_discount');
        if(isNaN(shippping)) {
            shippping = 0;
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
                        let id = $(selected).data('variant_value').type + '_' + $(selected).data('variant_value').id;
                        prices.push(parseFloat($(`#${id}`).find('.total_price').text()))
                    }
                });
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
        $(".amount").on('change', function() {
            let priceVal = parseFloat($(this).parent().parent().find('.price').text()),
            amountVal = parseFloat($(this).val());
            $(this).parent().parent().find('.total_price').text(priceVal * amountVal);
            getFullPrice();
        });
    }
    function product_price() {
        $(".product_discount").on('keyup', function() {
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
</script>
