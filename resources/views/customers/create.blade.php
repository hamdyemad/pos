@extends('layouts.master')


@section('title')
{{ translate('create new customer') }}
@endsection
@section('content')
    @component('common-components.breadcrumb')
        @slot('title') {{ translate('customers') }} @endslot
        @slot('li1') {{ translate('dashboard') }} @endslot
        @slot('li2') {{ translate('customers') }} @endslot
        @slot('route1') {{ route('dashboard') }} @endslot
        @slot('route2') {{ route('customers.index') }} @endslot
        @slot('li3') {{ translate('create new customer') }} @endslot
    @endcomponent
    <div class="create">
        <div class="container">
            <div class="card">
                <div class="card-header">
                    {{ translate('create new customer') }}
                </div>
                <div class="card-body">
                    <form action="{{ route('customers.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="name">{{ translate('name') }}</label>
                                    <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="address">{{ translate('email') }}</label>
                                    <input type="text" class="form-control" name="email" value="{{ old('email') }}">
                                    @error('email')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="phone">{{ translate('phone') }}</label>
                                    <input type="number" class="form-control" name="phone" value="{{ old('phone') }}">
                                    @error('phone')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="phone">{{ translate('phone2') }}</label>
                                    <input type="number" class="form-control" name="phone2" value="{{ old('phone2') }}">
                                    @error('phone2')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="address">{{ translate('address') }}</label>
                                    <input type="text" class="form-control" name="address" value="{{ old('address') }}">
                                    @error('address')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="type">{{ translate('type') }}</label>
                                    <select class="form-control select2" name="type">
                                        <option value="regular" @if(old('type') == 'regular') selected @endif>{{ translate('regular') }}</option>
                                        <option value="special" @if(old('type') == 'special') selected @endif>{{ translate('special') }}</option>
                                        <option value="jomla" @if(old('type') == 'jomla') selected @endif>{{ translate('jomla') }}</option>
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
                                    <a href="{{ route('customers.index') }}" class="btn btn-info">{{ translate('back to customers') }}</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
