//Load common code that includes config, then load the app logic for this page.
requirejs(['../init'], function (common) {
    requirejs(['jquery'], function ($) {
        requirejs(['bootstrap', 'functions', 'dexter']);
    });
});