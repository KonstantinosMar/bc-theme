<?php

namespace BC\Widgets;

use Timber\Timber;

class StoriesWidget extends \WP_Widget
{
    public function __construct()
    {
        parent::__construct(
            'stories_widget',
            __('Stories Widget', 'bc-theme'),
            array('description' => __('Widget to display a carousel of stories', 'bc-theme'))
        );

    }

    public function form($instance): void {
        $title = isset($instance['title']) ? $instance['title'] : '';
        $items = isset($instance['items']) ? $instance['items'] : array();

        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        </p>
        <div class="title-image-video-clone-items">
            <?php foreach ($items as $index => $item) : ?>
                <div class="title-image-video-clone-item">
                    <h4>Item <?php echo $index + 1; ?></h4>
                    <p>
                        <label for="<?php echo $this->get_field_id('items'); ?>-<?php echo $index; ?>-title"><?php _e('Title:'); ?></label>
                        <input class="widefat" id="<?php echo $this->get_field_id('items'); ?>-<?php echo $index; ?>-title" name="<?php echo $this->get_field_name('items'); ?>[<?php echo $index; ?>][title]" type="text" value="<?php echo esc_attr($item['title']); ?>" />
                    </p>
                    <p>
                        <label for="<?php echo $this->get_field_id('items'); ?>-<?php echo $index; ?>-image"><?php _e('Image:'); ?></label>
                        <input class="widefat media-gallery-clone-image" id="<?php echo $this->get_field_id('items'); ?>-<?php echo $index; ?>-image" name="<?php echo $this->get_field_name('items'); ?>[<?php echo $index; ?>][image_id]" type="hidden" value="<?php echo esc_attr($item['image_id']); ?>" />
                    <div class="media-gallery-clone-images">
                        <?php if (!empty($item['image_id'])) : ?>
                            <div class="image-preview" data-attachment-id="<?php echo esc_attr($item['image_id']); ?>">
                                <?php echo wp_get_attachment_image($item['image_id'], 'thumbnail'); ?>
                                <button class="delete-button">Remove</button>
                            </div>
                        <?php endif; ?>
                    </div>
                    <button class="media-gallery-clone-add-button">Add Image</button>
                    </p>
                    <p>
                        <label for="<?php echo $this->get_field_id('items'); ?>-<?php echo $index; ?>-video"><?php _e('Video:'); ?></label>
                        <input class="widefat media-library-video" id="<?php echo $this->get_field_id('items'); ?>-<?php echo $index; ?>-video" name="<?php echo $this->get_field_name('items'); ?>[<?php echo $index; ?>][video_id]" type="hidden" value="<?php echo esc_attr($item['video_id']); ?>" />
                        <button class="media-library-select-button">Select Video</button>
                        <?php if (!empty($item['video_id'])) : ?>
                            <span class="selected-video"><?php echo esc_html($item['video_id']); ?></span>
                        <?php endif; ?>
                    </p>
                    <p>
                        <label for="<?php echo $this->get_field_id('items'); ?>-<?php echo $index; ?>-extra-field"><?php _e('Extra Field:'); ?></label>
                        <input class="widefat" id="<?php echo $this->get_field_id('items'); ?>-<?php echo $index; ?>-extra-field" name="<?php echo $this->get_field_name('items'); ?>[<?php echo $index; ?>][extra_field]" type="text" value="<?php echo esc_attr($item['extra_field']); ?>" />
                    </p>
                    <hr />
                </div>
            <?php endforeach; ?>
        </div>
        <button class="title-image-video-clone-add-button">Add Item</button>
        <?php
    }

    public function update($new_instance, $old_instance): array {
        $instance = $old_instance;

        $instance['title'] = (!empty($new_instance['title'])) ? sanitize_text_field($new_instance['title']) : '';
        $instance['items'] = (!empty($new_instance['items'])) ? $new_instance['items'] : array();

        return $instance;
    }

    public function widget($args, $instance): void {
        $title = apply_filters('widget_title', $instance['title']);
        $items = !empty($instance['items']) ? $instance['items'] : array();

        echo $args['before_widget'];

        if (!empty($title)) {
            echo $args['before_title'] . $title . $args['after_title'];
        }

        $data = array();

        foreach ($items as $item) {
            $image_url = wp_get_attachment_image_url($item['image_id'], 'thumbnail');
            $video_url = wp_get_attachment_url($item['video_id']);

            $data[] = array(
                'title' => $item['title'],
                'image' => $image_url,
                'video' => $video_url,
                'extra_field' => $item['extra_field'],
            );
        }

        $context = Timber::context();
        $context['data'] = $data;
        Timber::render('partials/title-image-video-widget.twig', $context);

        echo $args['after_widget'];
    }
}
