$(function() {
    /**
     * ---------------------------------------------
     * Close left nav
     * ---------------------------------------------
     */
    $('body').toggleClass('mini-navbar');

    /**
     * ---------------------------------------------
     * Carrier autocomplete handler
     * ---------------------------------------------
     */
    $('#carrier-name').keyup(function() {
        $('#carrier-id').val('');
    });

    $('#carrier-name').autocomplete({
        source: '/carriers/autocomplete-search',
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
     * ---------------------------------------------
     * Shipper autocomplete handler
     * ---------------------------------------------
     */
    $('#shipper-name').keyup(function() {
        $('#shipper-id').val('');
    });

    $('#shipper-name').autocomplete({
        source: '/accounts/autocomplete-search?type=shipper',
        minLength: 2,
        select: function(event, ui) {
            $('#shipper-id').val(ui.item.id);
        }
    }).autocomplete('instance')._renderItem = function(ul, item) {
        var html = '<li><a><strong>' + item.id + ' - ' + item.label + '</strong>';

        if (item.address != '') {
            html += '<div><i><small>' + item.address + '</small></i></div>';
        }

        html += '</a>';

        return $(html).appendTo(ul);
    };

    /**
     * ---------------------------------------------
     * Customer autocomplete handler
     * ---------------------------------------------
     */
    $('#customer-name').keyup(function() {
        $('#customer-id').val('');
    });

    $('#customer-name').autocomplete({
        source: '/accounts/autocomplete-search?type=customer',
        minLength: 2,
        select: function(event, ui) {
            $('#customer-id').val(ui.item.id);
        }
    }).autocomplete('instance')._renderItem = function(ul, item) {
        var html = '<li><a><strong>' + item.id + ' - ' + item.label + '</strong>';

        if (item.email != '') {
            html += '<div><i><small>' + item.email + '</small></i></div>';
        }

        if (item.address != '') {
            html += '<div><i><small>' + item.address + '</small></i></div>';
        }

        html += '</a>';

        return $(html).appendTo(ul);
    };

    /**
     * ---------------------------------------------
     * Form submit handler
     * ---------------------------------------------
     */
    $('#warehouse-edit-form').on('submit', function() {
        event.preventDefault();

        var form = $(this),
            saveBtn = $(this).find('button[type=submit]');

        if (!form.valid()) return false;

        saveBtn.button('loading');

        $.post(form.attr('action'), form.serialize(), 'json')
            .done(function(data) {
                window.location = data.redirect_url;
            })
            .fail(function(xhr) {
                toastr.error(xhr.responseJSON.message, xhr.responseJSON.title);
                $('html, body').scrollTop(0);
                saveBtn.button('reset');
            });
    });

    /**
     * ---------------------------------------------
     * Add/remove package event handlers
     * ---------------------------------------------
     */
    var PackageMgr = {
        pkgTemplate: null,

        init: function() {
            this.initEvents();
            this.updateTotals();
        },

        initEvents: function() {
            var that = this;

            // Prepare package template
            that.pkgTemplate = $('#packages-container > .package-template').clone();
            that.pkgTemplate.removeClass('package-template');
            that.pkgTemplate.removeClass('hidden');
            $('#packages-container > .package-template').remove();

            // Bind click handers
            $('#packages-container').on('click', '.clone-package-btn', that.clonePackage);
            $('#packages-container').on('click', '.remove-package-btn', that.removePackage);
            $('#add-package-btn').on('click', that.addPackage);
            $('#add-package-tracking').keypress(function(e) {
                if (e.keyCode == 13) {
                    e.preventDefault();
                    e.stopPropagation();
                    that.addPackage();
                }
            });

            $('#packages-container').on('keyup', '.metric', that.updateTotals);

            // Toggle panel theme based on checkbox state for packages
            // currently in the warehouse.
            $('.delete-package-icheck').on('ifChanged', function(event) {
                var self = $(this);
                var parentPanel = self.closest('.panel');
                if  (self.is(':checked')) {
                    parentPanel
                        .removeClass('panel-info panel-info-light')
                        .addClass('panel-danger panel-danger-light');
                }
                else {
                    parentPanel
                        .removeClass('panel-danger panel-danger-light')
                        .addClass('panel-info panel-info-light');
                }
            });
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
                    .val(sourceField.attr('data-unique') ? '' : sourceField.val());
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

    /**
     * ---------------------------------------------
     * jQuery steps form handler
     * ---------------------------------------------
     */
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
