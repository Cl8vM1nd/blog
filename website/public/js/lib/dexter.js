$(document).ready(function() {
    updateUserSideCredentials();
    getNews();
    /**
     * FINISH with image uploading save to cloud and local
     * TODO: Fix Bug
     * When user cancel specific page loading and click back
     * */
    $(window).scroll(function() {
        sS.setItem(SCROLL_POSITION, $(window).scrollTop());
        if($(window).scrollTop() + $(window).height() > $(document).height() - 1) {
                getMoreNews();
            }
    });
});