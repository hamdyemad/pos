@extends('layouts.master')


@section('title')
{{ translate('categories') }}
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('title') {{ translate('categories') }} @endslot
        @slot('li1') {{ translate('dashboard') }} @endslot
        @slot('route1') {{ route('dashboard') }} @endslot
        @slot('li3') كل {{ translate('categories') }} @endslot
    @endcomponent
    <div class="all_categories">
        <div class="card">
            <div class="card-header">
                <div class="d-flex flex-column flex-md-row text-center text-md-right justify-content-between">
                    <h2>{{ translate('categories') }}</h2>
                    @can('categories.create')
                        <div>
                            <a href="{{ route('categories.create') }}" class="btn btn-primary mb-2">{{ translate('create new category') }}</a>
                        </div>
                    @endcan
                </div>
                <form action="{{ route('categories.index') }}" method="GET">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="name">{{ translate('category name') }}</label>
                                <input class="form-control" name="name" type="text" value="{{ request('name') }}">
                            </div>
                        </div>
                        @if(Auth::user()->type == 'admin' ||  Auth::user()->type == 'sub-admin')
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="category">{{ translate('branches') }}</label>
                                    <select class="form-control select2" name="branch_id">
                                        <option value="">{{ translate('choose') }}</option>
                                        @foreach ($branches as $branch)
                                            <option value="{{ $branch->id }}" @if (request('branch_id') == $branch->id) selected @endif>{{ translate($branch->name) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endif
                        <div class="col-6">
                            <div class="form-group">
                                <input type="submit" value="{{ translate('search') }}" class="form-control btn btn-primary mt-1">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-body">
                @if(count($categories) < 1)
                    <div class="alert alert-info">{{ translate('there is no categories') }}</div>
                @else
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th><span class="max">{{ translate('category name') }}</span></th>
                                    <th><span class="max">{{ translate('the branch') }}</span></th>
                                    <th><span class="max">{{ translate('products count') }}</span></th>
                                    <th><span class="max">{{ translate('available') }}</span></th>
                                    <th><span class="max">{{ translate('appearance number') }}</span></th>
                                    <th><span class="max">{{ translate('creation date') }}</span></th>
                                    <th><span class="max">{{ translate('last update date') }}</span></th>
                                    <th><span class="max">{{ translate('settings') }}</span></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $category)
                                    <tr>
                                        <th scope="row">{{ $category->id }}</th>
                                        <td>
                                            <div>
                                                <span class="d-block">{{ $category->name }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            @foreach ($category->branches as $branch)
                                                {{ $branch->name }}
                                            @endforeach
                                        </td>
                                        <td>
                                            <a href="{{ route('products.index', ['category_id' => $category->id]) }}">
                                                {{ $category->products->count() }}
                                            </a>
                                        </td>
                                        <td>
                                            @if($category->active)
                                                <div class="badge badge-success font-size-14 p-2">{{ translate('available') }}</div>
                                            @else
                                            <div class="badge badge-danger font-size-14 p-2">{{ translate('not available') }}</div>
                                            @endif
                                        </td>
                                        <td>{{ $category->viewed_number }}</td>
                                        <td>{{ $category->created_at->diffForHumans() }}</td>
                                        <td>{{ $category->updated_at->diffForHumans() }}</td>
                                        <td>
                                            <div class="options d-flex">
                                                @can('categories.show')
                                                    <a class="btn btn-success mr-1"
                                                        href="{{ route('categories.show', $category) }}">
                                                        <span>{{ translate('show') }}</span>
                                                        <span class="mdi mdi-eye"></span>
                                                    </a>
                                                @endcan
                                                @can('categories.edit')
                                                    <a class="btn btn-info mr-1"
                                                        href="{{ route('categories.edit', $category) }}">
                                                        <span>{{ translate('edit') }}</span>
                                                        <span class="mdi mdi-circle-edit-outline"></span>
                                                    </a>
                                                @endcan
                                                @can('categories.destroy')
                                                    <button class="btn btn-danger" data-toggle="modal"
                                                        data-target="#modal_{{ $category->id }}">
                                                        <span>{{ translate('delete') }}</span>
                                                        <span class="mdi mdi-delete-outline"></span>
                                                    </button>
                                                    <!-- Modal -->
                                                    @include('layouts.partials.modal', [
                                                    'id' => $category->id,
                                                    'route' => route('categories.destroy', $category->id)
                                                    ])
                                                @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $categories->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection
