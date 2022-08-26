@extends('layouts.master')

@section('title')
{{ translate('products') }}
@endsection
@section('content')
    @component('common-components.breadcrumb')
        @slot('title') {{ translate('products') }} @endslot
        @slot('li1') {{ translate('dashboard') }} @endslot
        @slot('route1') {{ route('dashboard') }} @endslot
        @slot('li3') {{ translate('products') }} @endslot
    @endcomponent
    <div class="all_products">
        <div class="card">
            <div class="card-header">
                <div class="d-flex flex-column flex-md-row text-center text-md-right justify-content-between">
                    <h2>{{ translate('products') }}</h2>
                    <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                        <i class="fa fa-filter" aria-hidden="true"></i>
                        <span>{{ translate('filter') }}</span>
                    </button>
                </div>
                <div class="collapse mt-2" id="collapseExample">
                    <form action="{{ route('products.index') }}" method="GET">
                        <div class="row">
                            <div class="col-12 col-md-6 col-lg-3">
                                <div class="form-group">
                                    <label for="name">{{ translate('product name') }}</label>
                                    <input class="form-control" name="name" type="text" value="{{ request('name') }}">
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3">
                                <div class="form-group">
                                    <label for="name">{{ translate('description') }}</label>
                                    <input class="form-control" name="description" type="text"
                                        value="{{ request('description') }}">
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3">
                                <div class="form-group">
                                    <label for="category">{{ translate('choose category') }}</label>
                                    <select class="form-control categories_select select2" name="category_id">
                                        <option value="">{{ translate('choose') }}</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                            @if(request('category_id') == $category->id) selected @endif
                                                >{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3">
                                <div class="form-group">
                                    <label for="discount">{{ translate('price') }}</label>
                                    <input class="form-control" name="price" type="text" value="{{ request('price') }}">
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3">
                                <div class="form-group">
                                    <label for="discount">{{ translate('discount') }}</label>
                                    <input class="form-control" name="discount" type="text"
                                        value="{{ request('discount') }}">
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3">
                                <div class="form-group">
                                    <label for="price_after_discount">{{ translate('price after discount') }}</label>
                                    <input class="form-control" name="price_after_discount" type="text"
                                        value="{{ request('price_after_discount') }}">
                                </div>
                            </div>
                            {{-- <div class="col-12 col-md-6 col-lg-3">
                                <div class="form-group">
                                    <label for="viewed_number">{{ translate('appearance number') }}</label>
                                    <input class="form-control" name="viewed_number" type="number"
                                        value="{{ request('viewed_number') }}">
                                </div>
                            </div> --}}
                            <div class="col-12 col-md-6 col-lg-3">
                                <div class="form-group">
                                    <label for="category">{{ translate('available') }}</label>
                                    <select class="form-control select2" name="active">
                                        <option value="">{{ translate('choose') }}</option>
                                        <option @if(request('active') == 'true') selected @endif value="true">{{ translate('available') }}</option>
                                        <option @if(request('active') == 'false') selected @endif value="false">{{ translate('not available') }}</option>
                                    </select>
                                    @error('active')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3">
                                <div class="form-group">
                                    <label for="date_range">{{ translate('creation date') }}</label>
                                    <div class="input-daterange input-group" id="date-range">
                                        <input type="text" class="form-control" placeholder="{{ translate('from') }}" name="start"
                                            value="{{ request('start') }}" />
                                        <input type="text" class="form-control" placeholder="{{ translate('to') }}" name="end"
                                            value="{{ request('end') }}" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3">
                                <label class="d-none d-lg-inline-block" for=""></label>
                                <input type="submit" value="{{ translate('search') }}" class="form-control btn btn-primary">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card-body">
                @if(count($products) < 1)
                    <div class="alert alert-info">{{ translate('there is no products') }}</div>
                @else
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th><span>{{ translate('order number') }}</span></th>
                                    <th><span>{{ translate('food name') }}</span></th>
                                    <th><span>{{ translate('categories') }}</span></th>
                                    {{-- <th><span>{{ translate('description') }}</span></th> --}}
                                    <th><span>{{ translate('available') }}</span></th>
                                    {{-- <th><span>{{ translate('appearance number') }}</span></th> --}}
                                    <th><span>{{ translate('creation date') }}</span></th>
                                    <th><span>{{ translate('last update date') }}</span></th>
                                    <th><span>{{ translate('settings') }}</span></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                    <tr class="alert-secondary">
                                        <th scope="row">{{ $product->id }}</th>
                                        <td>
                                            <div>
                                                <h4 class="mr-2">
                                                    {{ $product->name }}
                                                </h4>
                                                @if ($product->photos !== null)
                                                    <img class="mt-2"
                                                        src="{{ asset(json_decode($product->photos)[0]) }}" alt="">
                                                @else
                                                    <img class="mt-2"
                                                        src="{{ asset('/images/product_avatar.png') }}" alt="">
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            @foreach ($product->categories as $category)
                                                <a class="h4 d-block" href="{{ route('categories.show', $category->id) }}">{{ $category->name }}</a>
                                            @endforeach
                                        </td>
                                        {{-- <td>
                                            @if (strlen($product->description) > 20)
                                                {{ substr($product->description, 0, 20) . '...' }}
                                            @else
                                                {{ $product->description }}
                                            @endif
                                        </td> --}}
                                        <td>
                                            @if ($product->active)
                                                <div class="badge badge-success w-100 p-2">{{ translate('yes') }}</div>
                                            @else
                                                <div class="badge badge-secondary w-100">{{ translate('no') }}</div>
                                            @endif
                                        </td>
                                        {{-- <td>
                                            {{ $product->viewed_number }}
                                        </td> --}}
                                        <td>
                                            {{ $product->created_at->diffForHumans() }}
                                        </td>
                                        <td>
                                            {{ $product->updated_at->diffForHumans() }}
                                        </td>
                                        <td>
                                            <div class="options d-flex">
                                                @can('products.show')
                                                    <a class="btn btn-success mr-1"
                                                        href="{{ route('products.show', $product) }}">
                                                        <span>{{ translate('show') }}</span>
                                                        <span class="mdi mdi-eye"></span>
                                                    </a>
                                                @endcan
                                                @can('products.edit')
                                                    <a class="btn btn-info mr-1" href="{{ route('products.edit', $product) }}">
                                                        <span>{{ translate('edit') }}</span>
                                                        <span class="mdi mdi-circle-edit-outline"></span>
                                                    </a>
                                                @endcan
                                                @can('products.destroy')
                                                    <button class="btn btn-danger" data-toggle="modal"
                                                        data-target="#modal_{{ $product->id }}">
                                                        <span>{{ translate('delete') }}</span>
                                                        <span class="mdi mdi-delete-outline"></span>
                                                    </button>
                                                    <!-- Modal -->
                                                    @include('layouts.partials.modal', [
                                                    'id' => $product->id,
                                                    'route' => route('products.destroy', $product->id)
                                                    ])
                                                @endcan
                                        </td>
                                    </tr>
                                    @if(count($product->prices) > 0)
                                        <tr>
                                            <td colspan="2">{{ translate('price') }}</td>
                                            <td colspan="2">{{ translate('discount') }}</td>
                                            <td colspan="2">{{ translate('price after discount') }}</td>
                                            </td>
                                        </tr>
                                        @foreach ($product->prices as $price)
                                            <tr>
                                                <td colspan="2">{{ $price->price }}</td>
                                                <td colspan="2">{{ $price->discount }}</td>
                                                <td colspan="2">{{ $price->price_after_discount }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    @if($product->variants)
                                        @if(isset($product->variants->groupBy('type')['size']))

                                            <tr>
                                                <td colspan="4"><h4>{{ translate('size') }}</h4></td>
                                            </tr>
                                            @foreach ($product->variants->groupBy('type')['size'] as $variant)
                                                <tr>
                                                    <td>{{ $variant->variant }}</td>
                                                    <td>
                                                        <div class="d-flex align-items-center mb-2">
                                                            <span class="max">{{ translate('price') . ':' }}</span> <span class="badge badge-secondary d-block font-size-16 font-weight-bold ml-2">{{ $variant->price->price }}</span>
                                                        </div>
                                                        @if($variant->price->discount > 1)
                                                            <div class="d-flex align-items-center mb-2">
                                                                <span class="max">{{ translate('discount') . ':' }}</span><span class="badge badge-secondary d-block font-size-16 font-weight-bold ml-2">{{ $variant->price->discount }}</span>
                                                            </div>
                                                            <div class="d-flex align-items-center">
                                                                <span class="max">{{ translate('price after discount') . ':' }}</span><span class="badge badge-secondary d-block font-size-16 font-weight-bold ml-2">{{ $variant->price->price_after_discount }}</span>
                                                            </div>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                        @if(isset($product->variants->groupBy('type')['extra']))
                                            <tr>
                                                <td colspan="6"><h4>{{ translate('extras') }}</h4></td>
                                            </tr>
                                            @foreach ($product->variants->groupBy('type')['extra'] as $variant)
                                                <tr>
                                                    <td >{{ $variant->variant }}</td>
                                                    <td>{{ $variant->price->price_after_discount }}</td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                        {{ $products->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection


@section('footerScript')
    <script>
    </script>
@endsection
