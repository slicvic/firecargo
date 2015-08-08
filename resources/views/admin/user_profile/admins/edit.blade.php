@extends('admin.user_profile.layout')

@section('user_profile_content')
<form action="/user/profile" method="post" class="form-horizontal">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="row">
        <div class="col-md-12">
            <div class="ibox">
                <div class="ibox-content">
                    <h2>Edit Profile</h2>
                    <div class="clear hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">First Name</label>
                        <div class="col-sm-4">
                            <input required type="text" name="firstname" placeholder="First Name" class="form-control" value="{{ Input::old('firstname', $currentUser->firstname) }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">Last Name</label>
                        <div class="col-sm-4">
                            <input required type="text" name="lastname" placeholder="Last Name" class="form-control" value="{{ Input::old('lastname', $currentUser->lastname) }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">Email</label>
                        <div class="col-sm-6">
                            <input required type="email" name="email" class="form-control" value="{{ Input::old('email', $currentUser->email) }}">
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
