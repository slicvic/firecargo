<div class="ibox">
   <div class="ibox-content text-center">
        <h1>{{ Auth::user()->present()->fullname() }}</h1>
        <div id="photoContainer" class="m-b-sm">
            <img class="img-circle" src="{{ Auth::user()->getProfilePhotoURL('md') }}" style="width:200px;height:200px">
        </div>
        <button style="margin-top:4px;" type="button" id="btnEditPhoto" class="btn btn-block btn-link"><i class="fa fa-pencil"></i> Edit Photo</button>
        <div id="dzErrorMessage" class="text-danger"></div>
        <div class="list-group">
            <a href="/account/profile" class="{{ Request::is('account/profile') ? 'active ' : '' }}list-group-item btn btn-block btn-success">My Profile</a>
            <a href="/account/edit" class="{{ Request::is('account/edit') ? 'active ' : '' }}list-group-item btn btn-block btn-success">Edit Profile</a>
            <a href="/account/password" class="{{ Request::is('account/password') ? 'active ' : '' }}list-group-item btn btn-block btn-success">Change Password</a>
        </div>
    </div>
</div>
