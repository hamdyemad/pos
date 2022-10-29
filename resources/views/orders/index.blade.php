@extends('layouts.master')

@section('title')
{{ translate('orders') }}
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('title') {{ translate('orders') }} @endslot
        @slot('li1') {{ translate('dashboard') }} @endslot
        @slot('route1') {{ route('dashboard') }} @endslot
        @slot('li3') {{ translate('orders') }} @endslot
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
                                @can('orders.excel')
                                    <button class="dropdown-item  export_excel_btn" type="button" form="orders_form">
                                        <i class="fas fa-file-csv"></i>
                                        <span>{{ translate('export excel') }}</span>
                                    </button>
                                @endcan
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
                    <form action="{{ route('orders.index') }}" id="orders_form" method="GET">
                        <div class="row">
                            <div class="col-12 col-md-6 col-lg-3">
                                <div class="form-group">
                                    <label for="id">{{ translate('order number') }}</label>
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
                                    <label class="d-none d-md-inline-block" for="name"></label>
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
                                <th><span>{{ translate('employee order') }}</span></th>
                                <th><span>{{ translate('customer') }}</span></th>
                                <th><span>{{ translate('city') }}</span></th>
                                <th><span>{{ translate('order status') }}</span></th>
                                {{-- <th><span>{{ translate('paid') }}</span></th> --}}
                                <th><span>{{ translate('order branch') }}</span></th>
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
                                        @if($order->user)
                                        {{ $order->user->name }}
                                        @else
                                        --
                                        @endif
                                    </th>
                                    @if($order->customer)
                                        <td>{{ $order->customer->name }}</td>
                                    @else
                                        <td>--</td>
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
                                        <div class="div_status">
                                            <select class="form-control status select2">
                                                @foreach ($statuses as $status)
                                                    <option value="{{ $status->id }}" data-returned="{{ $status->returned }}"
                                                        @if($order->status_id == $status->id) selected @endif>
                                                        {{ $status->name }}</option>
                                                @endforeach
                                            </select>
                                            <!-- Modal -->
                                            <div class="modal fade" id="returnedModal_{{ $order->id }}" tabindex="-1" aria-labelledby="returnedModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                    <h5 class="modal-title" id="returnedModalLabel">{{ translate('return order') }}</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                    </div>
                                                    <form action="{{ route('orders.status_update') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="type" value="returned">
                                                        <input type="hidden" name="order_id" value="{{ $order->id }}">
                                                        <input type="hidden" name="branch_id" value="{{ $order->branch_id }}">
                                                        <input type="hidden" name="status_id" value="{{ $order->status_id }}">
                                                        <div class="modal-body">
                                                            <table>
                                                                <thead>
                                                                    <tr>
                                                                        <td>
                                                                            {{ translate('product name') }}
                                                                        </td>
                                                                        <td>
                                                                            {{ translate('variant') }}
                                                                        </td>
                                                                        <td>{{ translate('price') }}</td>
                                                                        <td>{{ translate('quantity') }}</td>
                                                                        <td>{{ translate('total price') }}</td>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($order->order_details as $order_detail)
                                                                        <tr>
                                                                            <td>
                                                                                <input type="hidden" name="product_id[]" value="{{ $order_detail->product_id }}">
                                                                                <input type="hidden" name="variant[]" value="{{ $order_detail->variant }}">
                                                                                {{ $order_detail->product->name }}
                                                                            </td>
                                                                            <td>
                                                                                {{ $order_detail->variant }}
                                                                            </td>
                                                                            <td>
                                                                                <div class="price">
                                                                                    {{ $order_detail->price }}
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <input min="0" max="{{ $order_detail->qty }}" class="form-control amount" name="qty[]" type="number" value="{{ $order_detail->qty }}">
                                                                            </td>
                                                                            <td>
                                                                                <div class="total_price">{{ $order_detail->total_price }}</div>
                                                                            </td>
                                                                        </tr>

                                                                    @endforeach
                                                                    <tr>
                                                                        <td colspan="4">{{ translate('final price') }}</td>
                                                                        <td>
                                                                            <div class="final_price">
                                                                                {{ $order->order_details->pluck('total_price')->sum() }}
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ translate('close') }}</button>
                                                            <button type="submit" class="btn btn-primary">{{ translate('save') }}</button>
                                                        </div>
                                                    </form>
                                                </div>
                                                </div>
                                            </div>
                                        </div>

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
                                            @if($order->type == 'inhouse' && Auth::user()->role_type == 'inhouse' || Auth::user()->type == 'admin' || Auth::user()->type == 'sub-admin'
                                            || $order->type == 'online' && Auth::user()->role_type == 'online')
                                                @can('orders.edit')
                                                    <a class="btn btn-info mr-1" href="{{ route('orders.edit', $order) }}">
                                                        <span>{{ translate('edit') }}</span>
                                                        <span class="mdi mdi-circle-edit-outline"></span>
                                                    </a>

                                                @endcan
                                            @endif
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
                    {{ $orders->appends(request()->all())->links() }}
                @endif
            </div>
        </div>
    </div>
@endsection


@section('footerScript')
    <script>


        $(".export_excel_btn").on('click', function() {
            $(`#${$(this).attr('form')}`).append('<input type="hidden" name="export" value="excel">');
            $(`#${$(this).attr('form')}`).submit();
        });


        $(".shipping_invoice_btn").on('click', function() {
            let type = $(this).data('name');
            $("#shipping_invoice").append(`
                <input type="hidden" name="type" value="${type}">
            `);
            $("#shipping_invoice").submit();
        })


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
            let returned = $(this).find('option:selected').data('returned');
            let order_id = $(this).parent().parent().parent().attr('id');
            let status_id = $(this).val();
            if(returned) {
                $(`#returnedModal_${order_id}`).find(`input[name=status_id]`).val(status_id)
                $(this).parent().find('.modal').modal();
                $(".amount").on('change, keyup', function() {
                    let full_price = [];
                    let tr = $(this).parent().parent(),
                        price = tr.find('.price'),
                        modal = tr.find('.modal'),
                        total_price = tr.find('.total_price');
                    let value = parseFloat(price.text()) * parseFloat($(this).val());


                    $(`#returnedModal_${order_id}`).find('table tbody tr').each((index, trFinded) => {
                        if($(trFinded).find('.total_price').length > 0) {
                            console.log($(trFinded).find('.total_price')[0])
                            full_price.push($(trFinded).find('.total_price').text());
                        }
                    })

                    if(full_price.length > 0) {
                        full_price = full_price.reduce((acc, curr) => {
                            return acc + curr;
                        });
                        tr.parent().find('.final_price').text(full_price)
                    }
                });
            } else {
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
                        console.log(data);
                        if(data.status) {
                            toastr.success(data.msg);
                        }
                        $("#preloader_all").addClass('d-none');
                    },
                    "error": function(err) {
                        console.log(err);
                    }
                })
            }

        })
    </script>
@endsection
