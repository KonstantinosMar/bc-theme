<?php

class BcTheme
{

    public function __construct() {
        $this->setupTimber();
        add_action('wp_enqueue_scripts', [$this, 'registerScripts']);
        add_action('admin_enqueue_scripts', [$this, 'registerAdminScripts']);

        add_action('widgets_init', [$this, 'registerWidgetArea']);
        add_action('widgets_init', [$this, 'addWidgets']);
        add_filter('timber/context', [$this, 'addToContext']);
        $this->checkPrimaryMenuExists();
        add_action('wp_nav_menu_item_custom_fields', [$this, 'addCustomMenuMeta']);
        add_action('wp_update_nav_menu_item', [$this, 'saveCustomMenuMeta']);

    }

    public function setupTimber(): void {
        $composer_autoload = __DIR__ . '/vendor/autoload.php';
        if ( file_exists($composer_autoload) ) {
            require_once $composer_autoload;
            new Timber\Timber();
        }
        Timber\Timber::$dirname = array('templates', 'views');
        Timber\Timber::$autoescape = false;
    }

    public function registerScripts(): void {
        $cssFilePath = glob(get_template_directory() . '/css/build/main.min.*.css');
        $cssFileURI = get_template_directory_uri() . '/css/build/' . basename($cssFilePath[0]);
        wp_enqueue_style('main_css', $cssFileURI);

        $jsFilePath = glob(get_template_directory() . '/js/build/main.min.*.js');
        $jsFileURI = get_template_directory_uri() . '/js/build/' . basename($jsFilePath[0]);
        wp_enqueue_script('main_js', $jsFileURI, ['jquery'], NULL, true);
    }

    public function registerAdminScripts($hook) {
        if ($hook === 'widgets.php') {
            wp_enqueue_media();
            wp_enqueue_script('banners-widget-script', get_template_directory_uri() . '/js/widgets/banners-widget-script.js', array('jquery'), '1.0', true);
            wp_enqueue_script('stories-widget-script', get_template_directory_uri() . '/js/widgets/stories-widget-script.js', array('jquery'), '1.0', true);
        }
    }

    public function registerWidgetArea(): void {
        register_sidebar(array(
            'name' => 'Homepage widget area',
            'id' => 'custom-homepage-widget',
            'before_widget' => '<div class="home-widget-area">',
            'after_widget' => '</div>',
            'before_title' => '<h2 class="home-widget-title">',
            'after_title' => '</h2>',
        ));
    }

    public function addWidgets(): void {
        register_widget('\BC\Widgets\BannersWidget');
        register_widget('\BC\Widgets\StoriesWidget');
    }

    public function addToContext( $context ): array {
        $context['menu'] = new Timber\Menu('primary-menu');
        $context['imageUrls'] = [
            'logo' => get_template_directory_uri() . '/img/svg/logo.svg',
            'burger' => get_template_directory_uri() . '/img/svg/burger.svg',
            'chat' => get_template_directory_uri() . '/img/svg/chat.svg',
            'search' => get_template_directory_uri() . '/img/svg/search.svg',
            'rightArrow' => get_template_directory_uri() . '/img/svg/rightArrow.svg',
        ];

        return $context;
    }

    private function checkPrimaryMenuExists(): void {
        $menuExists = wp_get_nav_menu_object('primary-menu');
        if ( !$menuExists ) {
            require_once( 'create-default-menu.php' );
        }
    }

    public function addCustomMenuMeta( $itemId, $item ): void {
        wp_nonce_field('custom_menu_meta_nonce', '_custom_menu_meta_nonce_name');
        $menuMeta = get_post_meta($itemId, '_custom_menu_meta', true);
        ?>
        <div class="field-custom_menu_meta description-wide">
            <span class="description"><?php _e("Menu Icon URL", 'custom-menu-meta'); ?></span>
            <br/>
            <input type="hidden" class="nav-menu-id" value="<?php echo $itemId; ?>"/>
            <div class="logged-input-holder">
                <input type="text" name="custom_menu_meta[<?php echo $itemId; ?>][icon]"
                       id="menu-icon-<?php echo $itemId; ?>"
                       value="<?php echo esc_attr($menuMeta['icon']); ?>"/>
            </div>
        </div>
        <?php
    }

    public function saveCustomMenuMeta( $menuId, $menuItemId ): int {
        if ( !isset($_POST['_custom_menu_meta_nonce_name']) || !wp_verify_nonce($_POST['_custom_menu_meta_nonce_name'], 'custom_menu_meta_nonce') ) {
            return $menuId;
        }

        if ( isset($_POST['custom_menu_meta'][$menuItemId]) ) {
            $sanitized_data = $_POST['custom_menu_meta'][$menuItemId];
            update_post_meta($menuItemId, '_custom_menu_meta', $sanitized_data);
        } else {
            delete_post_meta($menuItemId, '_custom_menu_meta');
        }

        return $menuId;
    }
}

new BcTheme();
