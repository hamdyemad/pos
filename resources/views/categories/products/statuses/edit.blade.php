@extends('layouts.master')

@section('title')
{{ translate('edit status') }}
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('title') {{ translate('edit status') }} @endslot
        @slot('li1') {{ translate('dashboard') }} @endslot
        @slot('route1') {{ route('dashboard') }} @endslot
        @slot('li2') {{ translate('statuses') }} @endslot
        @slot('route2') {{ route('products.statuses.index') }} @endslot
        @slot('li3') {{ translate('edit status') }} @endslot
    @endcomponent
    <div class="create">
        <div class="container">
            <div class="card">
                <div class="card-header">
                    {{ translate('edit status') }}
                </div>
                <div class="card-body">
                    <form action="{{ route('products.statuses.update', $status) }}" method="POST">
                        @method("PATCH")
                        @csrf
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="name">{{ translate('status name') }}</label>
                                    <input type="text" class="form-control" name="name" value="{{ $status->name }}">
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="{{ translate('status type') }}">{{ translate('status type') }}</label>
                                <div class="form-group">
                                    <select name="type" class="form-control select2">
                                        <option value="">{{ translate('choose') }}</option>
                                        <option value="default" @if($status->default_val) selected @endif>{{ translate('default') }}</option>
                                        <option value="accepted" @if($status->accepted) selected @endif>{{ translate('accepted') }}</option>
                                        <option value="returned" @if($status->returned) selected @endif>{{ translate('returned') }}</option>
                                    </select>
                                    @error('type')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for=""></label>
                                    <input type="submit" value="{{ translate('edit') }}" class="btn btn-success">
                                    <a href="{{ route('products.statuses.index') }}" class="btn btn-info">{{ translate('back to product transaction statuses') }}</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
