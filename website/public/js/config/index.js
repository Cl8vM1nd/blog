//Load common code that includes config, then load the app logic for this page.
requirejs(['../init']);
let init = () => {
    requirejs(['classes'], () => {
        requirejs(['functions'], () => {
            requirejs(['default', 'bootstrap', 'dexter'], () => {
                $.holdReady(false);
            });
        });
    });
};
