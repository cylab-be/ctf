require('./bootstrap');

window.toastr = require('toastr');

require('./shortcut');

require("jquery-simple-timer")($);
$(function () {
    $('.timer').startTimer();
});

// jQuery plugin to prevent double submission of forms
jQuery.fn.preventDoubleSubmission = function () {
    $(this).on('submit', function (e) {
        var $form = $(this);

        if ($form.data('submitted') === true) {
            // Previously submitted - don't submit again
            console.log('multiple-submission...');
            e.preventDefault();
        } else {
            // Mark it so that the next submit can be ignored
            $form.data('submitted', true);
        }
    });

    // Keep chainability
    return this;
};

$(document).ready(function () {
    $('form').preventDoubleSubmission();

    // Show a flashed toastr message (flashed server-side, see app/helpers.php)
    if (window.__flash) {
        window.toastr[window.__flash.type](window.__flash.message);
    }
});
