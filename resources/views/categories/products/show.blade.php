@extends('layouts.master')

@section('title')
{{ translate('information about') . ' ' . $product->name }}
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('title') {{ $product->name }} @endslot
        @slot('li1') لوحة التحكم @endslot
        @slot('li2') الأكلات @endslot
        @slot('route1') {{ route('dashboard') }} @endslot
        @slot('route2') {{ route('products.index') }} @endslot
        @slot('li3') {{ $product->name }} @endslot
    @endcomponent
    <div class="show_product">
        <div class="card">
            <div class="card-header text-center text-md-left flex-column-reverse d-flex flex-md-row justify-content-between">
                <h1>{{ translate('information about') . ' ' . $product->name }}</h1>
                <img class="barcode main" src="{{ asset('products_barcodes/' . $product->barcode) }}" alt="">
            </div>
            <div class="card-body">
                <div class="owl-carousel owl-theme" style="direction: ltr">
                    @if($product->photos)
                        @foreach (json_decode($product->photos) as $photo)
                            <div class="item">
                                <img class="photos" src="{{ asset($photo) }}" alt="">
                            </div>
                        @endforeach
                    @else
                    <img class="mt-2" src="{{ asset('/images/product_avatar.png') }}" alt="">
                    @endif
                </div>
                @if($product->variants)
                    @if(isset($product->variants->groupBy('type')['size']))
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <th>{{ translate('size') }}</th>
                                <th>{{ translate('price') }}</th>
                                <th>{{ translate('discount') }}</th>
                                <th><span class="max">{{ translate('price after discount') }}</span></th>
                                <th>{{ translate('barcode') }}</th>
                            </thead>
                            <tbody>
                                @foreach ($product->variants->groupBy('type')['size'] as $variant)
                                    <tr>
                                        <td>{{ $variant->variant }}</td>
                                        <td>{{ $variant->price->price }}</td>
                                        <td>{{ $variant->price->discount }}</td>
                                        <td>{{ $variant->price->price_after_discount }}</td>
                                        <td>
                                            <img class="barcode" src="{{ asset('products_barcodes/' . $variant->barcode) }}" alt="">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                    @if(isset($product->variants->groupBy('type')['extra']))
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <th>{{ translate('extra') }}</th>
                                    <th>{{ translate('price') }}</th>
                                </thead>
                                <tbody>
                                    @foreach ($product->variants->groupBy('type')['extra'] as $variant)
                                        <tr>
                                            <td>{{ $variant->variant }}</td>
                                            <td>{{ $variant->price->price_after_discount }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                    @if($product->branches_qty->count() > 0)
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <th>{{ translate('product name') }}</th>
                                    <th>{{ translate('variant') }}</th>
                                    <th>{{ translate('qty') }}</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        @foreach ($product->branches_qty as $branch_data)
                                            <tr>
                                                <td>{{ $branch_data->branch->name }}</td>
                                                <td>{{ $branch_data->variant->variant }}</td>
                                                <td>{{ $branch_data->qty }}</td>
                                            </tr>
                                        @endforeach
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    @endif
                @endif
                <a class="btn btn-info btn-block" href="{{ route('products.index') }}">
                   {{ translate('back to products') }}
                </a>
            </div>
        </div>
    </div>

@endsection


@section('footerScript')
    <script>
        $('.owl-carousel').owlCarousel({
            // loop: true,
            margin: 10,
            nav: true,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 3
                },
                1000: {
                    items: 5
                }
            }
        })
    </script>
@endsection
