@extends('layouts.auth.master')

@section('content')
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <h1 class="text-center">{!! env('APP_NAME_HTML') !!}</h1>
        {!! Flash::getBootstrap() !!}
    </div>
</div>
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="ibox-content">
            <h1 class="font-bold text-center">Register</h1>
            <div class="row">
                <div class="col-md-12">
                    <form action="/register" method="post" class="form-horizontal">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="affiliate_id" value="{{ Request::input('rid') }}">
                        <h3>Personal Information</h3>
                        <hr>
                        <div class="form-group">
                            <label class="control-label col-md-3">First Name *</label>
                            <div class="col-md-4">
                                <input type="text" name="firstname" class="form-control" value="{{ Input::old('firstname') }}" minlength="3" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Last Name *</label>
                            <div class="col-md-4">
                                <input type="text" name="lastname" class="form-control" value="{{ Input::old('lastname') }}" minlength="3" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Email *</label>
                            <div class="col-md-6">
                                <input type="email" name="email" class="form-control" value="{{ Input::old('email') }}" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Phone *</label>
                            <div class="col-md-4">
                                <input type="text" name="phone" class="form-control" value="{{ Input::old('phone') }}" minlength="7" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Password *</label>
                            <div class="col-md-4">
                                <input id="password" type="password" name="password" class="form-control" value="{{ Input::old('password') }}" minlength="8" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Confirm Password *</label>
                            <div class="col-md-4">
                                <input type="password" name="password_confirmation" class="form-control" value="{{ Input::old('password_confirmation') }}" equalto="#password" required>
                            </div>
                        </div>
                        <br>
                        <h3>Personal Information</h3>
                        <hr>
                        <div class="form-group">
                            <label class="control-label col-md-3">Address *</label>
                            <div class="col-md-6">
                                <input name="address1" class="form-control" value="{{ Input::old('address1') }}" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3"></label>
                            <div class="col-md-6">
                                <input name="address2" class="form-control" value="{{ Input::old('address2') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">City *</label>
                            <div class="col-md-3">
                                <input name="city" class="form-control" value="{{ Input::old('city') }}" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">State/Province/Region *</label>
                            <div class="col-md-3">
                                <input type="text" name="state" class="form-control" value="{{ Input::old('state') }}" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Postal Code</label>
                            <div class="col-md-3">
                                <input type="text" name="postal_code" class="form-control" value="{{ Input::old('postal_code') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Country</label>
                            <div class="col-md-3">
                                @include('countries._select', ['name' => 'country_id', 'required' => TRUE, 'default' => Input::old('country_id')])
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
                                        <input id="termscheck" name="terms_and_conditions" type="checkbox" required{{ Input::old('terms_and_conditions') ? ' checked' : ''}}> I have read and agree with the terms
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
