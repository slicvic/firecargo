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

    // Package Manager
    var PackageMgr = {
        $pkgTemplate: null,

        init: function() {
            this.initEvents();
            this.updateTotals();
        },

        initEvents: function() {
            var me = this;
            me.$pkgTemplate = $('#packages > tbody.package-template').clone().removeClass('package-template').removeAttr('style');
            $('#packages > tbody.package-template').remove();

            $('#packages').on('click', '.btn-clone-package', me.clonePackage);
            $('#packages').on('click', '.btn-remove-package', me.removePackage);
            $('#btnNewPackage').on('click', me.newPackage);
            $('#packages').on('keyup', '.metric', me.updateTotals);
        },

        clonePackage: function() {
            var total = PackageMgr.countPackages();
            var $clonedPkg = $(this).closest('tbody').clone();

            $clonedPkg.find('.unique').val('');

            $clonedPkg.find('input, select, textarea').each(function() {
                $(this).attr('name', 'packages[new_' + total + '][' + $(this).attr('data-name') + ']');
            });

            $('#packages').append($clonedPkg);
            $('#totalPackages').html(1 + total);

            PackageMgr.updateTotals();
        },

        newPackage: function() {
            var total = PackageMgr.countPackages();
            var $newPkg = PackageMgr.$pkgTemplate.clone();

            $newPkg.find('input, select, textarea').each(function() {
                $(this).val('');
                $(this).attr('name', 'packages[new_' + total + '][' + $(this).attr('data-name') + ']');
            });

            $('#packages').append($newPkg);
            $('#totalPackages').html(1 + total);

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
            $('#grossWeight').html(grossWeight + ' lb(s)');
            $('#volumeWeight').html(volumeWeight + ' lb(s)');
            $('#chargeWeight').html((volumeWeight > grossWeight ? volumeWeight : grossWeight) + ' lb(s)');
        }
    };

    PackageMgr.init();
});
