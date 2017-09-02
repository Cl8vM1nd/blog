$(document).ready(function() {
    var moreNewsUrl = '/news/more/';
    var tagsUrl = '/news/search/tag/more/';
    var offsetNews = 0;
    var noNews = false;
    var onProcess = false;

    $(window).scroll(function() {
        if($(window).scrollTop() + $(window).height() > $(document).height() - 1) {
                $.ajaxSetup({
                    headers: {
                        'Auth': $('input[name="ui"]').val() + $('input[name="at"]').val()
                    }
                });
            if(!noNews && !onProcess) {
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
                        if (data == 'null') {
                            $('#spinner_image').hide(300);
                            noNews = true;
                        } else {
                            $('input[name="at"]').val(data[1]);
                            $(data[0]).appendTo('#content');
                            $('#spinner_image').fadeOut(300);

                            offsetNews += data[2];
                            noNews = false;
                        }
                        onProcess = false;
                    }
                });
            }
        }
    });

    /* Get right ajax url depending on current application url*/
    function getUrl() {
        var url = window.location.pathname;
        if(url.indexOf('search') != -1) {
            var tagId = url.substr(url.lastIndexOf('/') + 1);
            return tagsUrl + tagId + '/';
        } else {
            return moreNewsUrl;
        }
    }
});