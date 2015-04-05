var app = {
	init: function() {
		this.initEvents();
	},

	initEvents: function() {
		var self = this;
		$('#createWarehouseForm').on('submit', self.submitCreateWarehouseForm);
	},

	submitCreateWarehouseForm: function() {
		event.preventDefault();
		var $form = $(this),
			$flashError = $(this).find('.flashError'),
			$submit = $(this).find('button');

		$submit.attr('disabled', true);
		$flashError.html('');

		$.post($form.attr('action'), $form.serialize(), function(data) {
			$submit.attr('disabled', false);
			console.log(data);
			if (data.status == 'ok') {
				window.location = data.redirect_to;
			} else {
				$flashError.html(data.message);
			}
		}, 'json');

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
