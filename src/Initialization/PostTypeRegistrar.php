<?php

namespace Abouterf\Tourify\Initialization;

/**
 *
 */
class PostTypeRegistrar {
    /**
     * @return void
     */
    public function register(): void
    {
        $this->registerTourPostType();
        $this->registerLocationPostType();
        $this->registerHotelPostType();
        $this->registerRoomPostType();
        $this->registerFlightPostType();
    }

    /**
     * @return void
     */
    private function registerTourPostType(): void
    {
        register_post_type('tour', [
            'labels' => [
                'name' => __('Tours', 'tourify'),
                'singular_name' => __('Tour', 'tourify'),
                'add_new' => __('Add New Tour', 'tourify'),
                'add_new_item' => __('Add New Tour', 'tourify'),
                'edit_item' => __('Edit Tour', 'tourify'),
                'new_item' => __('New Tour', 'tourify'),
                'view_item' => __('View Tour', 'tourify'),
                'search_items' => __('Search Tours', 'tourify'),
                'not_found' => __('No Tours found', 'tourify'),
                'all_items' => __('All Tours', 'tourify'),
            ],
            'public' => true,
            'has_archive' => true,
            'supports' => ['title', 'editor', 'thumbnail', 'custom-fields'],
            'show_in_menu' => true,
            'rewrite' => ['slug' => 'tours'],
            'menu_icon' => 'dashicons-location-alt',
        ]);
    }

    /**
     * @return void
     */
    private function registerLocationPostType(): void
    {
        register_post_type('location', [
            'labels' => [
                'name' => __('Locations', 'tourify'),
                'singular_name' => __('Location', 'tourify'),
                'add_new' => __('Add New Location', 'tourify'),
                'add_new_item' => __('Add New Location', 'tourify'),
                'edit_item' => __('Edit Location', 'tourify'),
                'new_item' => __('New Location', 'tourify'),
                'view_item' => __('View Location', 'tourify'),
                'search_items' => __('Search Locations', 'tourify'),
                'not_found' => __('No Locations found', 'tourify'),
                'all_items' => __('All Locations', 'tourify'),
            ],
            'public' => true,
            'has_archive' => true,
            'supports' => ['title', 'editor', 'thumbnail', 'custom-fields'],
            'show_in_menu' => true,
            'rewrite' => ['slug' => 'locations'],
            'menu_icon' => 'dashicons-location',
        ]);
    }

    /**
     * @return void
     */
    private function registerHotelPostType(): void
    {
        register_post_type('hotel', [
            'labels' => [
                'name' => __('Hotels', 'tourify'),
                'singular_name' => __('Hotel', 'tourify'),
                'add_new' => __('Add New Hotel', 'tourify'),
                'add_new_item' => __('Add New Hotel', 'tourify'),
                'edit_item' => __('Edit Hotel', 'tourify'),
                'new_item' => __('New Hotel', 'tourify'),
                'view_item' => __('View Hotel', 'tourify'),
                'search_items' => __('Search Hotels', 'tourify'),
                'not_found' => __('No Hotels found', 'tourify'),
                'all_items' => __('All Hotels', 'tourify'),
            ],
            'public' => true,
            'has_archive' => true,
            'supports' => ['title', 'editor', 'thumbnail', 'custom-fields'],
            'show_in_menu' => true,
            'rewrite' => ['slug' => 'hotels'],
            'menu_icon' => 'dashicons-building',
        ]);
    }

    /**
     * @return void
     */
    private function registerRoomPostType(): void
    {
        register_post_type('room', [
            'labels' => [
                'name' => __('Rooms', 'tourify'),
                'singular_name' => __('Room', 'tourify'),
                'add_new' => __('Add New Room', 'tourify'),
                'add_new_item' => __('Add New Room', 'tourify'),
                'edit_item' => __('Edit Room', 'tourify'),
                'new_item' => __('New Room', 'tourify'),
                'view_item' => __('View Room', 'tourify'),
                'search_items' => __('Search Rooms', 'tourify'),
                'not_found' => __('No Rooms found', 'tourify'),
                'all_items' => __('All Rooms', 'tourify'),
            ],
            'public' => true,
            'has_archive' => true,
            'supports' => ['title', 'editor', 'thumbnail', 'custom-fields'],
            'show_in_menu' => true,
            'rewrite' => ['slug' => 'rooms'],
            'menu_icon' => 'dashicons-admin-home',
        ]);
    }

    /**
     * @return void
     */
    private function registerFlightPostType(): void
    {
        register_post_type('flight', [
            'labels' => [
                'name' => __('Flights', 'tourify'),
                'singular_name' => __('Flight', 'tourify'),
                'add_new' => __('Add New Flight', 'tourify'),
                'add_new_item' => __('Add New Flight', 'tourify'),
                'edit_item' => __('Edit Flight', 'tourify'),
                'new_item' => __('New Flight', 'tourify'),
                'view_item' => __('View Flight', 'tourify'),
                'search_items' => __('Search Flights', 'tourify'),
                'not_found' => __('No Flights found', 'tourify'),
                'all_items' => __('All Flights', 'tourify'),
            ],
            'public' => true,
            'has_archive' => true,
            'supports' => ['title', 'editor', 'thumbnail', 'custom-fields'],
            'show_in_menu' => true,
            'rewrite' => ['slug' => 'flights'],
            'menu_icon' => 'dashicons-airplane',
        ]);
    }
}
