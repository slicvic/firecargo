@extends('admin.layouts.pages.company_profile')

@section('company_profile_content')
<form action="/company/profile" method="post" class="form-horizontal">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="ibox">
        <div class="ibox-content">
            <h2>Company Info</h2>
            <div class="clear hr-line-dashed"></div>
            <div class="form-group">
                <label class="control-label col-sm-2">Name</label>
                <div class="col-sm-4">
                    <input required type="text" name="company[name]" placeholder="e.g. Coca Cola" class="form-control" value="{{ Input::old('company.name', $company->name) }}">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2">Tel</label>
                <div class="col-sm-4">
                    <input type="text" name="company[phone]" placeholder="Tel" class="form-control" value="{{ Input::old('company.phone', $company->phone) }}">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2">Fax</label>
                <div class="col-sm-4">
                    <input type="text" name="company[fax]" placeholder="Fax" class="form-control" value="{{ Input::old('company.fax', $company->fax) }}">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2">Email</label>
                <div class="col-sm-5">
                    <input type="email" name="company[email]" placeholder="Email" class="form-control" value="{{ Input::old('company.email', $company->email) }}">
                </div>
            </div>
            <h2>Address</h2>
            <div class="clear hr-line-dashed"></div>
            <div class="form-group">
                <label class="control-label col-sm-2">Address</label>
                <div class="col-sm-5">
                    <input type="text" name="address[address1]" placeholder="Address Line 1" class="form-control" value="{{ Input::old('address.address1', $address->address1) }}">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2"></label>
                <div class="col-sm-5">
                    <input type="text" name="address[address2]" placeholder="Address Line 2" placeholder="Company" class="form-control" value="{{ Input::old('address.address2', $address->address2) }}">
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
                <div class="col-sm-3">
                    <input type="text" name="address[postal_code]" placeholder="Postal Code" class="form-control" value="{{ Input::old('address.postal_code', $address->postal_code) }}">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2">Country</label>
                <div class="col-sm-4">
                    @include('shared._country_select', ['name' => 'address[country_id]', 'required' => FALSE, 'default' => Input::old('address.country_id', $address->country_id)])
                </div>
            </div>
            <div class="clear hr-line-dashed"></div>
            <div class="form-group">
                <div class="col-sm-4 col-sm-offset-2">
                    <a class="btn btn-white" href="/company/profile">Cancel</a>
                    <button class="btn btn-primary" type="submit">Save changes</button>
                </div>
            </div>
        </div>
    </div>
</form>
@stop
