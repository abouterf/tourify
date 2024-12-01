<?php

// Ensure Composer autoload is available
if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require_once __DIR__ . '/vendor/autoload.php';
}

use Abouterf\Tourify\Initialization\PostTypeRegistrar;
use Abouterf\Tourify\Initialization\Settings;
use Abouterf\Tourify\Integrations\WooCommerceSetup;
use Abouterf\Tourify\Managers\ActionHandler;
use Abouterf\Tourify\Managers\TourManager;
use Abouterf\Tourify\Managers\WooCommerceProductSync;
use Abouterf\Tourify\Initialization\Options;


function tourify_initialize(): void
{
    load_theme_textdomain('tourify', get_template_directory() . '/languages');
    // Register Custom Post Type
    $postTypeRegistrar = new PostTypeRegistrar();
    add_action('init', [$postTypeRegistrar, 'register']);

    // Initialize WooCommerce integration only if WooCommerce is active
    if (class_exists('WooCommerce')) {
        $wooCommerceSetup = new WooCommerceSetup();
        add_action('init', [$wooCommerceSetup, 'initialize']);
    }

    // Initialize Action Handlers
    $tourManager = new TourManager();
    $productSync = new WooCommerceProductSync();
    $actionHandler = new ActionHandler($tourManager, $productSync);
    $actionHandler->registerActions();

    \Carbon_Fields\Carbon_Fields::boot();

    $options = new Options();
    $options->register();

    $settings = new Settings();
    $settings->register();
}

// Hook tourify_initialize to the 'after_setup_theme' action to ensure theme resources are loaded
add_action('after_setup_theme', 'tourify_initialize');

