$(document).ready(function() {
    let offsetNews = parseInt(getCookie(OFFSET_NEWS_COOKIE_NAME)) || 0;
    let noNews = false;
    let onProcess = false;

    //alert(getCookie('UPDATE_CRD'));

    $(window).scroll(function() {
        if($(window).scrollTop() + $(window).height() > $(document).height() - 1) {
            if(!noNews && !onProcess) {
                sendAjaxRequest();
            }
        }
    });

    function sendAjaxRequest() {
        $.ajaxSetup({
            headers: {
                'Auth': $('input[name="ui"]').val() + $('input[name="at"]').val()
            }
        });
        $.ajax({
            type: "GET",
            beforeSend: function () {
                $('#spinner_image').fadeIn(100);
                onProcess = true;
            },
            url: getUrl() + offsetNews,
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                console.log("Error. Please try again.");
            },
            success: function (data) {
                if (data === 'null') {
                    $('#spinner_image').hide(300);
                    noNews = true;
                } else {
                    $('input[name="at"]').val(data[1]);
                    $(data[0]).appendTo('#content');
                    $('#spinner_image').fadeOut(300);

                    offsetNews += data[2];
                    createCookie(OFFSET_NEWS_COOKIE_NAME, offsetNews, 1);
                    noNews = false;
                }
                onProcess = false;
            }
        });
    }

});