@extends('user_profile.layout')

@section('user_profile_content')
<form action="/account/profile" method="post" class="form-horizontal">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="row">
        <div class="col-md-12">
            <div class="ibox">
                <div class="ibox-content">
                    <h2>Personal Information</h2>
                    <div class="form-group">
                        <label class="control-label col-sm-2">Name</label>
                        <div class="col-sm-5">
                            <input required type="text" name="user[full_name]" class="form-control" value="{{ Input::old('user.full_name', $user->full_name) }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">Email</label>
                        <div class="col-sm-5">
                            <input required type="email" name="user[email]" class="form-control" value="{{ Input::old('user.email', $user->email) }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">Mobile Phone</label>
                        <div class="col-sm-4">
                            <input type="text" name="user[mobile_phone]" placeholder="Mobile Phone" class="form-control" value="{{ Input::old('user.mobile_phone', $user->mobile_phone) }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">Other Phone</label>
                        <div class="col-sm-4">
                            <input type="text" name="user[phone]" placeholder="Home Phone" class="form-control" value="{{ Input::old('user.phone', $user->phone) }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="ibox">
                <div class="ibox-content">
                    <h2>Preferences</h2>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Auto-ship Packages?</label>
                        <div class="col-md-10">
                            <label class="checkbox-inline">
                                <input type="checkbox" name="user[autoship_setting]" value="1"{{ Input::old('user.autoship_setting', $user->autoship_setting) ? ' checked' : '' }}> Yes
                                @include('user_profile._autoship_notice')
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="ibox">
                <div class="ibox-content">
                    <h2>Address</h2>
                    <div class="form-group">
                        <label class="control-label col-sm-2">Address</label>
                        <div class="col-sm-5">
                            <input type="text" name="address[address1]" placeholder="Address" class="form-control" value="{{ Input::old('address.address1', $address->address1) }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">Apt / Unit</label>
                        <div class="col-sm-5">
                            <input type="text" name="address[address2]" placeholder="Apt / Unit" placeholder="Company" class="form-control" value="{{ Input::old('address.address2', $address->address2) }}">
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
                            @include('countries._select', ['name' => 'address[country_id]', 'selected' => Input::old('address.country_id', $address->country_id)])
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-12">
            <a class="btn btn-white" href="/account/profile">Cancel</a>
            <button class="btn btn-primary" type="submit">Save changes</button>
        </div>
    </div>
</form>
@stop
