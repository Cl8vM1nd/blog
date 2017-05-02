$(document).ready(function() {
    var moreNewsUrl = '/news/more/';
    var newsPerPage = 5;
    var offsetNews = newsPerPage;
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
                            $('#spinner').fadeIn(400);
                            onProcess = true;
                    },
                    url: moreNewsUrl + offsetNews,
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        console.log("Error. Please try again.");
                    },
                    success: function (data) {
                        if (data == 'null') {
                            $('#spinner').hide(400);
                            noNews = true;
                        } else {
                            $('input[name="at"]').val(data[1]);
                            $(data[0]).appendTo('#content');
                            $('#spinner').fadeOut(400);

                            offsetNews += newsPerPage;
                            noNews = false;
                        }
                        onProcess = false;
                    }
                });
            }
        }
    });
});