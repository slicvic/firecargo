@extends('layouts.admin.page')

@section('title')
    {{ $account->exists ? 'Edit Shipper # ' . $account->id : 'Add New Shipper' }}
@stop

@section('subtitle')
<ol class="breadcrumb">
    <li>
        <a href="/shippers">Shippers</a>
    </li>
    <li class="active">
        <strong>{{ $account->exists ? 'Edit' : 'Create' }}</strong>
    </li>
</ol>
@stop

@section('page_content')
<form action="/shipper/{{ $account->exists ? $account->id . '/update' : 'store' }}" method="post" class="form-horizontal">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">
                    <h3>Account Info</h3>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">Name *</label>
                        <div class="col-sm-4">
                            <input required type="text" name="name" placeholder="e.g. Amazon, eBay" class="form-control" value="{{ Input::old('name', $account->name) }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">Address</label>
                        <div class="col-sm-5">
                            <input type="text" name="address1" placeholder="Address Line 1" class="form-control" value="{{ Input::old('address1', $address->address1) }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2"></label>
                        <div class="col-sm-5">
                            <input type="text" name="address2" placeholder="Address Line 2" placeholder="Company" class="form-control" value="{{ Input::old('address2', $address->address2) }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">City</label>
                        <div class="col-sm-5">
                            <input type="text" name="city" placeholder="City" class="form-control" value="{{ Input::old('city', $address->city) }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">State</label>
                        <div class="col-sm-5">
                            <input type="text" name="state" placeholder="State" class="form-control" value="{{ Input::old('state', $address->state) }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">Postal Code</label>
                        <div class="col-sm-2">
                            <input type="text" name="postal_code" placeholder="Postal Code" class="form-control" value="{{ Input::old('postal_code', $address->postal_code) }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">Country</label>
                        <div class="col-sm-3">
                            @include('countries._select', ['name' => 'country_id', 'required' => FALSE, 'default' => Input::old('country_id', $address->country_id)])
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <div class="col-sm-4 col-sm-offset-2">
                            <a class="btn btn-white" href="/shippers">Cancel</a>
                            <button class="btn btn-primary" type="submit">Save Shipper</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@stop
