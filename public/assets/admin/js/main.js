var main = {
	init: function() {
		this.initEvents();
	},

	initEvents: function() {
		$('table').on('click', '.btn-delete', function() {
		    if (!confirm('Are you sure you want to delete this item?')) {
	            event.preventDefault();
	            return false;
		    }
		});

		$('input[type=checkbox]').iCheck({
			checkboxClass: 'icheckbox_square-green',
			radioClass: 'iradio_square-green',
		});
	}
}

$(function() {
	main.init();
});
