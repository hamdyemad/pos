@extends('layouts.master')

@section('title')
{{ translate('customers') }}
@endsection
@section('content')
    @component('common-components.breadcrumb')
        @slot('title') {{ translate('customers') }} @endslot
        @slot('li1') {{ translate('dashboard') }} @endslot
        @slot('route1') {{ route('dashboard') }} @endslot
        @slot('li3') {{ translate('customers') }} @endslot
    @endcomponent
    <div class="card">
        <div class="card-header">
            <div class="d-flex flex-column flex-md-row text-center text-md-right justify-content-between">
                <h2>{{ translate('customers') }}</h2>
                @can('customers.create')
                    <div>
                        <a href="{{ route('customers.create') }}" class="btn btn-primary mb-2">{{ translate('create') }}</a>
                    </div>
                @endcan
            </div>
            <form action="{{ route('customers.index') }}" method="GET">
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="name">{{ translate('name') }}</label>
                            <input class="form-control" name="name" type="text" value="{{ request('name') }}">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="name">{{ translate('email') }}</label>
                            <input class="form-control" name="email" type="text" value="{{ request('email') }}">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="name">{{ translate('phone') }}</label>
                            <input class="form-control" name="phone" type="text" value="{{ request('phone') }}">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="name">{{ translate('address') }}</label>
                            <input class="form-control" name="address" type="text" value="{{ request('address') }}">
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="type">{{ translate('type') }}</label>
                            <select class="form-control select2" name="type">
                                <option value=""> {{ translate('choose') }}</option>
                                <option value="regular" @if(request('type') == 'regular') selected @endif>{{ translate('regular') }}</option>
                                <option value="special" @if(request('type') == 'special') selected @endif>{{ translate('special') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="name"></label>
                            <input type="submit" value="{{ translate('search') }}" class="form-control btn btn-primary mt-1">
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-body">
            @if(count($customers) < 1)
                <div class="alert alert-info">{{ translate('there is no customers') }}</div>
            @else
                <div class="table-responsive">
                    <table class="table mb-0">

                        <thead>
                            <tr>
                                <th>#</th>
                                <th><span class="max">{{ translate("user who's add customer") }}</span></th>
                                <th>{{ translate('name') }}</th>
                                <th>{{ translate('address') }}</th>
                                <th>{{ translate('phone') }}</th>
                                <th>{{ translate('phone2') }}</th>
                                <th>{{ translate('email') }}</th>
                                <th>{{ translate('type') }}</th>
                                <th>{{ translate('orders count') }}</th>
                                <th>{{ translate('creation date') }}</th>
                                <th>{{ translate('last update date') }}</th>
                                <th>{{ translate('settings') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($customers as $customer)
                                <tr>
                                    <th scope="row">{{ $customer->id }}</th>
                                    <td>
                                        @if($customer->user)
                                            {{ $customer->user->name }}
                                        @else
                                            --
                                        @endif
                                    </td>
                                    <td>{{ $customer->name }}</td>
                                    <td>{{ $customer->address }}</td>
                                    <td>{{ $customer->phone }}</td>
                                    <td>{{ $customer->phone2 }}</td>
                                    <td>{{ $customer->email }}</td>
                                    <td>{{ $customer->type }}</td>
                                    <td>
                                        <a href="{{ route('orders.index') . '?customer_id=' . $customer->id }}">{{ $customer->orders->count() }}</a>
                                    </td>
                                    <td>
                                        {{ $customer->created_at->diffForHumans() }}
                                    </td>
                                    <td>
                                        {{ $customer->updated_at->diffForHumans() }}
                                    </td>
                                    <td>
                                        <div class="options d-flex">
                                            @can('customers.edit')
                                                <a class="btn btn-info mr-1" href="{{ route('customers.edit', $customer) }}">
                                                    <span>{{ translate('edit') }}</span>
                                                    <span class="mdi mdi-circle-edit-outline"></span>
                                                </a>

                                            @endcan
                                            @can('customers.destroy')
                                                <button class="btn btn-danger" data-toggle="modal"
                                                    data-target="#modal_{{ $customer->id }}">
                                                    <span>{{ translate('delete') }}</span>
                                                    <span class="mdi mdi-delete-outline"></span>
                                                </button>
                                                <!-- Modal -->
                                                @include('layouts.partials.modal', [
                                                'id' => $customer->id,
                                                'route' => route('customers.destroy', $customer->id)
                                                ])
                                            @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $customers->appends(request()->all())->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
