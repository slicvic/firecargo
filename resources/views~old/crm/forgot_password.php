<div id="forgot-password-box" class="panel panel-primary" style="display:none;">
	<div class="panel-heading">
		<h2>Recupere su Clave</h2>
	</div>
	<div class="panel-body">
		<form data-parsley-validate id="forgot-password-form" class="form-horizontal">
			<div class="flash"></div>
			<p>Para recuperar su clave ingrese el correo electrónico que utilizo al abrir su casillero y a vuelta de correo le enviaremos sus datos de acceso.</p>
			<div class="form-group">
				<div id="error-container3" class="col-sm-12">
					<div class="input-group">
						<div class="input-group-addon"><i class="fa fa-user"></i></div>
						<input type="email" name="email" class="form-control input-lg" placeholder="Correo Electrónico" data-parsley-errors-container="#error-container3" required>
					</div>					
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-12 text-right">
					<button type="submit" class="btn btn-lg btn-success">Recupear Clave</button>
					<a id="show-login-box" href="#"><?php echo Lang::get('messages.login'); ?></a>
				</div>
			</div>
		</form>
	</div>
</div>