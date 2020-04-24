require('./bootstrap');

// Masonry (for the list of opened challenges)
var jQueryBridget = require('jquery-bridget');
var Masonry = require('masonry-layout');
jQueryBridget('masonry', Masonry, $);

$(document).ready(function () {
    $('.grid').masonry({
        itemSelector: '.grid-item',
        columnWidth: '.grid-sizer',
        percentPosition: true
    });
});

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
});
