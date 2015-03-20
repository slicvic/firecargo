var app = {
	init: function() {
		this.initEvents();
	},

	initEvents: function() {
		var self = this;
		//$('#login-form').on('submit', self.submitLoginForm);
		//$('#signup-form').on('submit', self.submitSignupForm);
		//$('#forgot-password-form').on('submit', self.submitForgotPasswordForm);
		//$('#reset-password-form').on('submit', self.submitPasswordResetForm);
		$('#change-email-form').on('submit', self.submitChangeEmailForm);
		$('#change-password-form').on('submit', self.submitChangePasswordForm);
		$('#update-profile-form').on('submit', self.subtmitUpdateProfileForm);

		/*
		$('#show-forgot-password-box').click(function() {
			event.preventDefault();
			$('#login-box').hide();
			$('#forgot-password-box').show();
		});

		$('#show-login-box').click(function() {
			event.preventDefault();
			$('#forgot-password-box').hide();
			$('#login-box').show();
		});
*		*/
	},

	submitLoginForm: function() {
		event.preventDefault();
		var $form = $(this),
			$flash = $(this).find('.flash'),
			$submit = $(this).find('button');

		$submit.attr('disabled', true);
		$flash.html(null);

		$.post('/dologin', $form.serialize(), function(data) {
			$submit.attr('disabled', false);
			if (data.success) {
				window.location = data.redirect_to;
			} else {
				app.flashError(data.error_message, $flash);
			}
		}, 'json');

	},

	submitForgotPasswordForm: function() {
		event.preventDefault();
		var $form = $(this),
			$flash = $(this).find('.flash'),
			$submit = $(this).find('button');

		$submit.attr('disabled', true);
		$flash.html(null);

		$.post('/forgot-password', $form.serialize(), function(data) {
			$submit.attr('disabled', false);
			if (data.success) {
				app.flashInfo(data.message, $flash);
			} else {
				app.flashError(data.error_message, $flash);
			}
		}, 'json');
	},

	submitPasswordResetForm: function() {
		event.preventDefault();
		var $form = $(this),
			$flash = $(this).find('.flash'),
			$submit = $(this).find('button');

		$submit.attr('disabled', true);
		$flash.html(null);

		$.post($form.attr('action'), $form.serialize(), function(data) {
			$submit.attr('disabled', false);
			if (data.success) {
				app.flashInfo(data.message, $flash);
				$form[0].reset();
			} else {
				app.flashError(data.error_message, $flash);
			}
		}, 'json');
	},

	submitSignupForm: function() {
		event.preventDefault();
		var $form = $(this),
			$flash = $('.flash'),
			$submit = $(this).find('button');

		//$submit.attr('disabled', true);
		$flash.html(null);

		$.post('/signup', $form.serialize(), function(data) {
			$submit.attr('disabled', false);
			if (data.success) {
				window.location = data.redirect_to;
			} else {
				app.flashError(data.error_message, $flash);
				app.scrollTop();
			}
		}, 'json');
	},

	submitChangeEmailForm: function() {
		event.preventDefault();
		var $form = $(this),
			$flash = $('.flash'),
			$submit = $(this).find('button');

		$submit.attr('disabled', true);
		$flash.html(null);

		$.post('/user/change-email', $form.serialize(), function(data) {
			$submit.attr('disabled', false);
			if (data.success) {
				app.flashInfo(data.message, $flash);
				$form[0].reset();
			} else {
				app.flashError(data.error_message, $flash);
			}
		}, 'json');
	},

	submitChangePasswordForm: function() {
		event.preventDefault();
		var $form = $(this),
			$flash = $('.flash'),
			$submit = $(this).find('button');

		$submit.attr('disabled', true);
		$flash.html(null);

		$.post('/user/change-password', $form.serialize(), function(data) {
			$submit.attr('disabled', false);
			if (data.success) {
				app.flashInfo(data.message, $flash);
				$form[0].reset();
			} else {
				app.flashError(data.error_message, $flash);
			}
		}, 'json');
	},

	subtmitUpdateProfileForm: function() {
		event.preventDefault();
		var $form = $(this),
			$flash = $('.flash'),
			$submit = $(this).find('button');

		$submit.attr('disabled', true);
		$flash.html(null);

		$.post('/user/update-profile', $form.serialize(), function(data) {
			$submit.attr('disabled', false);
			if (data.success) {
				app.flashInfo(data.message, $flash);
				app.scrollTop();
			} else {
				app.flashError(data.error_message, $flash);
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
