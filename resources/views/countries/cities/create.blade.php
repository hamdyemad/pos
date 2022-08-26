@extends('layouts.master')
@section('title')
{{ translate('create new city') }}
@endsection
@section('content')
    @component('common-components.breadcrumb')
        @slot('title') {{ $country->name }} @endslot
        @slot('li1') {{ translate('dashboard') }} @endslot
        @slot('route1') {{ route('dashboard') }} @endslot
        @slot('li2') {{ translate('cities') }} @endslot
        @slot('route2') {{ route('countries.cities.index', $country) }} @endslot
        @slot('li3') {{ $country->name }} @endslot
    @endcomponent
    <div class="create">
        <div class="container">
            <div class="card">
                <div class="card-header">
                    <h2>{{ $country->name }}</h2>
                    {{ translate('create new city') }}
                </div>
                <div class="card-body">
                    <form action="{{ route('countries.cities.store', $country) }}" method="POST">
                        <input type="hidden" name="country_id" value="{{ $country->id }}">
                        @csrf
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="name">{{ translate('city name') }}</label>
                                    <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="name">{{ translate('price') }}</label>
                                    <input type="text" class="form-control" name="price" value="{{ old('price') }}">
                                    @error('price')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <input type="submit" value="{{ translate('create') }}" class="btn btn-success">
                                    <a href="{{ route('countries.cities.index', $country) }}" class="btn btn-info">{{ translate('back to cities') }}</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
