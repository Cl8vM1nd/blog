//Load common code that includes config, then load the app logic for this page.
requirejs(['../init']);
let init = () => {
    requirejs(['classes'], () => {
        requirejs(['bootstrap', 'bootstrap_tags', 'apple']);
        requirejs(['tinymce'], function (tinyMCE) {
            /**
             * Tinymce Settings
             * */

            tinymce.init({
                selector: 'textarea',
                menubar: false,
                image_title: true,
              /*  automatic_uploads: false,
                images_upload_url: TINY_UPLOAD_PATH,
                file_picker_types: 'image',
                images_upload_credentials: true,*/
                plugins: [
                    'advlist autolink lists link image charmap print preview anchor',
                    'searchreplace visualblocks code fullscreen',
                    'insertdatetime media table contextmenu paste code'
                ],
                toolbar: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | code',
                  file_picker_callback: function (cb, value, meta) {
                 var input = document.createElement('input');
                 input.setAttribute('type', 'file');
                 input.setAttribute('accept', 'image/!*');

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
                 },
                images_upload_handler: function (blobInfo, success, failure) {

                    let formData = new FormData();
                    formData.append('file', blobInfo.blob(), blobInfo.filename());

                    ajax.clean();
                    ajax.url = TINY_UPLOAD_PATH;
                    ajax.data = formData;
                    ajax.cache = false;
                    ajax.async = false;
                    ajax.contentType = false;
                    ajax.processData = false;
                    ajax.type = "POST";
                    ajax.success = (data) => {
                        success(data.location);
                    };
                    $.ajax(ajax);
                    //xhr.send(formData);
                }
            });
        });
    });
};