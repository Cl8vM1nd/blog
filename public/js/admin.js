$(document).ready(function() {

    /***************
     *
     * TEXT EDITOR
     *
     * ******************/

    var editor = $('#text-editor-content');

    // <b>
    $('#text-editor-b').on('click', function(e) {
        editor.text(editor.val() + "<b></b>");
    });

    // <i>
    $('#text-editor-i').on('click', function(e) {
        editor.text(editor.val() + "<i></i>");
    });

    // <u>
    $('#text-editor-u').on('click', function(e) {
        editor.text(editor.val() + "<u></u>");
    });

    // <img>
   /* $('#text-editor-img').on('click', function(e) {
        $('#' + $(this).attr('id') + '-modal').modal({
            closeClass: 'icon-remove',
            fadeDuration: 250,
            width: '500px'
        });
        return false;
    });*/

    $("#demo01").animatedModal();


    /***************
     *
     * TEXT EDITOR
     *
     * ******************/

    $('.news-delete').on('click', function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
        if (confirm('Are u shure u want to delete item "' + $(this).attr('id') + '"?')) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $(this).attr('_token')
                }
            });

            $.post({
                type: "POST",
                url: url,
                success: function(response) {
                    location.href = "/admin/news";
                }
            });
        } else {
            return false;
        }
    });

    /**
     * Tags
     * */

    /**
     * REMOVE TAG
     * */
    $('#inputTags').on('beforeItemRemove', function(event) {
        var tag = event.item;
        var newsId = $('#newsId').val();
        var deleteFlag = !!newsId;

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $("input[name=_token]").val()
            }
        });

        if (deleteFlag) {
            if (!event.options || !event.options.preventPost) {
                $.ajax({
                    type: "POST",
                    url: "/admin/news/tag/delete/" + newsId,
                    data: "tag=" + tag,
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        alert("Error removing tag. Try again. " + textStatus);
                        $('#inputTags').tagsinput('add', tag, {preventPost: true});
                    }
                });
            }
        }
    });
});