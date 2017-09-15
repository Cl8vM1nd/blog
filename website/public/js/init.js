requirejs.config({
    baseUrl: '/js/lib',
    paths: {
        bootstrap: '../../vendor/bootstrap/dist/js/bootstrap',
        bootstrap_tags: '/vendor/bootstrap-tagsinput/src/bootstrap-tagsinput',
        jquery: '../../vendor/jquery/dist/jquery',
        backDetect: '../../vendor/jquery-backdetect/jquery.backDetect',
        tinymce: '/vendor/tinymce/js/tinymce/tinymce.min.js?apiKey=40b8nqna5xe98q4xvjm66l4c6v708i2s20zpgcsyr1aeltet',
        domReady: '../plugins/domReady'
    },
    urlArgs: "ver=" +  (new Date()).getTime()
});

requirejs(['jquery'], ($) => {
   require(['config'], ($, config) => {
        init();
   });
});
