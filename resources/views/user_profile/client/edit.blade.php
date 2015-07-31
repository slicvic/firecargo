@extends('user_profile.layout')

@section('user_profile_content')
<form action="/user/profile" method="post" class="form-horizontal">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="row">
        <div class="col-md-12">
            <div class="ibox">
                <div class="ibox-content">
                    <h2>Account Info</h2>
                    <div class="clear hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">First Name</label>
                        <div class="col-sm-5">
                            <input required type="text" name="account[firstname]" class="form-control" value="{{ Input::old('account.firstname', $account->firstname) }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">Last Name</label>
                        <div class="col-sm-5">
                            <input required type="text" name="account[lastname]" class="form-control" value="{{ Input::old('account.lastname', $account->lastname) }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">Email</label>
                        <div class="col-sm-5">
                            <input required type="email" name="account[email]" class="form-control" value="{{ Input::old('account.email', $account->email) }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">Phone</label>
                        <div class="col-sm-4">
                            <input type="text" name="account[phone]" placeholder="Phone" class="form-control" value="{{ Input::old('account.phone', $account->phone) }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">Mobile</label>
                        <div class="col-sm-4">
                            <input type="text" name="account[mobile_phone]" placeholder="Mobile" class="form-control" value="{{ Input::old('account.mobile_phone', $account->mobile_phone) }}">
                        </div>
                    </div>
                    <h2>Address</h2>
                    <div class="clear hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">Address 1</label>
                        <div class="col-sm-5">
                            <input type="text" name="address[address1]" placeholder="Address 1" class="form-control" value="{{ Input::old('address.address1', $address->address1) }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">Address 2</label>
                        <div class="col-sm-5">
                            <input type="text" name="address[address2]" placeholder="Address 2" class="form-control" value="{{ Input::old('address.address2', $address->address2) }}">
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
                        <div class="col-sm-3">
                            @include('countries._select', ['name' => 'address[country_id]', 'selectedOption' => Input::old('address.country_id', $address->country_id)])
                        </div>
                    </div>
                    <h2>Preferences</h2>
                    <div class="clear hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Auto-ship Packages?</label>
                        <div class="col-md-10">
                            <label class="checkbox-inline">
                                <input type="checkbox" class="icheck-green" name="account[autoship]" value="1"{{ Input::old('account.autoship', $account->autoship) ? ' checked' : '' }}> Yes
                                @include('user_profile.client._autoship_alert')
                            </label>
                        </div>
                    </div>
                    <div class="clear hr-line-dashed"></div>
                    <div class="form-group">
                        <div class="col-sm-4 col-sm-offset-2">
                            <a class="btn btn-white" href="/user/profile">Cancel</a>
                            <button class="btn btn-primary" type="submit">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@stop
