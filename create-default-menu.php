<?php
$menuName = 'primary-menu';

$menuItems = [
    "home" => [
        'title' => 'Home',
        'url' => '/',
        'icon' => get_template_directory_uri() . '/img/svg/menu-icons/home.svg'
    ],
    "sports" => [
        'title' => 'Sports',
        'url' => '/sports',
        'icon' => get_template_directory_uri() . '/img/svg/menu-icons/sports.svg'
    ],
    "news" => [
        'title' => 'News',
        'url' => '/news',
        'icon' => get_template_directory_uri() . '/img/svg/menu-icons/news.svg'
    ],
    "favorites" => [
        'title' => 'Favorites',
        'url' => '/favorites',
        'icon' => get_template_directory_uri() . '/img/svg/menu-icons/favorites.svg'
    ],
    "stats" => [
        'title' => 'Stats',
        'url' => '/stats',
        'icon' => get_template_directory_uri() . '/img/svg/menu-icons/stats.svg'
    ],
    "graphs" => [
        'title' => 'Graphs',
        'url' => '/graphs',
        'icon' => get_template_directory_uri() . '/img/svg/menu-icons/graphs.svg'
    ],
    "transfer" => [
        'title' => 'Transfer',
        'url' => '/transfer',
        'icon' => get_template_directory_uri() . '/img/svg/menu-icons/transfer.svg'
    ],
    "casino" => [
        'title' => 'Casino',
        'url' => '/casino',
        'icon' => get_template_directory_uri() . '/img/svg/menu-icons/casino.svg'
    ],
    "gifts" => [
        'title' => 'Gifts',
        'url' => '/gifts',
        'icon' => get_template_directory_uri() . '/img/svg/menu-icons/gifts.svg'
    ],
];

$menu_id = wp_create_nav_menu($menuName);

foreach ( $menuItems as $menuKey => $menuItem ) {
    $itemId = wp_update_nav_menu_item($menu_id, 0, array(
        'menu-item-title' => $menuItem['title'],
        'menu-item-classes' => $menuKey,
        'menu-item-url' => home_url($menuItem['url']),
        'menu-item-status' => 'publish'
    ));

    $sanitized_data = ['icon' => $menuItem['icon']];
    update_post_meta($itemId, '_custom_menu_meta', $sanitized_data);
}




