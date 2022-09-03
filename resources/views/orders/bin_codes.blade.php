@extends('layouts.master')

@section('title')
{{ translate('bin codes orders') }}
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('title') {{ translate('bin codes orders') }} @endslot
        @slot('li1') {{ translate('dashboard') }} @endslot
        @slot('route1') {{ route('dashboard') }} @endslot
        @slot('li3') {{ translate('bin codes orders') }} @endslot
    @endcomponent
    <div class="all_orders">
        <!-- Start Status Modal -->
            <div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="statusModalLabel">{{ translate('change order status') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <form id="orders_status" action="{{ route('orders.status_all_update') }}" method="POST">
                        <div class="modal-body">
                            <select class="form-control select2" name="status_id">
                                <option value="">{{ translate('choose') }}</option>
                                @foreach ($statuses as $status)
                                    <option value="{{ $status->id }}">{{ $status->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ translate('Close') }}</button>
                            @csrf
                            <button type="submit" class="btn btn-primary" >{{ translate('Save') }}</button>
                            <input class="input_orders" type="hidden" name="orders">
                        </div>
                    </form>
                </div>
                </div>
            </div>
        <!-- End Status Modal -->
        <form id="shipping_invoice" target="_blank" action="{{ route('orders.all_pdf') }}" method="POST">
            <input type="hidden" name="order_type" value="pin_codes">
            @csrf
        </form>
        <div class="card">
            <div class="card-header">
                <div class="d-flex flex-column flex-md-row text-center text-md-right justify-content-between">
                    <h2>{{ translate('orders') . ' ('. $orders->count() . ')' }}</h2>
                    <div class="d-flex">
                        <div class="dropdown mr-2">
                            <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-edit"></i>
                                <span>{{ translate('quick edit') }}</span>
                            </button>
                            <div class="dropdown-menu">
                                <button class="dropdown-item shipping_invoice_btn" type="button" data-name="online" href="#" form="shipping_invoice">
                                    <i class="fas fa-file-pdf"></i>
                                    <span>{{ translate('online invoice') }}</span>
                                </button>
                                <button class="dropdown-item shipping_invoice_btn" type="button" data-name="pos" href="#" form="shipping_invoice">
                                    <i class="fas fa-file-pdf"></i>
                                    <span>{{ translate('pos invoice') }}</span>
                                </button>
                                <button class="dropdown-item shipping_invoice_btn" type="button" data-name="export" form="shipping_invoice">
                                    <i class="fas fa-file-csv"></i>
                                    <span>{{ translate('export excel') }}</span>
                                </button>
                                <button class="dropdown-item" href="#" data-toggle="modal" data-target="#statusModal">
                                    <i class="fas fa-edit"></i>
                                    <span>{{ translate('change order status') }}</span>
                                </button>
                            </div>
                        </div>
                        <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                            <i class="fa fa-filter" aria-hidden="true"></i>
                            <span>{{ translate('filter') }}</span>
                        </button>
                    </div>
                </div>
                <div class="collapse mt-2" id="collapseExample">
                    <form action="{{ route('orders.with_bin_codes') }}" method="GET">
                        <div class="row">
                            <div class="col-12 col-md-6 col-lg-3">
                                <div class="form-group">
                                    <label for="id">{{ translate('order id') }}</label>
                                    <input class="form-control" name="id" type="text" value="{{ request('id') }}">
                                </div>
                            </div>

                            <div class="col-12 col-md-6 col-lg-3">
                                <div class="form-group">
                                    <label for="name">{{ translate('customer') }}</label>
                                    <select class="form-control select2" name="customer_id">
                                        <option value="">{{ translate('choose') }}</option>
                                        @foreach ($customers as $customer)
                                            <option value="{{ $customer->id }}" @if ($customer->id == request('customer_id')) selected @endif>
                                                {{ $customer->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 col-md-6 col-lg-3">
                                <div class="form-group">
                                    <label for="name">{{ translate('order status') }}</label>
                                    <select class="form-control select2" name="status_id">
                                        <option value="">{{ translate('choose') }}</option>
                                        @foreach ($statuses as $status)
                                            <option value="{{ $status->id }}" @if ($status->id == request('status_id')) selected @endif>
                                                {{ $status->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @if(Auth::user()->type == 'admin' || Auth::user()->type == 'sub-admin')
                                <div class="col-12 col-md-6 col-lg-3">
                                    <div class="form-group">
                                        <label for="name">{{ translate('order type') }}</label>
                                        <select class="form-control select2" name="type">
                                            <option value="">{{ translate('choose') }}</option>
                                            <option value="inhouse" @if ('inhouse' == request('type')) selected @endif>{{ translate('receipt request from the branch') }}</option>
                                            <option value="online" @if ('online' == request('type')) selected @endif>{{ translate('online order') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-3">
                                    <div class="form-group">
                                        <label for="name">{{ translate('the branch') }}</label>
                                        <select class="form-control select2" name="branch_id">
                                            <option value="">{{ translate('choose') }}</option>
                                            @foreach ($branches as $branch)
                                                <option value="{{ $branch->id }}" @if ($branch->id == request('branch_id')) selected @endif>
                                                    {{ translate($branch->name) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @endif
                            <div class="col-12 col-md-6 col-lg-3">
                                <div class="form-group">
                                    <label for="from">{{ translate('creation from') }}</label>
                                    <input class="form-control" id="from" name="from" type="date" value="{{ request('from') }}">
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3">
                                <div class="form-group">
                                    <label for="to">{{ translate('creation to') }}</label>
                                    <input class="form-control" id="to" name="to" type="date" value="{{ request('to') }}">
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3">
                                <div class="form-group">
                                    <input type="submit" value="{{ translate('search') }}" class="form-control btn btn-primary mt-1">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card-body">
                @if (count($orders) < 1)
                    <div class="alert alert-info">{{ translate('there is no orders') }}</div>
                @else

                    <table class="table table-hover d-block overflow-auto mb-0">
                        <thead>
                            <tr>
                                <th>
                                    <input class="form-control select_all" type="checkbox">
                                </th>
                                <th><span>{{ translate('order number') }}</span></th>
                                <th><span>{{ translate('order type') }}</span></th>
                                <th><span>{{ translate('employee attached order') }}</span></th>
                                <th><span>{{ translate('customer') }}</span></th>
                                <th><span>{{ translate('city') }}</span></th>
                                <th><span>{{ translate('order status') }}</span></th>
                                <th><span>{{ translate('order branch') }}</span></th>
                                <th><span>{{ translate('approval') }}</span></th>
                                <th><span>{{ translate('total price') }}</span></th>
                                <th><span>{{ translate('creation date') }}</span></th>
                                <th><span>{{ translate('settings') }}</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr id="{{ $order->id }}" data-value="{{ $order }}">
                                    <th><input class="form-control" name="orders[]" value="{{ $order->id }}"  form="shipping_invoice" type="checkbox"></th>
                                    <th>{{ $order->id }}</th>
                                    <th>
                                        {{ $order->type }}
                                        {{ $order->payment_method }}
                                    </th>
                                    <th>
                                        @php
                                            $employee_attached_order = App\User::where('bin_code', $order->bin_code)->first();
                                        @endphp
                                        @if($employee_attached_order)
                                            {{ $employee_attached_order->name }}
                                        @endif
                                    </th>
                                    @if($order->customer)
                                        <td>{{ $order->customer->name }}</td>
                                    @else
                                        <td>
                                            --
                                        </td>
                                    @endif
                                    @if($order->city)
                                        <td>
                                            {{ $order->city->name }}
                                        </td>
                                    @else
                                        <td>
                                            --
                                        </td>
                                    @endif
                                    <td>
                                        <select class="form-control status select2">
                                            @foreach ($statuses as $status)
                                                <option value="{{ $status->id }}" @if($order->status_id == $status->id) selected @endif>{{ $status->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    {{-- <td>
                                        @if($order->paid)
                                        <span class="badge badge-success">{{ translate('yes') }}</span>
                                        @else
                                        <span class="badge badge-danger">{{ translate('no') }}</span>
                                        @endif
                                    </td> --}}
                                    <td>
                                        @if($order->branch)
                                            <div class="badge badge-primary p-2">({{ translate($order->branch->name) }})</div>
                                        @else
                                        --
                                        @endif
                                    </td>
                                    <td>
                                        @can('orders.approve')
                                            @if($order->under_approve)
                                                <form action="{{ route('orders.approve', $order) }}" method="POST">
                                                    @csrf
                                                    <button class="btn btn-secondary btn-block max">{{ translate('not approved') }}</button>
                                                </form>
                                            @else
                                                <form action="{{ route('orders.approve', $order) }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="type" value="unapprove">
                                                    <button class="btn btn-secondary btn-block max">{{ translate('approved') }}</button>
                                                </form>
                                            @endif
                                        @endcan
                                    </td>
                                    <td>
                                        {{ $order->grand_total }}
                                    </td>
                                    <td>
                                        <span>{{ $order->created_at->diffForHumans() }}</span>
                                    </td>
                                    <td>
                                        <div class="options d-flex">
                                            @can('orders.show')
                                                <a class="btn btn-success mr-1" href="{{ route('orders.show', $order) }}">
                                                    <span>{{ translate('show') }}</span>
                                                    <span class="mdi mdi-eye"></span>
                                                </a>
                                            @endcan
                                            @can('orders.edit')
                                                <a class="btn btn-info mr-1" href="{{ route('orders.edit', $order) }}">
                                                    <span>{{ translate('edit') }}</span>
                                                    <span class="mdi mdi-circle-edit-outline"></span>
                                                </a>

                                            @endcan
                                            @can('orders.destroy')
                                                <button class="btn btn-danger" data-toggle="modal"
                                                    data-target="#modal_{{ $order->id }}">
                                                    <span>{{ translate('delete') }}</span>
                                                    <span class="mdi mdi-delete-outline"></span>
                                                </button>
                                                <!-- Modal -->
                                                @include('layouts.partials.modal', [
                                                'id' => $order->id,
                                                'route' => route('orders.destroy', $order->id)
                                                ])
                                            @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $orders->links() }}
                @endif
            </div>
        </div>
    </div>
@endsection


@section('footerScript')
    <script>

        $(".shipping_invoice_btn").on('click', function() {
            let type = $(this).data('name');
            $("#shipping_invoice").append(`
                <input type="hidden" name="type" value="${type}">
            `);
            $("#shipping_invoice").submit();
        })

        $("tbody tr").on('dblclick', function() {
            location.assign("/admin/orders/" + $(this).attr('id'));
        });

        $('#statusModal').on('shown.bs.modal', function () {
            console.log("yes")
            let orders = [];
            $("tbody input[type='checkbox']").each((index, input) => {
                if(input.checked) {
                    orders.push($(input).val());
                }
            })
            $(".input_orders").val(orders);
        })
        $(".select_all").on('click', function() {
            $("tbody input[type='checkbox']").each((index, input) => {
                if($(".select_all")[0].checked) {
                    input.checked = 1;
                } else {
                    input.checked = 0;
                }
            })
        });

        orderChannel.bind('App\\Events\\newOrder', function(data) {
            if(data) {
                if(data.order.branch_id == "{{ Auth::user()->branch_id }}" || "{{Auth::user()->type}}" == 'admin' || "{{ Auth::user()->type == 'sub-admin' }}") {
                    window.location.reload();
                }
            }
        });

        let statusChannel = pusher.subscribe('changeOrderStatus');
        statusChannel.bind('App\\Events\\changeOrderStatus', function(data) {
            if(data) {
                if(data.order.branch_id == "{{ Auth::user()->branch_id }}") {
                    window.location.reload();
                }
                // $(`#${data.order.id} .status`).select2("val", data.status_id);
            }
        });

        $(".status").on('change', function () {
            $("#preloader_all").removeClass('d-none');
            let token = $("meta[name=_token]").attr('content'),
            order_id = $(this).parent().parent().attr('id'),
            user_id = "{{ Auth::id() }}",
            status_id = $(this).val();
            $.ajax({
                "method": "POST",
                "data": {
                    "_token": token,
                    "order_id" : order_id,
                    "user_id" : user_id,
                    "status_id": status_id
                },
                "url": "{{ route('orders.status_update') }}",
                "success": function(data) {
                    if(data.status) {
                        toastr.success(data.msg);
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
