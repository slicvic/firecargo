@if ($level === 'success')
    <div class="alert alert-success">
        <i class="fa fa-check"></i> {!! $message !!}
    </div>
@elseif ($level === 'error')
    <div class="alert alert-danger">
        <h4><i class="fa fa-times-circle"></i> {{ trans('messages.flash_notification_title_error') }}</h4>
        {!! $message !!}
    </div>
@endif
