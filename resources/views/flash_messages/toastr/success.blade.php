<script>
    $(function() {
        toastr.success("{!! $message !!}", "{{ trans('messages.success_message_title') }}")
    });
</script>
