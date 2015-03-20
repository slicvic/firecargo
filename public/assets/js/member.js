var app = {
	init: function() {
		this.initEvents();
	},

	initEvents: function() {
		var self = this;
		// User events
		$('.ajax-view-user').on('click', self.user.view);
		//$('#edit-user-form').on('submit', self.user.save);
	},

	scrollTop: function() {
		$('html, body').scrollTop(0);
	}
};

app.modal = {
	scrollTop: function() {
		$('#modal').scrollTop(0);
	},

	show: function(html) {
		$('#modal-content').html(html);
		$('#modal').modal('show');
	},

	hide: function() {
		$('#modal').modal('hide');
	}
};

app.flash = {
	error: function(message, $container) {
		$container.html('<div class="alert alert-danger"><h4><i class="fa fa-exclamation-circle"></i> ' + message + '</h4></div>');
	},

	info: function(message, $container) {
		$container.html('<div class="alert alert-success"><h4><i class="fa fa-check"></i> ' + message + '</h4></div>');
	}
};

app.user = {
	save: function() {
		event.preventDefault();
		var $form = $(this),
			$flash = $form.find('.flash'),
			$submit = $form.find('button');

		$submit.attr('disabled', true);
		$flash.html(null);

		$.post($form.attr('action'), $form.serialize(), function(data) {
			$submit.attr('disabled', false);
			if (data.success) {
				app.flash.info('Success', $flash);
				window.location = data.redirect_to;
			}
			else {
				app.flash.error(data.error_message, $flash);
				app.scrollTop();
			}
		}, 'json');
	},

	view: function() {
		event.preventDefault();
		var $self = $(this);
		$.get($self.attr('href'), function(html) {
			app.modal.show(html);
		});
	}
}
