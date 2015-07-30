$(function() {
    /**
     * Close side menu
     */
    $('body').toggleClass("mini-navbar");

    /**
     * Carrier autocomplete handler
     */
    $('#carrier').keyup(function() {
        $('#carrier-id').val('');
    });

    $('#carrier').autocomplete({
        source: '/carriers/ajax-autocomplete',
        minLength: 2,
        select: function(event, ui) {
            $('#carrier-id').val(ui.item.id);
        }
    }).autocomplete('instance')._renderItem = function(ul, item) {
        return $('<li>')
            .append('<a>' + (item.prefix.trim().length ? item.prefix : item.id) + ' - ' + item.label + '</a>')
            .appendTo(ul);
    };

    /**
     * Shipper autocomplete handler
     */
    $('#shipper').keyup(function() {
        $('#shipper-id').val('');
    });

    $('#shipper').autocomplete({
        source: '/warehouses/ajax-account-autocomplete?type=shipper',
        minLength: 2,
        select: function(event, ui) {
            $('#shipper-id').val(ui.item.id);
        }
    }).autocomplete('instance')._renderItem = function(ul, item) {
        return $('<li>')
            .append('<a>' + item.id + ' - ' + item.label + '</a>')
            .appendTo(ul);
    };

    /**
     * Client autocomplete handler
     */
    $('#client').keyup(function() {
        $('#client-id').val('');
    });

    $('#client').autocomplete({
        source: '/warehouses/ajax-account-autocomplete?type=client',
        minLength: 2,
        select: function(event, ui) {
            $('#client').val(ui.item.label);
            $('#client-id').val(ui.item.id);
            return false;
        }
    }).autocomplete('instance')._renderItem = function(ul, item) {
        return $('<li>')
            .append('<a>' + item.id + ' - ' + item.label + '</a>')
            .appendTo(ul);
    };

    /**
     * Form submit handler
     */
    $('#warehouse-edit-form').on('submit', function() {
        event.preventDefault();

        var form = $(this),
            flashMessage = $('#flash-message'),
            saveBtn = $(this).find('button[type=submit]');

        if (!form.valid()) return false;

        saveBtn.button('loading');

        $.post(form.attr('action'), form.serialize(), 'json')
            .done(function(data) {
                window.location = data.redirect_url;
            })
            .fail(function(xhr) {
                flashMessage.html(xhr.responseJSON.error);
                $('html, body').scrollTop(0);
                saveBtn.button('reset');
            });
    });

    /**
     * Package event handlers
     */
    var PackageMgr = {
        pkgTemplate: null,

        init: function() {
            this.initEvents();
            this.updateTotals();
        },

        initEvents: function() {
            var self = this;

            // Prepare package template
            self.pkgTemplate = $('#packages-container > .package-template').clone();
            self.pkgTemplate.removeClass('package-template');
            self.pkgTemplate.removeClass('hidden');
            $('#packages-container > .package-template').remove();

            $('#packages-container').on('click', '.clone-package-btn', self.clonePackage);
            $('#packages-container').on('click', '.remove-package-btn', self.removePackage);
            $('#add-package-btn').on('click', self.addPackage);
            $('#packages-container').on('keyup', '.metric', self.updateTotals);
        },

        clonePackage: function() {
            var cloneBtn = $(this);
            var totalPkgs = PackageMgr.countPackages();
            var sourcePkg = cloneBtn.closest('.panel');
            var clonePkg = PackageMgr.pkgTemplate.clone();

            sourcePkg.find('input, select, textarea').each(function() {
                var sourceField = $(this);
                var cloneField = clonePkg.find('[data-name="' + sourceField.attr('data-name') + '"]');
                cloneField
                    .attr('name', 'packages[new_' + totalPkgs + '][' + sourceField.attr('data-name') + ']')
                    .val(sourceField.hasClass('unique') ? '' : sourceField.val());
            });

            $('#packages-container').append(clonePkg);
            $('#total-packages').html(1 + totalPkgs);

            PackageMgr.updateTotals();

            window.scrollTo(0, document.body.scrollHeight);
        },

        addPackage: function() {
            var totalPkgs = PackageMgr.countPackages();
            var newPkg = PackageMgr.pkgTemplate.clone();
            var trackingNumber = $('#add-package-tracking');

            newPkg.find('input, select, textarea').each(function() {
                var name = $(this).attr('data-name');
                if (name == 'tracking_number') {
                    $(this).val(trackingNumber.val());
                    trackingNumber.val('').focus();
                }
                $(this).attr('name', 'packages[new_' + totalPkgs + '][' + name + ']');
            });

            $('#packages-container').append(newPkg);
            $('#total-packages').html(1 + totalPkgs);

            PackageMgr.updateTotals();
        },

        removePackage: function() {

            $(this).closest('.panel').remove();

            PackageMgr.updateTotals();
        },

        countPackages: function() {
            return $('#packages-container > .package').length;
        },

        updateTotals: function() {
            var grossWeight = 0;
            var volumeWeight = 0;

            $('#packages-container > .package').each(function() {
                var $tr = $(this);
                var length = parseInt($tr.find('input[data-name="length"]').val()) || 0;
                var width = parseInt($tr.find('input[data-name="width"]').val()) || 0;
                var height = parseInt($tr.find('input[data-name="height"]').val()) || 0;
                var weight = parseInt($tr.find('input[data-name="weight"]').val()) || 0;
                grossWeight += weight;
                volumeWeight += (length * width * height) / 166;
            });

            volumeWeight = Math.round(volumeWeight);

            $('#total-packages').html(PackageMgr.countPackages());
            $('#gross-weight').html(grossWeight);
            $('#volume-weight').html(volumeWeight);
            $('#charge-weight').html((volumeWeight > grossWeight) ? volumeWeight : grossWeight);
        }
    };

    PackageMgr.init();

    /*
    var form = $("#warehouse-edit-form");

    form.children("div").steps({
        headerTag: "h3",
        bodyTag: "section",
        transitionEffect: "slideLeft",
        enablePagination: true,
        enableAllSteps: true,
        enableCancelButton: true,
        showFinishButtonAlways: true,
        labels: {
            finish: 'Save'
        },
        onStepChanging: function (event, currentIndex, newIndex)
        {
            form.validate().settings.ignore = ":disabled,:hidden";
            return form.valid();
        },
        onFinishing: function (event, currentIndex)
        {
            form.validate().settings.ignore = ":disabled";
            return form.valid();
        },
        onFinished: function (event, currentIndex)
        {
            var saveBtn = $(event.currentTarget).find(".actions a[href$='#finish']");
            var flashMessage = $('#flashMessage');

            saveBtn.text('Saving...').attr('disabled', true);

            $.post(form.attr('action'), form.serialize(), 'json')
                .done(function(data) {
                    window.location = data.redirect_url;
                })
                .fail(function(xhr) {
                    saveBtn.text('Save').attr('disabled', false);
                    flashMessage.html(xhr.responseJSON.error);
                    $('html, body').scrollTop(0);
                });
        },
        onCanceled: function (event) {
            var id = form.children('input[name="id"]').val();
            window.location = (id) ? '/warehouses/show/' + id : '/warehouses';
        },
        onInit: function() {
            $('.wizard > .steps > ul > li:not(.current)').addClass('done');
        }
    });
     */
});