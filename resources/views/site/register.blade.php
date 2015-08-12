@extends('site.layouts.wide')

@section('wide_content')
<div class="row">
    <div class="col-md-12">
        <div class="ibox-content">
            <h1 class="font-bold text-center">Register</h1>
            <div class="row">
                <div class="col-md-12">
                    <form action="/register" method="post" class="form-horizontal">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="registration_code" value="{{ Request::input('reg') }}">
                        <h3>Contact Information</h3>
                        <hr>
                        <div class="form-group">
                            <label class="control-label col-md-3">First Name *</label>
                            <div class="col-md-5">
                                <input type="text" name="firstname" class="form-control" value="{{ old('firstname') }}" minlength="3" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Last Name *</label>
                            <div class="col-md-5">
                                <input type="text" name="lastname" class="form-control" value="{{ old('lastname') }}" minlength="3" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Phone *</label>
                            <div class="col-md-4">
                                <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Mobile Phone</label>
                            <div class="col-md-4">
                                <input type="text" name="mobile_phone" class="form-control" value="{{ old('mobile_phone') }}">
                            </div>
                        </div>
                        <br>
                        <h3>Login Information</h3>
                        <hr>
                        <div class="form-group">
                            <label class="control-label col-md-3">Email *</label>
                            <div class="col-md-7">
                                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Password *</label>
                            <div class="col-md-4">
                                <input id="password" type="password" name="password" class="form-control" value="{{ old('password') }}" minlength="8" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Confirm <br> Password *</label>
                            <div class="col-md-4">
                                <input type="password" name="password_confirmation" class="form-control" value="{{ old('password_confirmation') }}" equalto="#password" required>
                            </div>
                        </div>
                        <br>
                        <h3>Delivery Address</h3>
                        <hr>
                        <div class="form-group">
                            <label class="control-label col-md-3">Address *</label>
                            <div class="col-md-7">
                                <input name="address1" class="form-control" value="{{ old('address1') }}" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3"></label>
                            <div class="col-md-7">
                                <input name="address2" class="form-control" value="{{ old('address2') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">City *</label>
                            <div class="col-md-5">
                                <input name="city" class="form-control" value="{{ old('city') }}" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">State *</label>
                            <div class="col-md-5">
                                <input type="text" name="state" class="form-control" value="{{ old('state') }}" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Postal Code</label>
                            <div class="col-md-3">
                                <input type="text" name="postal_code" class="form-control" value="{{ old('postal_code') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Country</label>
                            <div class="col-md-5">
                                @include('shared._country_select', ['name' => 'country_id', 'required' => TRUE, 'default' => old('country_id')])
                            </div>
                        </div>
                        <br>
                        <h3>Terms & Conditions</h3>
                        <hr>
                        <div class="form-group">
                            <div class="col-md-12">
                                <textarea class="form-control" rows="7"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <div class="checkbox">
                                    <label>
                                        <input id="termscheck" name="terms_and_conditions" type="checkbox" required{{ old('terms_and_conditions') ? ' checked' : ''}}> I have read and agree with the terms
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-lg btn-block btn-primary">Register</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
