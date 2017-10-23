$(document).ready(function() {
    $('.news-delete').on('click', function(e) {
        e.preventDefault();
        let url = $(this).attr('href');
        if (confirm('Are u sure u want to delete item "' + $(this).attr('id') + '"?')) {
            $.ajax({
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
        let tag = event.item;
        let newsId = $('#newsId').val();
        let deleteFlag = !!newsId;

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

});
