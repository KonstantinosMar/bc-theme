jQuery(document).ready(function($) {
    $(document).on('click', '.stories-widget-add-item-button', function(e) {
        e.preventDefault();

        let button = $(this);
        let cloneItems = button.prev('.stories-widget-items');
        let itemsCount = cloneItems.find('.stories-widget-item').length;
        let itemHtml = '' +
            '<div class="stories-widget-item">' +
            '<h4>Item ' + (itemsCount + 1) + '</h4>' +
            '<p>' +
            '<label for="stories-widget-' + itemsCount + '-title">Title:</label>' +
            '<input class="widefat" id="stories-widget-' + itemsCount + '-title" name="stories-widget[' + itemsCount + '][title]" type="text" value="" />' +
            '</p>' +
            '<p>' +
            '<label for="stories-widget-' + itemsCount + '-image">Image:</label>' +
            '<input class="widefat stories-widget-image" id="stories-widget-' + itemsCount + '-image" name="stories-widget[' + itemsCount + '][image_id]" type="hidden" value="" />' +
            '<div class="stories-widget-images"></div>' +
            '<button class="stories-widget-add-button">Add Image</button>' +
            '</p>' +
            '<p>' +
            '<label for="stories-widget-' + itemsCount + '-video">Video:</label>' +
            '<input class="widefat media-library-video" id="stories-widget-' + itemsCount + '-video" name="stories-widget[' + itemsCount + '][video_id]" type="hidden" value="" />' +
            '<button class="media-library-select-button">Select Video</button>' +
            '</p>' +
            '<p>' +
            '<label for="stories-widget-' + itemsCount + '-views">Views:</label>' +
            '<input class="widefat" id="stories-widget-' + itemsCount + '-views" name="stories-widget[' + itemsCount + '][views]" type="text" value="" />' +
            '</p>' +
            '<hr />' +
            '</div>';

        cloneItems.append(itemHtml);
    });

    $(document).on('click', '.stories-widget-images .delete-button', function() {
        $(this).closest('.image-preview').remove();
        updateAttachmentIds();
        $('.stories-widget-image-ids').trigger('change');
    });

    $(document).on('click', '.media-library-select-button', function(e) {
        e.preventDefault();

        let button = $(this);
        let videoInput = button.prev('.media-library-video');

        let frame = wp.media({
            title: 'Select Video',
            multiple: false,
            library: {
                type: 'video'
            },
            button: {
                text: 'Select'
            }
        });

        frame.on('select', function() {
            let selection = frame.state().get('selection').first();
            videoInput.val(selection.toJSON().url);
            button.next('.selected-video').text(selection.toJSON().url);
        });

        frame.open();
    });

    $(document).on('click', '.stories-widget-add-button', function(e) {
        e.preventDefault();

        let button = $(this);
        let frame = wp.media({
            title: 'Select Image',
            multiple: false,
            library: {
                type: 'image'
            },
            button: {
                text: 'Select'
            }
        });

        frame.on('select', function() {
            let selection = frame.state().get('selection').first();
            let attachmentId = selection.id;
            let imagePreview = $('<div class="image-preview" data-attachment-id="' + attachmentId + '">' +
                selection.attributes.filename +
                '<button class="delete-button">Remove</button>' +
                '</div>');

            button.siblings('.stories-widget-images').empty().append(imagePreview);
            button.siblings('.stories-widget-image').val(attachmentId);
            button.siblings('.stories-widget-image-ids').trigger('change');
        });

        frame.open();
    });

    function updateAttachmentIds() {
        let cloneItems = $('.stories-widget-items');
        cloneItems.find('.stories-widget-item').each(function() {
            let imagesContainer = $(this).find('.stories-widget-images');
            let attachmentIds = [];

            imagesContainer.find('.image-preview').each(function() {
                attachmentIds.push($(this).data('attachment-id'));
            });

            $(this).find('.stories-widget-image').val(attachmentIds.join(','));
        });
    }

    $('.stories-widget-items').sortable({
        axis: 'y',
        handle: 'h4',
        update: function() {
            updateAttachmentIds();
            $('.stories-widget-image-ids').trigger('change');
        }
    });
});
