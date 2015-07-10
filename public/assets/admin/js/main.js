var main = {
	init: function() {
		this.initEvents();
	},

	initEvents: function() {
		// Bind table delete button
		$('table').on('click', '.btn-delete', function() {
		    if (!confirm('Are you sure you want to delete this item?')) {
	            event.preventDefault();
	            return false;
		    }
		});

		// Bind date picker
		$('.date').datepicker({
		    //todayBtn: 'linked',
		    keyboardNavigation: false,
		    forceParse: false,
		    calendarWeeks: true,
		    autoclose: true
		});

		// Bind iChecks
		$('input[type=checkbox]').iCheck({
			checkboxClass: 'icheckbox_square-green',
			radioClass: 'iradio_square-green',
		});
	}
}

$(function() {
	main.init();
});
