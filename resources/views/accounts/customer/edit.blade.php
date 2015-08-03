@extends('layouts.admin.page')

@section('title')
    {{ $account->exists ? 'Edit Customer # ' . $account->id : 'Add New Customer' }}
@stop

@section('subtitle')
<ol class="breadcrumb">
    <li>
        <a href="/customers">Customers</a>
    </li>
    <li class="active">
        <strong>{{ $account->exists ? 'Edit' : 'Create' }}</strong>
    </li>
</ol>
@stop

@section('page_content')
<form action="/customer/{{ $account->exists ? $account->id . '/update' : 'store' }}" method="post" class="form-horizontal">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">
                    <h3>Account Info</h3>
                    <div class="hr-line-dashed"></div>
                      <div class="form-group">
                        <label class="control-label col-sm-2">Name *</label>
                        <div class="col-sm-3">
                            <input required type="text" name="account[name]" class="form-control" placeholder="Name" value="{{ Input::old('account.name', $account->name) }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">Contact</label>
                        <div class="col-sm-3">
                            <input type="text" name="account[firstname]" placeholder="First Name" class="form-control" value="{{ Input::old('account.firstname', $account->firstname) }}">
                        </div>
                        <div class="col-sm-3">
                            <input type="text" name="account[lastname]" placeholder="Last Name" class="form-control" value="{{ Input::old('account.lastname', $account->lastname) }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">Email</label>
                        <div class="col-sm-6">
                            <input type="email" name="account[email]" placeholder="Email" class="form-control" value="{{ Input::old('account.email', $account->email) }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">Phone</label>
                        <div class="col-sm-3">
                            <input type="text" name="account[phone]" placeholder="Phone" class="form-control" value="{{ Input::old('account.phone', $account->phone) }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">Fax</label>
                        <div class="col-sm-3">
                            <input type="text" name="account[fax]" placeholder="Fax" class="form-control" value="{{ Input::old('account.fax', $account->fax) }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">Mobile</label>
                        <div class="col-sm-3">
                            <input type="text" name="account[mobile_phone]" placeholder="Mobile" class="form-control" value="{{ Input::old('account.mobile_phone', $account->mobile_phone) }}">
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
                            <a class="btn btn-white" href="/customers">Cancel</a>
                            <button class="btn btn-primary" type="submit">Save Customer</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@stop
