@extends('layouts.master')


@section('title')
{{ translate('coupons') }}
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('title') {{ translate('coupons') }} @endslot
        @slot('li1') {{ translate('dashboard') }} @endslot
        @slot('route1') {{ route('dashboard') }} @endslot
        @slot('li3') {{ translate('coupons') }} @endslot
    @endcomponent
    <div class="all_coupons">
        <div class="card">
            <div class="card-header">
                <div class="d-flex flex-column flex-md-row text-center text-md-right justify-content-between">
                    <h2>{{ translate('coupons') }}</h2>
                </div>
                <form action="{{ route('coupons.index') }}" method="GET">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="name">{{ translate('code') }}</label>
                                        <input class="form-control" name="code" type="text" value="{{ request('code') }}">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label class="d-none d-md-inline-block" for=""></label>
                                        <input type="submit" value="{{ translate('search') }}" class="form-control btn btn-primary mt-1">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-body">
                @if(count($coupons) < 1)
                    <div class="alert alert-info">{{ translate('there is no coupons') }}</div>
                @else
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th><span class="max">{{ translate('code') }}</span></th>
                                    <th><span class="max">{{ translate('type') }}</span></th>
                                    <th><span class="max">{{ translate('price or percent') }}</span></th>
                                    <th><span class="max">{{ translate('count') }}</span></th>
                                    <th><span class="max">{{ translate('times of use') }}</span></th>
                                    <th><span class="max">{{ translate('valid before') }}</span></th>
                                    <th><span class="max">{{ translate('created at') }}</span></th>
                                    <th><span class="max">{{ translate('settings') }}</span></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($coupons as $coupon)
                                    <tr>
                                        <th scope="row">{{ $coupon->id }}</th>
                                        <td>{{ $coupon->code }}</td>
                                        <td>
                                            {{ $coupon->type }}
                                        </td>
                                        <td>
                                            {{ $coupon->price }}
                                            @if($coupon->type == 'percent')
                                             %
                                            @endif
                                        </td>
                                        <td>{{ $coupon->count }}</td>
                                        <td>{{ $coupon->orders->count() }}</td>
                                        <td>{{ $coupon->valid_before }}</td>
                                        <td>{{ $coupon->created_at->diffForHumans() }}</td>
                                        <td>
                                            @can('coupons.destroy')
                                                <button class="btn btn-danger" data-toggle="modal"
                                                    data-target="#modal_{{ $coupon->id }}">
                                                    <span>{{ translate('delete') }}</span>
                                                    <span class="mdi mdi-delete-outline"></span>
                                                </button>
                                                <!-- Modal -->
                                                @include('layouts.partials.modal', [
                                                'id' => $coupon->id,
                                                'route' => route('coupons.destroy', $coupon)
                                                ])
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $coupons->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection
