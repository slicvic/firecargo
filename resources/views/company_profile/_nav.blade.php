<div class="ibox">
    <div class="ibox-content text-center">
        <h1>{{ "$company->name ($company->corp_code)" }}</h1>
        <div id="logoContainer" class="m-b-sm">
            <img class="img-circle" src="{{ $company->getLogoURL('md') }}" style="width:100px;height:100px">
        </div>
        <button type="button" id="btnEditLogo" class="btn btn-link btn-block"><i class="fa fa-pencil"></i> Edit Logo</button>
        <div id="dzErrorMessage" class="text-danger"></div>
        <div class="list-group">
            <a href="/company/edit-profile" class="btn btn-block btn-primary">Edit Company Profile</a>
        </div>
    </div>
</div>
