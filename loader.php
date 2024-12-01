<?php
// loader.php

// Autoload all classes using Composer
require_once __DIR__ . '/vendor/autoload.php';

// Register and initialize core components
function tourify_load_core_components(): void
{
    // Load configuration
    require_once __DIR__ . '/config.php';

    // Initialize core components
    tourify_initialize_components();
}

// Core initialization function
function tourify_initialize_components() {
    // Placeholder for initializing components
    // Example: Register custom post types, widgets, etc.
}

// Call to load core components when WordPress initializes plugins
add_action('plugins_loaded', 'tourify_load_core_components');
