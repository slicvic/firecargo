<script>
    $(function() {
        toastr.error("{!! $message !!}", "{{ trans('messages.error_message_title') }}", {timeOut: 60000})
    });
</script>
