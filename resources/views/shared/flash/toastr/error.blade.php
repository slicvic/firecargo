<script>
    $(function() {
        toastr.error("{!! $message !!}", "{{ trans('messages.flash_error_title') }}", {timeOut: 60000})
    });
</script>
