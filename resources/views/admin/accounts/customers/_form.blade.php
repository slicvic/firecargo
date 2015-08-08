<form action="/accounts/customer/{{ $action }}" method="post" class="form-horizontal">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">
                    <h3>General Information</h3>
                    <div class="hr-line-dashed"></div>
                      <div class="form-group">
                        <label class="control-label col-sm-2">Name *</label>
                        <div class="col-sm-4">
                            <input type="text" name="name" class="form-control" placeholder="Name" required value="{{ Input::old('name', $account->name) }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">Email</label>
                        <div class="col-sm-4">
                            <input type="email" name="email" placeholder="Email Address" class="form-control" value="{{ Input::old('email', $account->email) }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">Phone</label>
                        <div class="col-sm-3">
                            <input type="text" name="phone" placeholder="Phone" class="form-control" value="{{ Input::old('phone', $account->phone) }}">
                        </div>
                    </div>
                   <div class="form-group">
                        <label class="control-label col-sm-2">Mobile</label>
                        <div class="col-sm-3">
                            <input type="text" name="mobile_phone" placeholder="Mobile" class="form-control" value="{{ Input::old('mobile_phone', $account->mobile_phone) }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">Fax</label>
                        <div class="col-sm-3">
                            <input type="text" name="fax" placeholder="Fax" class="form-control" value="{{ Input::old('fax', $account->fax) }}">
                        </div>
                    </div>
                    <h3>Shipping Address</h3>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">Address *</label>
                        <div class="col-sm-5">
                            <input type="text" name="address1" placeholder="Address Line 1" class="form-control" required value="{{ Input::old('address1', $address->address1) }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2"></label>
                        <div class="col-sm-5">
                            <input type="text" name="address2" placeholder="Address Line 2" placeholder="Company" class="form-control" value="{{ Input::old('address2', $address->address2) }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">City *</label>
                        <div class="col-sm-3">
                            <input type="text" name="city" placeholder="City" class="form-control" required value="{{ Input::old('city', $address->city) }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">State *</label>
                        <div class="col-sm-3">
                            <input type="text" name="state" placeholder="State" class="form-control" required value="{{ Input::old('state', $address->state) }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">Postal Code</label>
                        <div class="col-sm-2">
                            <input type="text" name="postal_code" placeholder="Postal Code" class="form-control" value="{{ Input::old('postal_code', $address->postal_code) }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">Country *</label>
                        <div class="col-sm-3">
                            @include('shared._country_select', ['name' => 'country_id', 'required' => TRUE, 'default' => Input::old('country_id', $address->country_id)])
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <div class="col-sm-4 col-sm-offset-2">
                            <a class="btn btn-white" href="/accounts/customers">Cancel</a>
                            <button class="btn btn-primary" type="submit">Save Customer</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
