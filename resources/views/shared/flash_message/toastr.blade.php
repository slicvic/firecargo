<script>
$(function() {

@if ($level === 'success')

    toastr.success("{!! $message !!}", "{{ trans('messages.flash_notification_title_success') }}");

@elseif ($level === 'error')

    toastr.error("{!! $message !!}", "{{ trans('messages.flash_notification_title_error') }}", {timeOut: 60000});

@endif

});
</script>
