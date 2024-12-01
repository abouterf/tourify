<?php

namespace Abouterf\Tourify\Initialization;

use Carbon_Fields\Container;
use Carbon_Fields\Field;
use WP_Query;

class Options
{
    /**
     * Initialize Carbon Fields and register custom fields
     */
    public function register(): void
    {
        // Initialize Carbon Fields
        add_action('carbon_fields_register_fields', [$this, 'registerTourFields']);
        add_action('carbon_fields_register_fields', [$this, 'registerRoomFields']);
        add_action('carbon_fields_register_fields', [$this, 'registerHotelFields']);
        add_action('carbon_fields_register_fields', [$this, 'registerFlightFields']);
    }

    /**
     * Register custom fields for Tours
     */
    public function registerTourFields(): void
    {
        Container::make('post_meta', __('Tour Details', 'tourify'))
            ->where('post_type', '=', 'tour')
            ->add_fields([
                Field::make('text', 'price', __('Price'))
                    ->set_attribute('type', 'number')
                    ->set_help_text('Set the price for the tour.'),
                Field::make('text', 'duration', __('Duration'))
                    ->set_help_text('Specify the duration of the tour (e.g., 3 days).'),
                Field::make('multiselect', 'location', __('Location'))
                    ->set_options($this->getPostsList('location'))
                    ->set_help_text('Choose the location associated with this hotel.'),
            ]);
    }

    /**
     * Register custom fields for Rooms
     */
    public function registerRoomFields(): void
    {
        Container::make('post_meta', __('Room Details', 'tourify'))
            ->where('post_type', '=', 'room')
            ->add_fields([
                Field::make('text', 'price', __('Price'))
                    ->set_attribute('type', 'number')
                    ->set_help_text('Set the price per night.'),
                Field::make('date', 'check_in', __('Check-In Date'))
                    ->set_help_text('Select the check-in date.'),
                Field::make('date', 'check_out', __('Check-Out Date'))
                    ->set_help_text('Select the check-out date.'),
                Field::make('select', 'room_type', __('Room Type'))
                    ->add_options([
                        'single' => 'Single',
                        'double' => 'Double',
                        'suite' => 'Suite',
                    ])
                    ->set_help_text('Choose the room type.'),
                Field::make('select', 'hotel', __('Hotel'))
                    ->set_options($this->getPostsList('hotel'))
                    ->set_help_text('Choose the associated hotel for this room.'),
            ]);
    }

    /**
     * Register custom fields for Hotels
     */
    public function registerHotelFields(): void
    {
        Container::make('post_meta', __('Hotel Details', 'tourify'))
            ->where('post_type', '=', 'hotel')
            ->add_fields([
                Field::make('text', 'address', __('Address'))
                    ->set_help_text('Specify the hotel address.'),
                Field::make('textarea', 'amenities', __('Amenities'))
                    ->set_help_text('List the amenities available at the hotel.'),
                Field::make('select', 'location', __('Location'))
                    ->set_options($this->getPostsList('location'))
                    ->set_help_text('Choose the location associated with this hotel.'),
            ]);
    }

    /**
     * Register custom fields for Flights
     */
    public function registerFlightFields(): void
    {
        Container::make('post_meta', __('Flight Details', 'tourify'))
            ->where('post_type', '=', 'flight')
            ->add_fields([
                Field::make('text', 'airline', __('Airline'))
                    ->set_help_text('Specify the airline for the flight.'),
                Field::make('date_time', 'departure', __('Departure Date & Time'))
                    ->set_picker_options(['enableTime' => true, 'dateFormat' => 'Y-m-d H:i'])
                    ->set_help_text('Specify the departure date and time.'),
                Field::make('date_time', 'arrival', __('Arrival Date & Time'))
                    ->set_picker_options(['enableTime' => true, 'dateFormat' => 'Y-m-d H:i'])
                    ->set_help_text('Specify the arrival date and time.'),
            ]);
    }


    /**
     * Utility function to get a list of posts as an array of ID => Title pairs for select fields
     * @param string $post_type
     * @return array
     */
    private function getPostsList(string $post_type): array
    {
        $query = new WP_Query([
            'post_type' => $post_type,
            'posts_per_page' => -1,
            'post_status' => 'publish',
        ]);

        $posts_list = [];
        if ($query->have_posts()) {
            foreach ($query->posts as $post) {
                $posts_list[$post->ID] = $post->post_title;
            }
        }
        wp_reset_postdata();

        return $posts_list;
    }
}
