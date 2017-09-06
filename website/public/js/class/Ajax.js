let ajax = {
    setup: (ui, at) => {
        $.ajaxSetup({
            headers: {
                'Auth': ui + at
            }
        });
    },
    url: null,
    type: "GET",
    beforeSend: () => null,
    send: () => {
        $.ajax({
            type: this.type,
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
                    createCookie(offsetCookieName, offsetNews, 1);
                    noNews = false;
                }
                onProcess = false;
            }
        });
    }
};