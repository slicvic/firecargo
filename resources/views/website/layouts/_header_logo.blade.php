@if ($company && $company->has_logo)
    <p class="text-center">
        <img src="{{ $company->present()->logoUrl('sm') }}">
    </p>
@else
    <h1 class="text-center">{!! env('APP_HTML_LOGO') !!}</h1>
@endif
