@extends('layouts.guests')

@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h1>Registro Gratuito de Casillero</h1>
			</div>
			<div class="panel-body">
				<form data-parsley-validate action="/signup" method="post" class="form-horizontal">
					<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
					<fieldset>
						<legend>Tipo de Casillero</legend>
						<div class="form-group">
							<label class="col-md-2 control-label">Modalidad</label>
							<div class="col-md-10">
								<div class="radio">
									<label>
										<input type="radio" checked="checked">
										Personal (Factura a titulo personal)
									</label>
								</div>
								<div class="radio">
									<label>
										<input type="radio">
										Coorporativo (Factura a su Empresa Nit o RUT)
									</label>
								</div>
							</div>
						</div>
						<div class="form-group-inline">
							<label class="col-md-2 control-label">Tipo Identificación</label>
							<div class="col-md-2">
								<select class="form-control" name="user[id_type_id]">
									<option value="1">CC</option>
									<option value="2">NIT</option>
									<option value="3">RUT</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label">Identificación<span class="required-field">*</span></label>
							<div class="col-md-2">
								<input type="text" name="user[id_number]" class="form-control" value="<?php echo old('user.id_number'); ?>" required>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label">Nombre de la Empresa</label>
							<div class="col-md-6">
								<input type="text" name="user[business_name]" value="<?php echo old('user.business_name'); ?>" class="form-control">
							</div>
						</div>
					</fieldset>

					<fieldset>
						<legend>Información de Contacto</legend>
						<div class="form-group-inline">
							<label class="col-md-2 control-label">Nombres<span class="required-field">*</span></label>
							<div class="col-md-2">
								<input type="text" name="user[firstname]" class="form-control" value="<?php echo old('user.firstname'); ?>" required>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label">Apellidos<span class="required-field">*</span></label>
							<div class="col-md-2">
								<input type="text" name="user[lastname]" class="form-control" value="<?php echo old('user.lastname'); ?>" required>
							</div>
						</div>
						<div class="form-group-inline">
							<label class="col-md-2 control-label">Teléfono Fijo</label>
							<div class="col-md-2">
								<input type="text" name="user[phone]" class="form-control" value="<?php echo old('user.phone'); ?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label">Teléfono Celular<span class="required-field">*</span></label>
							<div class="col-md-2">
								<input type="text" name="user[cellphone]" class="form-control" value="<?php echo old('user.cellphone'); ?>" required>
							</div>
						</div>
					</fieldset>

					<fieldset>
						<legend>Información de Acceso</legend>
						<div class="form-group">
							<label class="col-md-2 control-label">Correo Electrónico<span class="required-field">*</span></label>
							<div class="col-md-6">
								<input type="text" name="user[email]" class="form-control" value="<?php echo old('user.email'); ?>" required>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label"><?php echo trans('messages.password'); ?><span class="required-field">*</span></label>
							<div class="col-md-6">
								<input id="password" type="password" name="user[password]" class="form-control" value="<?php echo old('user.password'); ?>" data-parsley-minlength="6" required>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label"><?php echo trans('messages.password_confirm'); ?><span class="required-field">*</span></label>
							<div class="col-md-6">
								<input type="password" name="password_confirm" class="form-control" value="<?php echo old('password_confirm'); ?>" data-parsley-equalto="#password" required>
							</div>
						</div>
					</fieldset>

					<fieldset>
						<legend>Dirección de Entrega</legend>
						<div class="form-group">
							<label class="col-md-2 control-label">Departamento<span class="required-field">*</span></label>
							<div class="col-md-6">
								<input name="user[state]" class="form-control" value="<?php echo old('user.state'); ?>" required>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label">Ciudad<span class="required-field">*</span></label>
							<div class="col-md-6">
								<input name="user[city]" class="form-control" value="<?php echo old('user.city'); ?>" required>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label">Dirección<span class="required-field">*</span></label>
							<div class="col-md-6">
								<input type="text" name="user[address1]" class="form-control" value="<?php echo old('user.address1'); ?>" required>
							</div>
						</div>
					</fieldset>

					<fieldset>
						<legend>Términos y condiciones</legend>
						<div class="form-group">
							<div class="col-md-8">
								<textarea class="form-control" rows="7"></textarea>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-12">
								<div class="checkbox">
									<label>
										<input id="termscheck" type="checkbox" required> Acepto
									</label>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-12">
								<button type="submit" class="btn btn-lg btn-success">Enviar</button>
							</div>
						</div>
					</fieldset>
				</form>
			</div>
		</div>
	</div>
</div>
@stop
