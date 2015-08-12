<script>
    $(function() {
        toastr.success("{!! $message !!}", "{{ trans('messages.success_msg_title') }}")
    });
</script>
