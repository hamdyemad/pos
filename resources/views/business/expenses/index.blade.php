@extends('layouts.master')


@section('title')
{{ $business->name }}
@endsection

@section('content')

    <div class="card">
        <div class="card-header">
            <div class="d-block d-md-flex justify-content-between">
                <h2>{{ $business->name . ' - ' . $business->branch->name}}</h2>
                @can('expenses.create')
                    <a href="{{ route('expenses.create', ['type' => request('type')]) }}" class="btn btn-primary mb-2">{{ translate('create') }}</a>
                @endcan
            </div>
            <form action="{{ route('expenses.index') }}" method="GET">
                <input type="text" name="type" hidden value="{{ request('type') }}">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            @if ($business->type == 'income')
                                <label for="name">{{ translate('income name') }}</label>
                            @else
                                <label for="name">{{ translate('expenses name') }}</label>
                            @endif
                            <input class="form-control" name="name" type="text" value="{{ request('name') }}">
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            @if ($business->type == 'income')
                                <label for="name">{{ translate("incomes owner's name") }}</label>
                            @else
                                <label for="name">{{ translate("expenses owner's name") }}</label>
                            @endif
                            <input class="form-control" name="expense_for" type="text"
                                value="{{ request('expense_for') }}">
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="name">{{ translate("phone") }}</label>
                            <input class="form-control" name="phone" type="text" value="{{ request('phone') }}">
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="name">{{ translate('the amount') }}</label>
                            <input class="form-control" name="price" type="text" value="{{ request('price') }}">
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="name"></label>
                            <input type="submit" value="{{ translate('search') }}" class="form-control btn btn-primary mt-1">
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-body">
            @if(count($expenses) < 1)
                <div class="alert alert-info">{{ translate('there is no results') }}</div>
            @else
                <table class="table d-block overflow-auto d-md-table mb-0">

                    <thead>
                        <tr>
                            <th>#</th>
                            @if ($business->type == 'income')
                                <th><span class="max">{{ translate('income name') }}</span></th>
                                <th><span class="max">{{ translate("incomes owner's name") }}</span></th>
                            @else
                                <th><span class="max">{{ translate('expense name') }}</span></th>
                                <th><span class="max">{{ translate("expenses owner's name") }}</span></th>
                            @endif
                            <th><span class="max">{{ translate('the phone') }}</span></th>
                            <th><span class="max">{{ translate('the amount') }}</span></th>
                            <th><span class="max">{{ translate('the notes') }}</span></th>
                            <th><span class="max">{{ translate('creation date') }}</span></th>
                            <th><span class="max">{{ translate('last update date') }}</span></th>
                            <th><span class="max">{{ translate('settings') }}</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($expenses as $expense)
                            <tr>
                                <th scope="row">{{ $expense->id }}</th>
                                <td>{{ $expense->name }}</td>
                                <td>{{ $expense->expense_for }}</td>
                                <td>{{ $expense->phone }}</td>
                                <td>{{ $expense->price }}</td>
                                <td>{{ $expense->notes }}</td>
                                <td>
                                    {{ $expense->created_at->diffForHumans() }}
                                </td>
                                <td>
                                    {{ $expense->updated_at->diffForHumans() }}
                                </td>
                                <td>
                                    <div class="options d-flex">
                                        @can('expenses.edit')
                                            <a class="btn btn-info mr-1"
                                                href="{{ route('expenses.edit', $expense) . '?type=' . request('type') }}">
                                                <span>{{ translate('edit') }}</span>
                                                <span class="mdi mdi-circle-edit-outline"></span>
                                            </a>
                                        @endcan
                                        @can('expenses.destroy')
                                            <button class="btn btn-danger" data-toggle="modal"
                                                data-target="#modal_{{ $expense->id }}">
                                                <span>{{ translate('delete') }}</span>
                                                <span class="mdi mdi-delete-outline"></span>
                                            </button>
                                            <!-- Modal -->
                                            @include('layouts.partials.modal', [
                                            'id' => $expense->id,
                                            'route' => route('expenses.destroy', $expense->id)
                                            ])
                                        @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $expenses->links() }}
            @endif
        </div>
    </div>
@endsection
