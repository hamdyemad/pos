@extends('layouts.master')

@section('title')
{{ translate('information about') . ' ' . $branch->name }}
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('title') {{ $branch->name }} @endslot
        @slot('li1') {{ translate('dashboard') }} @endslot
        @slot('li2') {{ translate('branches') }} @endslot
        @slot('route1') {{ route('dashboard') }} @endslot
        @slot('route2') {{ route('branches.index') }} @endslot
        @slot('li3') {{ $branch->name }} @endslot
    @endcomponent
    <div class="show_product">
        <div class="card">
            <div class="card-header text-center text-md-left flex-column-reverse d-flex flex-md-row justify-content-between">
                <h1>{{ translate('information about') . ' ' . $branch->name }}</h1>
            </div>
            <div class="card-body">
                @if($branch->current_products->count() > 0)
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <th>{{ translate('product name') }}</th>
                                <th>{{ translate('variant') }}</th>
                                <th>{{ translate('qty') }}</th>
                            </thead>
                            <tbody>
                                @foreach ($branch->current_products as $current_product)
                                    <tr>
                                        <td>{{ $current_product->product->name }}</td>
                                        <td>{{ $current_product->variant->variant }}</td>
                                        <td>{{ $current_product->qty }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
                <a class="btn btn-info btn-block" href="{{ route('branches.index') }}">
                   {{ translate('back to branches') }}
                </a>
            </div>
        </div>
    </div>

@endsection


@section('footerScript')
    <script>


    </script>
@endsection
