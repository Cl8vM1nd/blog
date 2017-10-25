$(document).ready(function() {
    $('body').backDetect(function(){
        // Prevent for Firefox. No need cause firefox cache previous page
        let firefox = /Firefox/.test(navigator.userAgent);
        if (!firefox) {
            sessionStorage.setItem(UPDATE_CREDENTIAL_NAME, '1');
        }
    });
});