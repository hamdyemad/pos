@extends('layouts.master')

@section('title')
{{ translate('order show') }}
@endsection

@section('content')

    <div class="show_order">
        @component('common-components.breadcrumb')
            @slot('title') {{ translate('order show') }} @endslot
            @slot('li1') {{ translate('dashboard') }} @endslot
            @slot('li2') {{ translate('orders') }} @endslot
            @slot('route1') {{ route('dashboard') }} @endslot
            @slot('route2') {{ route('orders.index') }} @endslot
            @slot('li3') {{ translate('order show') }}  @endslot
        @endcomponent
        <div class="card">
            <div class="card-body">
                @include('inc.invoice')
                <div class="statuses_history">
                    <strong class="mb-2 d-block">{{ translate('order status history') }}</strong>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <th><span class="max">{{ translate('name of the user who changed the status') }}</span></th>
                                <th><span class="max">{{ translate('status') }}</span></th>
                                <th><span class="max">{{ translate('creation date') }}</span></th>
                            </thead>
                            <tbody>
                                @foreach ($statuses_history as $status_history)
                                    <tr>
                                        <td>{{ $status_history->user->name }}</td>
                                        <td>{{ $status_history->status->name }}</td>
                                        <td>{{ $status_history->created_at }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
