//Load common code that includes config, then load the app logic for this page.
requirejs(['../init']);
let init = () => {
    requirejs(['backDetect'], () => {
        requirejs(['house'], () => {
            requirejs(['functions'], ()  => {
                requirejs(['default', 'bootstrap'], () => {
                    $.holdReady(false);
                });
            });
        })
    });
};