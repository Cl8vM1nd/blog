$(document).ready(function() {
    $('body').backDetect(function(){
        createCookie(updateCredentialCookieName, 1, 1)
    });
});