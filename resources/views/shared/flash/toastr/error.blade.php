<script>
    $(function() {
        toastr.error("{!! $message !!}", "{{ trans('messages.error_msg_title') }}", {timeOut: 60000})
    });
</script>
