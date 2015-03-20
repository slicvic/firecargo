<?php $user = Auth::user(); ?>
<form data-parsley-validate id="update-profile-form" class="form-horizontal">
	<div id="flash"></div>
	<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
	<fieldset>
		<legend>Tipo de Casillero</legend>
		<div class="form-group">
			<label class="col-md-2 control-label">Modalidad</label>
			<div class="col-md-10">
				<div class="radio">
					<label>
						<input type="radio" value="1">
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
					<option value="1"<?php echo ($user->id_type_id == UserIdType::CC ? ' selected' : ''); ?>>CC</option>
					<option value="2"<?php echo ($user->id_type_id == UserIdType::NIT ? ' selected' : ''); ?>>NIT</option>
					<option value="3"<?php echo ($user->id_type_id == UserIdType::RUT ? ' selected' : ''); ?>>RUT</option>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-2 control-label">Identificación</label>
			<div class="col-md-2">
				<input type="text" name="user[id_number]" class="form-control" value="<?php echo $user->id_number; ?>">
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-2 control-label">Nombre de la Empresa</label>
			<div class="col-md-6">
				<input type="text" name="user[company]" class="form-control" value="<?php echo $user->company; ?>">
			</div>
		</div>
	</fieldset>

	<fieldset>
		<legend>Información de Contacto</legend>
		<div class="form-group-inline">
			<label class="col-md-2 control-label">Nombres</label>
			<div class="col-md-2">
				<input type="text" name="user[firstname]" class="form-control" value="<?php echo $user->firstname; ?>" required>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-2 control-label">Apellidos</label>
			<div class="col-md-2">
				<input type="text" name="user[lastname]" class="form-control" value="<?php echo $user->lastname; ?>" required>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-2 control-label">Sexo</label>
			<div class="col-md-2">
				<select class="form-control" name="user[gender_id]">
					<option value="1"<?php echo ($user->gender_id == Gender::MALE ? ' selected' : ''); ?>>Masculino</option>
					<option value="2"<?php echo ($user->gender_id == Gender::FEMALE ? ' selected' : ''); ?>>Femenino</option>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-2 control-label">Fecha nacimiento</label>
			<div class="col-md-2">
				<select class="form-control" name="user[dob][year]" required>
					<option value="">Año</option>
					<?php
					list($dob_year, $dob_month, $dob_day) = explode('-', $user->dob);
					for($i=1915; $i<=date('Y'); $i++): ?>
						<option value="<?php echo $i; ?>"<?php echo ($dob_year == $i ? ' selected' : ''); ?>><?php echo $i; ?></option>
					<?php endfor; ?>
				</select>
			</div>
			<div class="col-md-2">
				<select class="form-control" name="user[dob][month]" required>
					<option value="">Mes</option>
					<option value="01"<?php echo ($dob_month == '01' ? ' selected' : ''); ?>>Enero</option>
					<option value="02"<?php echo ($dob_month == '02' ? ' selected' : ''); ?>>Febrero</option>
					<option value="03"<?php echo ($dob_month == '03' ? ' selected' : ''); ?>>Marzo</option>
					<option value="04"<?php echo ($dob_month == '04' ? ' selected' : ''); ?>>Abril</option>
					<option value="05"<?php echo ($dob_month == '05' ? ' selected' : ''); ?>>Mayo</option>
					<option value="06"<?php echo ($dob_month == '06' ? ' selected' : ''); ?>>Junio</option>
					<option value="07"<?php echo ($dob_month == '07' ? ' selected' : ''); ?>>Julio</option>
					<option value="08"<?php echo ($dob_month == '08' ? ' selected' : ''); ?>>Agosto</option>
					<option value="09"<?php echo ($dob_month == '09' ? ' selected' : ''); ?>>Septiembre</option>
					<option value="10"<?php echo ($dob_month == '10' ? ' selected' : ''); ?>>Octubre</option>
					<option value="11"<?php echo ($dob_month == '11' ? ' selected' : ''); ?>>Noviembre</option>
					<option value="12"<?php echo ($dob_month == '12' ? ' selected' : ''); ?>>Diciembre</option>
				</select>
			</div>
			<div class="col-md-2">
				<select class="form-control" name="user[dob][day]" required>
					<?php for($i = 1; $i <= 31; $i++): ?>
						<option value="<?php echo $i; ?>"<?php echo ($dob_day == $i ? ' selected' : ''); ?>><?php echo $i; ?></option>
					<?php endfor; ?>
				</select>
			</div>
		</div>
		<div class="form-group-inline">
			<label class="col-md-2 control-label">Teléfono Fijo</label>
			<div class="col-md-2">
				<input type="text" name="user[home_phone]" class="form-control" value="<?php echo $user->home_phone; ?>">
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-2 control-label">Teléfono Celular</label>
			<div class="col-md-2">
				<input type="text" name="user[cell_phone]" class="form-control" value="<?php echo $user->cell_phone; ?>" required>
			</div>
		</div>
	</fieldset>

	<fieldset>
		<legend>Dirección de Entrega</legend>
		<div class="form-group">
			<label class="col-md-2 control-label">Departamento</label>
			<div class="col-md-6">
				<input name="user[state]" class="form-control" value="<?php echo $user->state; ?>" required>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-2 control-label">Ciudad</label>
			<div class="col-md-6">
				<input name="user[city]" class="form-control" value="<?php echo $user->city; ?>" required>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-2 control-label">Dirección</label>
			<div class="col-md-6">
				<input type="text" name="user[address1]" class="form-control" value="<?php echo $user->address1; ?>" required>
			</div>
		</div>
	</fieldset>

	<fieldset>
		<div class="form-group">
			<div class="col-sm-12">
				<button type="submit" class="btn btn-lg btn-success">Actualizar datos</button>
			</div>
		</div>
	</fieldset>
</form>
