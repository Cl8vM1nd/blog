$(document).ready(function() {
    /***************
     *
     * TEXT EDITOR
     *
     * ******************/

    var editor = $('#text-editor-content');

    // <b>
    $('#text-editor-b').on('click', function(e) {
        editor.val(editor.val() + "<b></b>");
    });

    // <i>
    $('#text-editor-i').on('click', function(e) {
        editor.val(editor.val() + "<i></i>");
    });

    // <u>
    $('#text-editor-u').on('click', function(e) {
        editor.val(editor.val() + "<u></u>");
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

    /**
     * UPLOADING IMAGE
     * */
    $('#inputImage').on('change', function(e) {
        var imageName = $(this).val();
        var slash = imageName.lastIndexOf('\\') + 1;
        var dot = imageName.lastIndexOf('.');

        var name = imageName.substring(slash, dot);
        /* Update image name if we add article */
        if (window.location.pathname.indexOf('add')) {
            $('#inputImageTitle').val(name);
        }
    });


    /**
     * Tinymce Settings
     * */

    var tinyEditor = tinymce.init({
        selector: 'textarea',
        menubar: false,
        plugins: [
            'advlist autolink lists link image charmap print preview anchor',
            'searchreplace visualblocks code fullscreen',
            'insertdatetime media table contextmenu paste code'
        ],
        toolbar: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | upload',
        setup: function (editor) {
            editor.addButton('upload', {
                text: 'Upload image',
                icon: false,
                onclick: function () {

                    editor.insertContent('&nbsp;<b>It\'s my button!</b>&nbsp;');
                }
            });
        }});
});