@extends('layouts.admin.page')

@section('icon', 'shipper')

@section('title')
    {{ $account->exists ? 'Edit Shipper # ' . $account->id : 'Add New Shipper' }}
@stop

@section('subtitle')
<ol class="breadcrumb">
    <li>
        <a href="/shippers">Shippers</a>
    </li>
    <li class="active">
        <strong>{{ $account->exists ? 'Edit Shipper' : 'Add New Shipper' }}</strong>
    </li>
</ol>
@stop

@section('page_content')
<form action="/shippers/{{ $account->exists ? 'update/' . $account->id : 'store' }}" method="post" class="form-horizontal">
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
                            <input required type="text" name="account[name]" placeholder="e.g. Amazon, eBay" class="form-control" value="{{ Input::old('account.name', $account->name) }}">
                        </div>
                    </div>
                    <h3>Address</h3>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">Address 1</label>
                        <div class="col-sm-5">
                            <input type="text" name="address[address1]" placeholder="Address 1" class="form-control" value="{{ Input::old('address.address1', $address->address1) }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">Address 2</label>
                        <div class="col-sm-5">
                            <input type="text" name="address[address2]" placeholder="Address 2" placeholder="Company" class="form-control" value="{{ Input::old('address.address2', $address->address2) }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">City</label>
                        <div class="col-sm-5">
                            <input type="text" name="address[city]" placeholder="City" class="form-control" value="{{ Input::old('address.city', $address->city) }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">State</label>
                        <div class="col-sm-5">
                            <input type="text" name="address[state]" placeholder="State" class="form-control" value="{{ Input::old('address.state', $address->state) }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">Postal Code</label>
                        <div class="col-sm-2">
                            <input type="text" name="address[postal_code]" placeholder="Postal Code" class="form-control" value="{{ Input::old('address.postal_code', $address->postal_code) }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">Country</label>
                        <div class="col-sm-3">
                            @include('countries._select', ['name' => 'address[country_id]', 'selectedOption' => Input::old('address.country_id', $address->country_id)])
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