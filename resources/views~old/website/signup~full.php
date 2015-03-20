<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h1>Registro Gratuito de Casillero</h1>
            </div>
            <div class="panel-body">
                <form data-parsley-validate id="signup-form" class="form-horizontal">
                    <div class="flash"></div>
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
                                <input type="text" name="user[id_number]" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">Nombre de la Empresa</label>
                            <div class="col-md-6">
                                <input type="text" name="user[company]" class="form-control">
                            </div>
                        </div>
                    </fieldset>

                    <fieldset>
                        <legend>Información de Contacto</legend>
                        <div class="form-group-inline">
                            <label class="col-md-2 control-label">Nombres<span class="required-field">*</span></label>
                            <div class="col-md-2">
                                <input type="text" name="user[firstname]" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">Apellidos<span class="required-field">*</span></label>
                            <div class="col-md-2">
                                <input type="text" name="user[lastname]" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">Sexo</label>
                            <div class="col-md-2">
                                <select class="form-control" name="user[gender_id]">
                                    <option value="1">Masculino</option>
                                    <option value="2">Femenino</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">Fecha nacimiento<span class="required-field">*</span></label>
                            <div class="col-md-2">
                                <select class="form-control" name="user[dob][year]" required>
                                    <option value="">Año</option>
                                    <?php for($i=1915; $i<=date('Y'); $i++): ?>
                                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select class="form-control" name="user[dob][month]" required>
                                    <option value="">Mes</option>
                                    <option value="01">Enero</option>
                                    <option value="02">Febrero</option>
                                    <option value="03">Marzo</option>
                                    <option value="04">Abril</option>
                                    <option value="05">Mayo</option>
                                    <option value="06">Junio</option>
                                    <option value="07">Julio</option>
                                    <option value="08">Agosto</option>
                                    <option value="09">Septiembre</option>
                                    <option value="10">Octubre</option>
                                    <option value="11">Noviembre</option>
                                    <option value="12">Diciembre</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select class="form-control" name="user[dob][day]" required>
                                    <option value="">Día</option>
                                    <option value="01">1</option>
                                    <option value="02">2</option>
                                    <option value="03">3</option>
                                    <option value="04">4</option>
                                    <option value="05">5</option>
                                    <option value="06">6</option>
                                    <option value="07">7</option>
                                    <option value="08">8</option>
                                    <option value="09">9</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                    <option value="13">13</option>
                                    <option value="14">14</option>
                                    <option value="15">15</option>
                                    <option value="16">16</option>
                                    <option value="17">17</option>
                                    <option value="18">18</option>
                                    <option value="19">19</option>
                                    <option value="20">20</option>
                                    <option value="21">21</option>
                                    <option value="22">22</option>
                                    <option value="23">23</option>
                                    <option value="24">24</option>
                                    <option value="25">25</option>
                                    <option value="26">26</option>
                                    <option value="27">27</option>
                                    <option value="28">28</option>
                                    <option value="29">29</option>
                                    <option value="30">30</option>
                                    <option value="31">31</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group-inline">
                            <label class="col-md-2 control-label">Teléfono Fijo</label>
                            <div class="col-md-2">
                                <input type="text" name="user[home_phone]" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">Teléfono Celular<span class="required-field">*</span></label>
                            <div class="col-md-2">
                                <input type="text" name="user[cell_phone]" class="form-control" required>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset>
                        <legend>Información de Acceso</legend>
                        <div class="form-group">
                            <label class="col-md-2 control-label">Correo Electrónico<span class="required-field">*</span></label>
                            <div class="col-md-6">
                                <input type="text" name="user[email]" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label"><?php echo Lang::get('messages.password'); ?><span class="required-field">*</span></label>
                            <div class="col-md-6">
                                <input id="password" type="password" name="user[password]" class="form-control" data-parsley-minlength="<?php echo User::PASSWORD_MIN_LENGTH; ?>" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label"><?php echo Lang::get('messages.password_confirm'); ?><span class="required-field">*</span></label>
                            <div class="col-md-6">
                                <input type="password" name="password_confirm" class="form-control" data-parsley-equalto="#password" required>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset>
                        <legend>Dirección de Entrega</legend>
                        <div class="form-group">
                            <label class="col-md-2 control-label">Departamento<span class="required-field">*</span></label>
                            <div class="col-md-6">
                                <input name="user[state]" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">Ciudad<span class="required-field">*</span></label>
                            <div class="col-md-6">
                                <input name="user[city]" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">Dirección<span class="required-field">*</span></label>
                            <div class="col-md-6">
                                <input type="text" name="user[address1]" class="form-control" required>
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

