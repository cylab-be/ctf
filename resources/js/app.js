require('./bootstrap');


// Masonry (for research projects)
var jQueryBridget = require('jquery-bridget');
var Masonry = require('masonry-layout');
jQueryBridget( 'masonry', Masonry, $ );

$(document).ready(function(){
    $('.grid').masonry({
      itemSelector: '.grid-item',
      columnWidth: '.grid-sizer',
      percentPosition: true
    });
});