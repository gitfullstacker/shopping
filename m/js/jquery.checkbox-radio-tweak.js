/**
 * Created by zur4ik on 12/27/16.
 */

(function ($) {

    //default settings
    var defaults = {
    };

    //final settings
    var settings = {};

    //function methods
    var methods = {
        init: function (options) {

            //extend options
            settings = $.extend({}, defaults, options);

            //wrap under
            if ($(this).length > 0) {
                $(this).each(function(i, e) {
                    var $type = $(e).attr('type');
                    var $checked = !!$(e).prop('checked');
                    var $wrapper = $(document.createElement('div')).addClass('check-radio-tweak-wrapper');

                    //set checked
                    if ($checked) {
                        $wrapper.get(0).setAttribute('checked', '');
                    }

                    $(e).click(function(e) {
                        e.stopPropagation();
                    });

                    //add event listener to wrapper
                    $wrapper.click(function(e) {

                        $('input', this).click();

                        //update checkboxes
                        methods.update();

                        e.stopPropagation();
                        e.preventDefault();
                    });

                    //set type
                    $wrapper.attr('type', $type);

                    //wrap input
                    $(e).wrap($wrapper);
                });
            }
//            $(this).wrap('<div class="check-radio-tweak-wrapper"></div>')

        },
        update: function () {
            $('.check-radio-tweak-wrapper').each(function(i, e) {
                if ($('input', e).prop('checked')) {
                    e.setAttribute('checked', '');
                } else {
                    $(e).removeAttr('checked');
                }
            });
        }
    };


    /**
     * jQuery plugin
     * @external jQuery.fn
     * @function checkRadioTweak
     * @param {object||string} [methodOrOptions] parameters
     */
    //define function
    $.fn.checkRadioTweak = function (methodOrOptions) {
        //define method called or option
        if (methods[methodOrOptions]) {
            return methods[methodOrOptions].apply(this, Array.prototype.slice.call(arguments, 1));
        }
        else if (typeof methodOrOptions === 'object' || !methodOrOptions) {
            return methods.init.apply(this, arguments);
        } else {
            $.error('Method ' + methodOrOptions + ' does not exist on jQuery.flipCounter');
        }
    }


})(jQuery);