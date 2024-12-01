<?php
// config.php

namespace tourify\Config;

class Config {
    // Define database table names
    const TOUR_TABLE = 'ty_tours';
    const ROOM_TABLE = 'ty_rooms';
    const HOTEL_TABLE = 'ty_hotels';
    const FLIGHT_TABLE = 'ty_flights';

    // WooCommerce settings
    const WOO_PRODUCT_TYPE = 'simple';

    // Elementor settings
    const ELEMENTOR_CATEGORY = 'tourify-elements';

    // Other plugin settings
    const PLUGIN_VERSION = '1.0';
    const PLUGIN_SLUG = 'tourify';

}

