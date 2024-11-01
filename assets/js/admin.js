/*global jQuery, document, simple_attribution_vars*/
/*jslint newcap: true*/
jQuery(document).ready(function ($) {
    'use strict';

    var Simple_Attribution_Settings;

    /**
     * Settings
     */
    Simple_Attribution_Settings = {
        init : function () {
            this.general();
        },

        general : function () {
            $('select[name="simple_attribution_settings[caption_type]"]').change(function () {
                var selectedItem = $('select[name="simple_attribution_settings[caption_type]"] option:selected');

                if (selectedItem.val() === 'text' ) {
                    $('select[name="simple_attribution_settings[icon]"]').closest('tr').fadeOut('fast', function () {
                        $(this).css('display', 'none');
                    });
                    $('select[name="simple_attribution_settings[image]"]').closest('tr').fadeOut('fast', function () {
                        $(this).css('display', 'none');
                    });
                    $('input[name="simple_attribution_settings[url]"]').closest('tr').fadeOut('fast', function () {
                        $(this).css('display', 'none');
                    });
                    $('input[name="simple_attribution_settings[height]"]').closest('tr').fadeOut('fast', function () {
                        $(this).css('display', 'none');
                    });
                    $('input[name="simple_attribution_settings[caption]"]').closest('tr').fadeIn('fast').css('display', 'table-row');
                } else if (selectedItem.val() === 'icon' ) {
                    $('input[name="simple_attribution_settings[caption]"]').closest('tr').fadeOut('fast', function () {
                        $(this).css('display', 'none');
                    });
                    $('select[name="simple_attribution_settings[image]"]').closest('tr').fadeOut('fast', function () {
                        $(this).css('display', 'none');
                    });
                    $('input[name="simple_attribution_settings[url]"]').closest('tr').fadeOut('fast', function () {
                        $(this).css('display', 'none');
                    });
                    $('input[name="simple_attribution_settings[height]"]').closest('tr').fadeOut('fast', function () {
                        $(this).css('display', 'none');
                    });
                    $('select[name="simple_attribution_settings[icon]"]').closest('tr').fadeIn('fast').css('display', 'table-row');
                } else {
                    $('input[name="simple_attribution_settings[caption]"]').closest('tr').fadeOut('fast', function () {
                        $(this).css('display', 'none');
                    });
                    $('select[name="simple_attribution_settings[icon]"]').closest('tr').fadeOut('fast', function () {
                        $(this).css('display', 'none');
                    });
                    $('select[name="simple_attribution_settings[image]"]').closest('tr').fadeIn('fast').css('display', 'table-row');
                    $('input[name="simple_attribution_settings[url]"]').closest('tr').fadeIn('fast').css('display', 'table-row');
                    $('input[name="simple_attribution_settings[height]"]').closest('tr').fadeIn('fast').css('display', 'table-row');
                }
            }).change();

            $('select[name="simple_attribution_settings[image]"]').change(function () {
                var selectedItem = $('select[name="simple_attribution_settings[image]"] option:selected');

                if (selectedItem.val() === 'custom' && $('select[name="simple_attribution_settings[caption_type]"] option:selected').val() === 'image' ) {
                    $('input[name="simple_attribution_settings[url]"]').closest('tr').fadeIn('fast').css('display', 'table-row');
                } else {
                    $('input[name="simple_attribution_settings[url]"]').closest('tr').fadeOut('fast', function () {
                        $(this).css('display', 'none');
                    });
                }
            }).change();

            $('select[name="simple_attribution_settings[icon]"]').select2({
                templateResult: this.formatIcon,
                width: 'element'
            });

            $('select[name="simple_attribution_settings[image]"]').select2({
                templateResult: this.formatImage,
                width: '100px'
            });
        },

        formatIcon : function( icon ) {
            if (!icon.id) {
                return icon.text;
            }

            var $icon = $('<span><i class="fa ' + icon.text + ' simple_attribution_select2_icon" /> ' + icon.text + '</span>');
            return $icon;
        },

        formatImage : function( image ) {
            if (!image.id || image.text === 'Custom') {
                return image.text;
            }

            var $image = $('<span><img src="' + simple_attribution_vars.imageBaseUrl + image.element.value.toLowerCase() + '.png" class="simple_attribution_select2_image" /> ' + image.text + '</span>');
            return $image;
        }
    };
    Simple_Attribution_Settings.init();
});
