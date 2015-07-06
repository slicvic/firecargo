<form data-parsley-validate action="/company/profile" method="post" class="form-horizontal">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="ibox">
        <div class="ibox-content">
            <h2>General Infomation</h2>
            <div class="form-group">
                <label class="control-label col-sm-2">Company Name</label>
                <div class="col-sm-4">
                    <input required type="text" name="name" placeholder="Name" class="form-control" value="{{ Input::old('name', $company->name) }}">
                </div>
            </div>
        </div>
    </div>
    <div class="ibox">
        <div class="ibox-content">
            <h2>Contact Infomation</h2>
            <div class="form-group">
                <label class="control-label col-sm-2">Tel</label>
                <div class="col-sm-4">
                    <input type="text" name="phone" placeholder="Phone" class="form-control" value="{{ Input::old('phone', $company->phone) }}">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2">Fax</label>
                <div class="col-sm-4">
                    <input type="text" name="fax" placeholder="Fax" class="form-control" value="{{ Input::old('fax', $company->fax) }}">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2">Email</label>
                <div class="col-sm-5">
                    <input type="email" name="email" placeholder="Email" class="form-control" value="{{ Input::old('email', $company->email) }}">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2">Address 1</label>
                <div class="col-sm-5">
                    <input type="text" name="address1" placeholder="Address 1" class="form-control" value="{{ Input::old('address1', $company->address1) }}">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2">Address 2</label>
                <div class="col-sm-5">
                    <input type="text" name="address2" placeholder="Address 2" placeholder="Company" class="form-control" value="{{ Input::old('address2', $company->address2) }}">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2">City</label>
                <div class="col-sm-5">
                    <input type="text" name="city" placeholder="City" class="form-control" value="{{ Input::old('city', $company->city) }}">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2">State</label>
                <div class="col-sm-5">
                    <input type="text" name="state" placeholder="State" class="form-control" value="{{ Input::old('state', $company->state) }}">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2">Postal Code</label>
                <div class="col-sm-3">
                    <input type="text" name="postal_code" placeholder="Postal Code" class="form-control" value="{{ Input::old('postal_code', $company->postal_code) }}">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2">Country</label>
                <div class="col-sm-3">
                    <select name="country_id" class="form-control">
                        @foreach (\App\Models\Country::all() as $country)
                            <option{{ ($country->id == $company->country_id) ? ' selected' : '' }} value="{{ $country->id }}">{{ $country->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-12">
            <a class="btn btn-white" href="/company/profile">Cancel</a>
            <button class="btn btn-primary" type="submit">Save changes</button>
        </div>
    </div>
</form>
