<?php

namespace BC\Widgets;
use Timber\Timber;

class BannersWidget extends \WP_Widget
{
    function __construct() {
        parent::__construct(
            'banners_widget',
            __('Banners Widget', 'bc-theme'),
            array('description' => __('Widget to display a carousel of images', 'v'))
        );

    }


    public function form($instance): void {
        $image_ids = explode(',', $instance['image_ids']);
        $image_html = '';

        foreach ($image_ids as $image_id) {
            $image_url = wp_get_attachment_image_url($image_id, 'thumbnail');
            if ($image_url) {
                $image_html .= '<div class="image-preview" data-attachment-id="' . $image_id . '">
                    <img src="' . esc_url($image_url) . '" alt="">
                    <button class="delete-button">Remove</button>
                </div>';
            }
        }
        ?>
        <div class="banners-widget-images"><?php echo $image_html; ?></div>
        <input type="hidden" class="banners-widget-image-ids" name="<?php echo $this->get_field_name('image_ids'); ?>" value="<?php echo esc_attr($instance['image_ids']); ?>">
        <button class="banners-widget-add-button">Add Images</button>
        <?php
    }

    public function update($new_instance, $old_instance): array {
        $instance = $old_instance;

        $instance['image_ids'] = (!empty($new_instance['image_ids'])) ? sanitize_text_field($new_instance['image_ids']) : '';

        return $instance;
    }

    public function widget($args, $instance): void {
        $image_ids = explode(',', $instance['image_ids']);

        echo $args['before_widget'];

        $images = array();
        foreach ($image_ids as $image_id) {
            $image_url = wp_get_attachment_image_url($image_id, 'full');
            if ($image_url) {
                $images[] = array(
                    'image' => $image_url,
                );
            }
        }

        $context = Timber::context();
        $context['data'] = $images;
        $context['class'] = 'banners';
        Timber::render('partials/carousel.twig', $context);

        echo $args['after_widget'];
    }
}