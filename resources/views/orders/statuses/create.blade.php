@extends('layouts.master')

@section('title')
{{ translate('create new status') }}
@endsection
@section('content')
    @component('common-components.breadcrumb')
        @slot('title') {{ translate('create new status') }} @endslot
        @slot('li1') {{ translate('dashboard') }}@endslot
        @slot('route1') {{ route('dashboard') }} @endslot
        @slot('li2') {{ translate('statuses') }} @endslot
        @slot('route2') {{ route('statuses.index') }} @endslot
        @slot('li3') {{ translate('create new status') }} @endslot
    @endcomponent
    <div class="create">
        <div class="container">
            <div class="card">
                <div class="card-header">
                    {{ translate('create new status') }}
                </div>
                <div class="card-body">
                    <form action="{{ route('statuses.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="name">{{ translate('status name') }}</label>
                                    <input type="text" class="form-control" name="name" value="{{ old('name') }}">
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
                                        <option value="default" @if(old('type') == 'default') selected @endif>{{ translate('default') }}</option>
                                        <option value="paid" @if(old('type') == 'paid') selected @endif>{{ translate('paid') }}</option>
                                        <option value="returned" @if(old('type') == 'returned') selected @endif>{{ translate('returned') }}</option>
                                        <option value="under_collection" @if(old('type') == 'under_collection') selected @endif>{{ translate('under collection') }}</option>
                                    </select>
                                    @error('type')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for=""></label>
                                    <input type="submit" value="{{ translate('create') }}" class="btn btn-success">
                                    <a href="{{ route('statuses.index') }}" class="btn btn-info">{{ translate('back to statuses') }}</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
