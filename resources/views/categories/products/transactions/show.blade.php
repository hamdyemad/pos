@extends('layouts.master')

@section('title')
{{ translate('show transaction') }}
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('title') {{ translate('transactions') }} @endslot
        @slot('li1') {{ translate('dashboard') }} @endslot
        @slot('li2') {{ translate('transactions') }} @endslot
        @slot('route1') {{ route('dashboard') }} @endslot
        @slot('route2') {{ route('products.transactions.index') }} @endslot
        @slot('li3') {{ translate('show transaction') }} @endslot
    @endcomponent
    <div class="create_transaction">
        <div class="container">
            <div class="card">
                <div class="card-header">
                    {{ translate('show transaction') }}
                </div>
                <div class="card-body">

                    <!-- Start Status Modal -->
                        <div class="modal fade" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="statusModalLabel">{{ translate('change order status') }}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                </div>
                                <form id="orders_status" action="{{ route('products.transactions.update_status') }}" method="POST">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="">{{ translate('reason') }}</label>
                                            <textarea class="form-control" name="reason"></textarea>
                                        </div>
                                        <div class="inputs"></div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ translate('Close') }}</button>
                                        @csrf
                                        <button type="submit" class="btn btn-primary" >{{ translate('Save') }}</button>
                                    </div>
                                </form>
                            </div>
                            </div>
                        </div>
                    <!-- End Status Modal -->
                    <div class="alert alert-secondary">
                        <h4 class="m-0 font-weight-bold">{{ $transaction->branch->name }}</h4>
                    </div>
                    <table class="table d-block d-md-table overflow-auto products_table">
                        <thead>
                            <th width="200">{{ translate('product name') }}</th>
                            <th width="50">{{ translate('sizes') }}</th>
                            <th width="50">{{ translate('qty') }}</th>
                            @if(Auth::user()->type == 'admin' || Auth::user()->type == 'sub-admin')
                                <th width="200">{{ translate('main status') }}</th>
                            @endif
                            <th width="200">{{ translate('branch status') }}</th>
                            <th>{{ translate('notes') }}</th>
                            <th>{{ translate('reason') }}</th>
                        </thead>
                        <tbody>
                            @foreach ($transaction->items as $item)
                                <tr id="{{ $item->id }}">
                                    <td width="200">
                                        {{ $item->product->name }}
                                    </td>
                                    <td width="50">
                                        {{ $item->variant->variant }}
                                    </td>
                                    <td width="50">
                                        {{ $item->qty }}
                                    </td>
                                    @if(Auth::user()->type == 'admin' || Auth::user()->type == 'sub-admin')
                                        <td width="200">
                                            <select class="form-control select2 status" data-type="main">
                                                <option value="">{{ translate('choose') }}</option>
                                                <option value="accepted" @if($item->main_accepted) selected @endif>{{ translate('accept') }}</option>
                                                <option value="refused" @if($item->main_refused) selected @endif>{{ translate('refuse') }}</option>
                                            </select>
                                        </td>
                                    @endif
                                    <td width="200">
                                        <select class="form-control select2 status" data-type="branch">
                                            <option value="">{{ translate('choose') }}</option>
                                            <option value="accepted" @if($item->branch_accepted) selected @endif>{{ translate('accept') }}</option>
                                            <option value="refused" @if($item->branch_refused) selected @endif>{{ translate('refuse') }}</option>
                                        </select>
                                    </td>
                                    <td>
                                        {{ $item->notes }}
                                    </td>
                                    <td>
                                        {{ $item->reason }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <a href="{{ route('products.transactions.index') }}" class="btn btn-info">{{ translate('back to transactions') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footerScript')
    <script>

        $(".status").on('change', function () {
            let type = $(this).data('type');
            $(".modal").modal();
            $(".modal .inputs").empty();

            $(".modal .inputs").append(`
                <input type="hidden" name="type" value="${type}">
                <input type="hidden" name="status_text" value="${$(this).val()}">
                <input type="hidden" name="item_id" value="${$(this).parent().parent().attr('id')}">
            `);
        })
    </script>
@endsection
