$(document).ready(function() {
    $('.news-delete').on('click', function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
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

    var upload_path = '/admin/news/upload';

    tinymce.init({
        selector: 'textarea',
        menubar: false,
        image_title: true,
        automatic_uploads: true,
        images_upload_url: upload_path,
        file_picker_types: 'image',
        images_upload_credentials: true,
        plugins: [
            'advlist autolink lists link image charmap print preview anchor',
            'searchreplace visualblocks code fullscreen',
            'insertdatetime media table contextmenu paste code'
        ],
        toolbar: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | code',
        file_picker_callback: function (cb, value, meta) {
            var input = document.createElement('input');
            input.setAttribute('type', 'file');
            input.setAttribute('accept', 'image/*');

            // Note: In modern browsers input[type="file"] is functional without
            // even adding it to the DOM, but that might not be the case in some older
            // or quirky browsers like IE, so you might want to add it to the DOM
            // just in case, and visually hide it. And do not forget do remove it
            // once you do not need it anymore.

            input.onchange = function () {
                var file = this.files[0];

                // Note: Now we need to register the blob in TinyMCEs image blob
                // registry. In the next release this part hopefully won't be
                // necessary, as we are looking to handle it internally.
                var id = (new Date()).getTime();
                var blobCache = tinymce.activeEditor.editorUpload.blobCache;
                var blobInfo = blobCache.create(id, file);
                blobCache.add(blobInfo);

                // call the callback and populate the Title field with the file name
                cb(blobInfo.blobUri(), {title: file.name});
            };

            input.click();
        }

    });
});