@extends('admin.user_profile.layout')

@section('user_profile_content')
<form action="/customer/profile/update" method="post" class="form-horizontal">
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
                            <input required type="text" name="firstname" class="form-control" required value="{{ Input::old('firstname', $account->firstname) }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">Last Name</label>
                        <div class="col-sm-5">
                            <input required type="text" name="lastname" class="form-control" required value="{{ Input::old('lastname', $account->lastname) }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">Email</label>
                        <div class="col-sm-6">
                            <input required type="email" name="email" class="form-control" required value="{{ Input::old('email', $account->email) }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">Phone</label>
                        <div class="col-sm-4">
                            <input type="text" name="phone" placeholder="Phone" required class="form-control" value="{{ Input::old('phone', $account->phone) }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">Mobile</label>
                        <div class="col-sm-4">
                            <input type="text" name="mobile_phone" placeholder="Mobile" class="form-control" value="{{ Input::old('mobile_phone', $account->mobile_phone) }}">
                        </div>
                    </div>
                    <h2>Address</h2>
                    <div class="clear hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">Address</label>
                        <div class="col-sm-6">
                            <input type="text" name="address1" placeholder="Address Line 1" required class="form-control" value="{{ Input::old('address1', $address->address1) }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2"></label>
                        <div class="col-sm-6">
                            <input type="text" name="address2" placeholder="Address Line 2" class="form-control" value="{{ Input::old('address2', $address->address2) }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">City</label>
                        <div class="col-sm-4">
                            <input type="text" name="city" placeholder="City" class="form-control" required value="{{ Input::old('city', $address->city) }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">State</label>
                        <div class="col-sm-4">
                            <input type="text" name="state" placeholder="State" class="form-control" required value="{{ Input::old('state', $address->state) }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">Postal Code</label>
                        <div class="col-sm-3">
                            <input type="text" name="postal_code" placeholder="Postal Code" class="form-control" value="{{ Input::old('postal_code', $address->postal_code) }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">Country</label>
                        <div class="col-sm-4">
                            @include('shared._country_select', ['name' => 'country_id', 'required' => TRUE, 'default' => Input::old('country_id', $address->country_id)])
                        </div>
                    </div>
                    <h2>Preferences</h2>
                    <div class="clear hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Auto-ship Packages?</label>
                        <div class="col-md-10">
                            <label class="checkbox-inline">
                                <input type="checkbox" class="icheck-green" name="autoship" value="1"{{ Input::old('autoship', $account->autoship) ? ' checked' : '' }}> Yes
                                @include('admin.user_profile.customers._autoship_alert')
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
