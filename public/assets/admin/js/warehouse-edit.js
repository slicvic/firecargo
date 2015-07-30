$(function() {
    // Close side menu
    $('body').toggleClass("mini-navbar");

    // Bind carrier autocomplete
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

    // Bind shipper autocomplete
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

    // Bind client autocomplete
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

    // Bind form submit
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

    // Package Manager
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
            var cloneePkg = cloneBtn.closest('.panel');
            var clonePkg = PackageMgr.pkgTemplate.clone();

            clonePkg.children('.panel-body').replaceWith(cloneePkg.children('.panel-body').clone());

            clonePkg.find('input, select, textarea').each(function() {
                if ($(this).hasClass('unique')) {
                    $(this).val('');
                }
                $(this).attr('name', 'packages[new_' + totalPkgs + '][' + $(this).attr('data-name') + ']');
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
            var panel = $(this).closest('.panel');

            if (panel.hasClass('new')) {
                panel.remove();
            }
            else {
                if (confirm('Are you sure you want to remove this piece from the warehouse?')) {
                    panel.remove();
                }
            }

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
