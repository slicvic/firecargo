@extends('layouts.admin.model.form')

@section('icon', 'truck')

@section('title')
    {{ $cargo->exists ? 'Edit' : 'Create' }} Cargo
@stop

@section('subtitle')
    <ol class="breadcrumb">
        <li>
            <a href="/cargos">Cargos</a>
        </li>
        <li class="active">
            <strong>{{ $cargo->exists ? 'Edit' : 'Create' }}</strong>
        </li>
    </ol>
@stop

@section('form')
    <form data-parsley-validate action="/cargos/{{ $cargo->exists ? 'update/' . $cargo->id : 'store' }}" method="post" class="form-horizontal">
        <div id="flashError"></div>
        <div class="ibox">
            <div class="ibox-title">
                <h5>Cargo Info</h5>
            </div>
            <div class="ibox-content">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group">
                    <label class="control-label col-sm-2">Receipt #</label>
                    <div class="col-sm-4">
                        <input required type="text" name="cargo[receipt_number]" placeholder="" class="form-control" value="{{ cargo->receipt_number }}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2">Departure Date</label>
                    <div class="col-sm-4">
                        <div class="input-group">
                            <input required type="text" name="cargo[departed_at]" placeholder="" class="date form-control" value="{{ $cargo->exists ? $cargo->departed_at : date('Y-m-d H:i:s') }}">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2">Carrier</label>
                    <div class="col-sm-4">
                        <input type="text" id="carrier" name="cargo[carrier_name]" placeholder="" class="form-control" value="{{ $cargo->carrier->present()->name(TRUE) }}">
                        <input type="hidden" id="carrierId" name="cargo[carrier_id]" value="{{ $cargo->carrier_id }}">
                    </div>
                </div>
            </div>
        </div>

        <div class="ibox">
            <div class="ibox-title">
                <h5>Pieces</h5>
            </div>
            <div class="ibox-content">
                @if ( ! count($nestablePackages))
                    <div class="alert alert-warning">
                        <h4><i class="fa fa-exclamation-triangle"></i>
                        No packages available for cargo.</h4>
                    </div>
                @endif
                <div class="dd" id="cargoNestableList">
                    <ol class="dd-list">
                        <li class="dd-item" data-id="3">
                            @foreach ($nestablePackages as $warehouseId => $packages)
                                <div class=""><a target="_blank" href="/warehouses/show/{{ $warehouseId }}">Warehouse # {{ $warehouseId }}</a></div>
                                <ol class="dd-list">
                                    @foreach ($packages as $package)
                                        <li class="dd-item" data-id="4">
                                            <div class="">
                                                <input type="checkbox" name="packages[{{ $package->id }}]"{{ $cargo->exists ? ' checked' : '' }}>
                                                {{ $package->present()->toString() }}
                                            </div>
                                        </li>
                                    @endforeach
                                </ol>
                            @endforeach

                        </li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-4">
                <a class="btn btn-white" href="/cargos">Cancel</a>
                <button class="btn btn-primary" type="submit">Save changes</button>
            </div>
        </div>
    </form>

    <script src="/assets/vendor/inspinia/Static_Seed_Project/js/plugins/nestable/jquery.nestable.js"></script>
    <link rel="stylesheet" href="/assets/vendor/jquery-ui/jquery-ui.min.css">
    <script src="/assets/vendor/jquery-ui/jquery-ui.min.js"></script>

    <script>
    $(function() {
        // Bind nestable
        $('#cargoNestableList').nestable({});
        $('#cargoNestableList').nestable('expandAll');

        // Bind carrier autocomplete
        $('#carrier').keyup(function() {
            $('#carrierId').val('');
        });

        $('#carrier').autocomplete({
            source: '/carriers/ajax-autocomplete',
            minLength: 2,
            select: function(event, ui) {
                $('#carrierId').val(ui.item.id);
            }
        });

        // Bind form submit
        $('form').on('submit', function() {
            event.preventDefault();

            var $form = $(this),
                $flashError = $('#flashError'),
                $submit = $(this).find('button');

            $submit.attr('disabled', true);
            $flashError.html('');

            $.post($form.attr('action'), $form.serialize(), function(data) {
                $submit.attr('disabled', false);

                if (data.status == 'ok') {
                    window.location = data.redirect_to;
                } else {
                    $flashError.html(data.message);
                    $('html, body').scrollTop(0);
                }
            }, 'json');
        });
     });
    </script>
@stop
