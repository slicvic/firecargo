@extends('layouts.admin.page')

@section('icon', 'account')

@section('title')
    {{ $account->exists ? 'Edit Account # ' . $account->id : 'Create Account' }}
@stop

@section('subtitle')
<ol class="breadcrumb">
    <li>
        <a href="/accounts">Accounts</a>
    </li>
    <li class="active">
        <strong>{{ $account->exists ? 'Edit' : 'Create' }}</strong>
    </li>
</ol>
@stop

@section('page_content')
<form action="/accounts/{{ $account->exists ? 'update/' . $account->id : 'store' }}" method="post" class="form-horizontal">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="row">
        <div class="col-lg-12">
            <div class="tabs-container">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#tab-1" aria-expanded="true"> Account Detail</a></li>
                    <li class=""><a data-toggle="tab" href="#tab-3" aria-expanded="false"> Addresses</a></li>
                </ul>
                <div class="tab-content">
                    <div id="tab-1" class="tab-pane active">
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="control-label col-sm-2">Account Type *</label>
                                <div class="col-sm-3">
                                    <select required class="form-control" name="account[type_id]">
                                        @if ($account->isClient())
                                            <option value="{{ $account->type_id }}">{{ $account->type->name }}</option>
                                        @else
                                            <option value="">- Choose -</option>
                                            @foreach (\App\Models\AccountType::allExceptClient() as $type)
                                                <option{{ ($type->id == Input::old('account.type_id', $account->type_id)) ? ' selected' : '' }} value="{{ $type->id }}">{{ $type->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="clear hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="control-label col-sm-2">Name *</label>
                                <div class="col-sm-3">
                                    <input required type="text" name="account[name]" class="form-control" placeholder="Amazon, eBay, Leo Messi" value="{{ Input::old('account.name', $account->name) }}">
                                </div>
                            </div>
                            <div class="clear hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="control-label col-sm-2">Contact</label>
                                <div class="col-sm-3">
                                    <input type="text" name="account[firstname]" placeholder="First Name" class="form-control" value="{{ Input::old('account.firstname', $account->firstname) }}">
                                </div>
                                <div class="col-sm-3">
                                    <input type="text" name="account[lastname]" placeholder="Last Name" class="form-control" value="{{ Input::old('account.lastname', $account->lastname) }}">
                                </div>
                            </div>
                            <div class="clear hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="control-label col-sm-2">Email</label>
                                <div class="col-sm-5">
                                    <input type="email" name="account[email]" placeholder="Email" class="form-control" value="{{ Input::old('account.email', $account->email) }}">
                                </div>
                            </div>
                            <div class="clear hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="control-label col-sm-2">Phone</label>
                                <div class="col-sm-2">
                                    <input type="text" name="account[phone]" placeholder="Phone" class="form-control" value="{{ Input::old('account.phone', $account->phone) }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2">Fax</label>
                                <div class="col-sm-2">
                                    <input type="text" name="account[fax]" placeholder="Fax" class="form-control" value="{{ Input::old('account.fax', $account->fax) }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2">Mobile</label>
                                <div class="col-sm-2">
                                    <input type="text" name="account[mobile_phone]" placeholder="Mobile" class="form-control" value="{{ Input::old('account.mobile_phone', $account->mobile_phone) }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="tab-3" class="tab-pane">
                        <div class="panel-body">
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
                                    @include('countries._select', ['name' => 'address[country_id]', 'selected' => Input::old('address.country_id', $address->country_id)])
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="form-group">
        <div class="col-sm-12">
            <a class="btn btn-white" href="/accounts">Cancel</a>
            <button class="btn btn-primary" type="submit">Save changes</button>
        </div>
    </div>
</form>
@stop
