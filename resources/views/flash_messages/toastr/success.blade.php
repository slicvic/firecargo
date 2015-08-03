<script>
    $(function() {
        toastr.success("{!! $message !!}", "{{ trans('messages.flash_success_title') }}")
    });
</script>
