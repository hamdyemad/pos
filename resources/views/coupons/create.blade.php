@extends('layouts.master')

@section('title')
{{ translate('create new coupon') }}
@endsection
@section('content')
    @component('common-components.breadcrumb')
        @slot('title') {{ translate('coupons') }} @endslot
        @slot('li1') {{ translate('dashboard') }} @endslot
        @slot('li2') {{ translate('coupons') }} @endslot
        @slot('route1') {{ route('dashboard') }} @endslot
        @slot('route2') {{ route('coupons.index') }} @endslot
        @slot('li3') {{ translate('create new coupon') }} @endslot
    @endcomponent
    <div class="create_coupon">
        <div class="container">
            <div class="card">
                <div class="card-header">
                    {{ translate('create new coupon') }}
                </div>
                <div class="card-body">
                    <form action="{{ route('coupons.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="type">{{ translate('type') }}</label>
                                    <select class="form-control select2" name="type">
                                        <option value="">{{ translate('choose') }}</option>
                                        <option value="price" @if(old('type') == 'price') selected @endif>{{ translate('price') }}</option>
                                        <option value="percent" @if(old('type') == 'percent') selected @endif>{{ translate('percent') }}</option>
                                    </select>
                                    @error('type')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="name">{{ translate('price or percent') }}</label>
                                    <input type="text" class="form-control" name="price"
                                    value="{{ old('price') }}"
                                    >
                                    @error('price')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="name">{{ translate('code') }}</label>
                                    <input type="text" class="form-control" name="code"
                                        @if(old('code'))
                                            value="{{ old('code') }}"
                                        @else
                                            value="{{ rand(100000, 1000000) }}"
                                        @endif
                                    >
                                    @error('code')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="name">{{ translate('count') }}</label>
                                    <input type="text" class="form-control" name="count" value="{{ old('count') }}">
                                    @error('count')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label>{{ translate('valid before') }}</label>
                                    <div>
                                        <div class="input-group">
                                            <input type="text" name="valid_before" class="form-control" placeholder="yyyy/mm/dd" value="{{ old('valid_before') }}" id="valid_before">
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                            </div>
                                        </div>
                                        @error('valid_before')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label for=""></label>
                                    <input type="submit" value="{{ translate('create') }}" class="btn btn-success">
                                    <a href="{{ route('coupons.index') }}" class="btn btn-info">{{ translate('back to coupons') }}</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('footerScript')
    <script>
         $('#valid_before').datepicker({
            format: 'yyyy/mm/dd'
        });
    </script>
@endsection
