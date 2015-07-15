$(function() {

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

    // Bind shipper autocomplete
    $('#shipper').keyup(function() {
        $('#shipperId').val('');
    });

    $('#shipper').autocomplete({
        source: '/warehouses/ajax-shipper-consignee-autocomplete',
        minLength: 2,
        select: function(event, ui) {
            $('#shipperId').val(ui.item.id);
        }
    });

    // Bind consignee autocomplete
    $('#consignee').keyup(function() {
        $('#consigneeId').val('');
    });

    $('#consignee').autocomplete({
        source: '/warehouses/ajax-shipper-consignee-autocomplete',
        minLength: 2,
        select: function(event, ui) {
            $('#consignee').val(ui.item.label);
            $('#consigneeId').val(ui.item.id);
            return false;
        }
    });

    // Bind form submit
    $('form').on('submit', function() {
        event.preventDefault();

        var form = $(this),
            flash = $('#flashMessage'),
            submit = $(this).find('button');

        if (!form.valid()) return false;

        submit.attr('disabled', true);
        flash.html('');

        $.post(form.attr('action'), form.serialize(), 'json')
            .done(function(data) {
                window.location = data.redirect_url;
            })
            .fail(function(xhr) {
                var data = JSON.parse(xhr.responseText);
                flash.html(data.error);
                $('html, body').scrollTop(0);
                submit.attr('disabled', false);
            });
    });

    // Package Manager
    var PackageMgr = {
        pkgTemplate: null,

        init: function() {
            this.initEvents();
            this.updateTotals();
        },

        initEvents: function() {
            var me = this;

            // Prepare package template
            me.pkgTemplate = $('#packages > tbody.package-template')
                .clone()
                .removeClass('package-template, hidden');
            $('#packages > tbody.package-template').remove();

            $('#packages').on('click', '.btn-clone-package', me.clonePackage);
            $('#packages').on('click', '.btn-remove-package', me.removePackage);
            $('#btnNewPackage').on('click', me.newPackage);
            $('#packages').on('keyup', '.metric', me.updateTotals);

            $('#packages').on('click', '.btn-toggle-detail', function() {
                var btn = $(this);
                btn.toggleClass('collapsed');
                btn.closest('tr').next('tr').toggleClass('hidden');
                if (btn.hasClass('collapsed')) {
                    btn.html('<i class="fa fa-minus"></i>');
                }
                else{
                    btn.html('<i class="fa fa-plus"></i>');
                }
            });

            $('.btn-toggle-detail-all').click(function() {
                var btn = $(this);
                btn.toggleClass('collapsed');
                if (btn.hasClass('collapsed')) {
                    btn.html('<i class="fa fa-minus"></i>');
                    $('#packages .btn-toggle-detail').html('<i class="fa fa-minus"></i>').addClass('collapsed');
                    $('#packages .package-detail').removeClass('hidden');
                }
                else{
                    btn.html('<i class="fa fa-plus"></i>');
                    $('#packages .btn-toggle-detail').html('<i class="fa fa-plus"></i>').removeClass('collapsed');
                    $('#packages .package-detail').addClass('hidden');
                }
            });
        },

        clonePackage: function() {
            var totalPkgs = PackageMgr.countPackages();
            var newPkg = PackageMgr.pkgTemplate.clone();

            $(this).closest('tbody').find('input, select, textarea').each(function() {
                var nameAttr = $(this).attr('data-name');
                newPkg
                    .find('[data-name="' + nameAttr + '"]')
                    .attr('name', 'packages[new_' + totalPkgs + '][' + nameAttr + ']')
                    .val($(this).val());
            });

            $('#packages').append(newPkg);
            $('#totalPackages').html(1 + totalPkgs);

            PackageMgr.updateTotals();
        },

        newPackage: function() {
            var totalPkgs = PackageMgr.countPackages();
            var newPkg = PackageMgr.pkgTemplate.clone();

            newPkg.find('input, select, textarea').each(function() {
                $(this).val('');
                $(this).attr('name', 'packages[new_' + totalPkgs + '][' + $(this).attr('data-name') + ']');
            });

            $('#packages').append(newPkg);
            $('#totalPackages').html(1 + totalPkgs);

            PackageMgr.updateTotals();
        },

        removePackage: function() {
            $(this).closest('tbody').remove();
            PackageMgr.updateTotals();
        },

        countPackages: function() {
            return $('#packages > tbody').length;
        },

        updateTotals: function() {
            var grossWeight = 0;
            var volumeWeight = 0;

            $('#packages > tbody > tr').each(function() {
                var $tr = $(this);
                var length = parseInt($tr.find('input[data-name="length"]').val()) || 0;
                var width = parseInt($tr.find('input[data-name="width"]').val()) || 0;
                var height = parseInt($tr.find('input[data-name="height"]').val()) || 0;
                var weight = parseInt($tr.find('input[data-name="weight"]').val()) || 0;
                grossWeight += weight;
                volumeWeight += (length * width * height) / 166;
            });

            volumeWeight = Math.round(volumeWeight);

            $('#totalPackages').html(PackageMgr.countPackages());
            $('#grossWeight').html(grossWeight);
            $('#volumeWeight').html(volumeWeight);
            $('#chargeWeight').html((volumeWeight > grossWeight) ? volumeWeight : grossWeight);
        }
    };

    PackageMgr.init();
});
