var app = {
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
	},

	flashError: function(message, $container) {
		$container.html('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + message + '</div>');
	},

	flashInfo: function(message, $container) {
		$container.html('<div class="alert alert-success"><i class="fa fa-check"></i> ' + message + '</div>');
	},

	scrollTop: function() {
		$('html, body').scrollTop(0);
	}
}
