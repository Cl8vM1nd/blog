$(document).ready(function() {
    var moreNewsUrl = '/news/more/';
    var newsPerPage = 5;
    var offsetNews = newsPerPage;
    var noNews = false;
    var block = false;

    $(window).scroll(function() {
        if($(window).scrollTop() + $(window).height() > $(document).height() - 1) {
            if (!block) {
                $.ajax({
                    type: "GET",
                    beforeSend: function () {
                        block = true;
                        if (!noNews) {
                            $('#spinner').fadeIn(400);
                        }
                    },
                    url: moreNewsUrl + offsetNews,
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        alert("Error. Please try again. " + textStatus);
                    },
                    success: function (data) {
                        if (data == '') {
                            $('#spinner').fadeOut(400);
                            noNews = true;
                        } else {
                            $(data).appendTo('#content');
                            $('#spinner').fadeOut(400);

                            offsetNews += newsPerPage;
                            noNews = false;
                        }
                        block = false;
                    }
                });
            }
        }
    });
});