@extends('layouts.master')

@section('title')
{{ translate('transactions') }}
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('title') {{ translate('transactions') }} @endslot
        @slot('li1') {{ translate('dashboard') }} @endslot
        @slot('route1') {{ route('dashboard') }} @endslot
        @slot('li3') {{ translate('transactions') }} @endslot
    @endcomponent
    <div class="all_transactions">
        <div class="card">
            <div class="card-header">
                <div class="d-flex flex-column flex-md-row text-center text-md-right justify-content-between">
                    <h2>{{ translate('transactions') }}</h2>
                    @can('products.transactions.create')
                        <div>
                            <a href="{{ route('products.transactions.create') }}" class="btn btn-primary mb-2">{{ translate('create') }}</a>
                        </div>
                    @endcan
                </div>
                <form action="{{ route('products.transactions.index') }}" method="GET">
                    <div class="row">
                        @if(Auth::user()->type == 'admin' || Auth::user()->type == 'sub-admin')
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="name">{{ translate('main status name') }}</label>
                                    <select name="main_status_id" class="form-control select2">
                                        <option value="">{{ translate('choose') }}</option>
                                        @foreach ($statuses as $status)
                                            <option value="{{ $status->id }}" @if(request('main_status_id') == $status->id) selected @endif>{{ $status->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endif
                        <div class="col-6">
                            <div class="form-group">
                                <label for="name">{{ translate('branch status name') }}</label>
                                <select name="branch_status_id" class="form-control select2">
                                    <option value="">{{ translate('choose') }}</option>
                                    @foreach ($statuses as $status)
                                        <option value="{{ $status->id }}" @if(request('branch_status_id') == $status->id) selected @endif>{{ $status->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @if(Auth::user()->type == 'admin' || Auth::user()->type == 'sub-admin')
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="name">{{ translate('branch') }}</label>
                                    <select name="branch_id" class="form-control select2">
                                        <option value="">{{ translate('choose') }}</option>
                                        @foreach ($branches as $branch)
                                            <option value="{{ $branch->id }}" @if(request('branch_id') == $branch->id) selected @endif>{{ $branch->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endif
                        <div class="col-6">
                            <div class="form-group">
                                <label for=""></label>
                                <input type="submit" value="{{ translate('search') }}" class="form-control btn btn-primary mt-1">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-body">
                @if(count($transactions) < 1)
                <div class="alert alert-info">{{ translate('there is no transactions') }}</div>
                @else
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ translate('branch') }}</th>
                                    @if(Auth::user()->type == 'admin' || Auth::user()->type == 'sub-admin')
                                        <th>{{ translate('main status') }}</th>
                                    @endif
                                    <th>{{ translate('branch status') }}</th>
                                    <th>{{ translate('products count') }}</th>
                                    <th>{{ translate('created date') }}</th>
                                    <th>{{ translate('last updated date') }}</th>
                                    <th>{{ translate('settings') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transactions as $transaction)
                                    <tr id="{{ $transaction->id }}">
                                        <th scope="row">{{ $transaction->id }}</th>
                                        <td>{{ $transaction->branch->name }}</td>
                                        @if(Auth::user()->type == 'admin' || Auth::user()->type == 'sub-admin')
                                            <td>
                                                <select class="form-control status select2" data-type="main">
                                                    @foreach ($statuses as $status)
                                                        <option value="{{ $status->id }}" @if($transaction->main_status_id == $status->id) selected @endif>{{ $status->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        @endif
                                        <td>
                                            <select class="form-control status select2" data-type="branch">
                                                @foreach ($statuses as $status)
                                                    <option value="{{ $status->id }}" @if($transaction->branch_status_id == $status->id) selected @endif>{{ $status->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            {{ $transaction->items->pluck('qty')->sum() }}
                                        </td>
                                        <td>
                                            {{ $transaction->created_at->diffForHumans() }}
                                        </td>
                                        <td>
                                            {{ $transaction->updated_at->diffForHumans() }}
                                        </td>
                                        <td>
                                            <div class="options d-flex">
                                                @can('products.transactions.show')
                                                    <a class="btn btn-success mr-1" href="{{ route('products.transactions.show', $transaction) }}">
                                                        <span>{{ translate('show') }}</span>
                                                        <span class="fas fa-eye ml-1"></span>
                                                    </a>
                                                @endcan
                                                @can('products.transactions.edit')
                                                    <a class="btn btn-info mr-1" href="{{ route('products.transactions.edit', $transaction) }}">
                                                        <span>{{ translate('edit') }}</span>
                                                        <span class="mdi mdi-circle-edit-outline"></span>
                                                    </a>

                                                @endcan
                                                @can('products.transactions.destroy')
                                                    <button class="btn btn-danger" data-toggle="modal"
                                                        data-target="#modal_{{ $transaction->id }}">
                                                        <span>{{ translate('delete') }}</span>
                                                        <span class="mdi mdi-delete-outline"></span>
                                                    </button>
                                                    <!-- Modal -->
                                                    @include('layouts.partials.modal', [
                                                    'id' => $transaction->id,
                                                    'route' => route('products.transactions.destroy', $transaction->id)
                                                    ])
                                                @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $transactions->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection


@section('footerScript')
    <script>
        $(".status").on('change', function () {
            $("#preloader_all").removeClass('d-none');
            let token = $("meta[name=_token]").attr('content'),
            transaction_id = $(this).parent().parent().attr('id'),
            type = $(this).data('type'),
            status_id = $(this).val();
            $.ajax({
                "method": "POST",
                "data": {
                    "_token": token,
                    "transaction_id" : transaction_id,
                    "status_id": status_id,
                    "type": type
                },
                "url": "{{ route('products.transactions.update_main_status') }}",
                "success": function(res) {
                    if(res.status) {
                        toastr.success(res.message);
                    }
                    $("#preloader_all").addClass('d-none');
                },
                "error": function(err) {
                    console.log(err);
                }
            })
        })
    </script>
@endsection
