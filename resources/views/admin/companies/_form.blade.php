<div class="iibox">
    <div class="iibox-content">
        <form action="/company/{{ $action }}" method="post" class="form-horizontal">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group">
                <label class="control-label col-sm-2">Name *</label>
                <div class="col-sm-6">
                    <input type="text" name="name" placeholder="Company Name" class="form-control" required value="{{ Input::old('name', $company->name) }}">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2">Primary Contact *</label>
                <div class="col-sm-3">
                    <input type="text" name="firstname" placeholder="First Name" class="form-control" required value="{{ Input::old('firstname', $company->firstname) }}">
                </div>
                <div class="col-sm-3">
                    <input type="text" name="lastname" placeholder="Last Name" class="form-control" required value="{{ Input::old('lastname', $company->lastname) }}">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2">Email *</label>
                <div class="col-sm-4">
                    <input type="email" name="email" placeholder="Email" class="form-control" required value="{{ Input::old('email', $company->email) }}">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2">Phone *</label>
                <div class="col-sm-3">
                    <input type="text" name="phone" placeholder="Phone" class="form-control" required value="{{ Input::old('phone', $company->phone) }}">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-4 col-sm-offset-2">
                    <a class="btn btn-white" href="/companies">Cancel</a>
                    <button class="btn btn-primary" type="submit">Save Company</button>
                </div>
            </div>
        </form>
    </div>
</div>
