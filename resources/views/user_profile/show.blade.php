<div class="ibox">
   <div class="ibox-content">
        <h2>Personal Information</h2>
        <div class="row">
            <div class="col-xs-3"><strong>Email</strong></div>
            <div class="col-xs-9"><p>{{ $user->email }}</p></div>
        </div>
        <div class="row">
            <div class="col-xs-3"><strong>Mobile Phone</strong></div>
            <div class="col-xs-9"><p>{{ $user->mobile_phone }}</p></div>
        </div>
        <div class="row">
            <div class="col-xs-3"><strong>Other Phone</strong></div>
            <div class="col-xs-9"><p>{{ $user->phone }}</p></div>
        </div>
   </div>
</div>

<div class="ibox">
   <div class="ibox-content">
        <h2>Preferences</h2>
        <div class="row">
            <div class="col-xs-3"><strong>Auto-ship Packages?</strong></div>
            <div class="col-xs-9">
                <p>{!! $user->autoship_setting ? '<span class="label label-primary">Yes</span>' : '<span class="label label-danger">No</span>' !!}</p>
                @include('user_profile._alert_autoship_packages')
            </div>
        </div>
   </div>
</div>

<div class="ibox">
   <div class="ibox-content">
        <h2>Address</h2>
        <p>{!! $user->present()->address() !!}</p>
   </div>
</div>
