jQuery(document).ready(function($) {
    $(document).on('click', '.banners-widget-add-button', function(e) {
        e.preventDefault();

        let button = $(this);
        let frame = wp.media({
            title: 'Select Images',
            multiple: true,
            library: {
                type: 'image'
            },
            button: {
                text: 'Select'
            }
        });

        frame.on('select', function() {
            let attachmentIds = [];
            let selection = frame.state().get('selection');
            let imagesContainer = button.siblings('.banners-widget-images');

            imagesContainer.empty();

            selection.forEach(function(attachment) {
                attachmentIds.push(attachment.id);
                let imagePreview = $('' +
                    '<div class="image-preview" data-attachment-id="' + attachment.id + '">' +
                    '<img src="' + attachment.attributes.sizes.thumbnail.url + '" alt="' + attachment.attributes.title + '">' +
                    '<button class="delete-button">Remove</button></div>'
                );
                imagesContainer.append(imagePreview);
            });

            button.siblings('.banners-widget-image-ids').val(attachmentIds.join(',')).trigger('change');
        });

        frame.open();
    });

    $(document).on('click', '.banners-widget-images .delete-button', function() {
        $(this).closest('.image-preview').remove();
        updateAttachmentIds();
        $('.banners-widget-image-ids').trigger('change');
    });

    function updateAttachmentIds() {
        let attachmentIds = [];
        $('.banners-widget-images .image-preview').each(function() {
            let attachmentId = $(this).data('attachment-id');
            attachmentIds.push(attachmentId);
        });
        $('.banners-widget-image-ids').val(attachmentIds.join(',')).trigger('change');
    }
});
