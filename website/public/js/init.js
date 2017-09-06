requirejs.config({
    baseUrl: '/js/lib',
    paths: {
        bootstrap: '../../vendor/bootstrap/dist/js/bootstrap',
        bootstrap_tags: '/vendor/bootstrap-tagsinput/src/bootstrap-tagsinput',
        jquery: '../../vendor/jquery/dist/jquery',
        backDetect: '../../vendor/jquery-backdetect/jquery.backDetect',
        tinymce: '/vendor/tinymce/js/tinymce/tinymce.min'
    },
    urlArgs: "version=" +  (new Date()).getTime()
});

requirejs(['config']);