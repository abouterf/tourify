<?php
// src/Managers/WooCommerceProductSync.php

namespace Abouterf\Tourify\Managers;

use Abouterf\Tourify\Interfaces\ProductSyncInterface;
use Abouterf\Tourify\Models\Tour;

class WooCommerceProductSync implements ProductSyncInterface
{
    /**
     * Sync a Tour with a WooCommerce Product
     *
     * @param Tour $tour
     * @return int The WooCommerce Product ID
     */
    public function sync($tour): int
    {
        // Prevent sync during AJAX requests or auto-saves
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return 0; // Exit if this is an auto-save
        }

        if (defined('DOING_AJAX') && DOING_AJAX) {
            return 0; // Exit if this is an AJAX request
        }

        // Check if WooCommerce is active
        if (!class_exists('WC_Product_Simple')) {
            // Add an admin notice if WooCommerce is not active
            add_action('admin_notices', [$this, 'woocommerce_required_notice']);
            return 0; // Return 0 or handle as necessary to indicate failure
        }

        // Retrieve or create a WooCommerce product
        $product_id = get_post_meta($tour->getId(), '_associated_product_id', true);

        // Check if the product exists and is valid
        $product = $product_id ? wc_get_product($product_id) : null;

        if (!$product || !$product->exists()) {
            // If the product does not exist, create a new one
            $product = new \WC_Product_Simple();
        }

        // Set WooCommerce product details from tour attributes
        $product->set_name($tour->getTitle());
        $product->set_description($tour->getDescription());
        $product->set_price($tour->getPrice());
        $product->set_regular_price($tour->getPrice());

        // Sync additional custom fields
        $product->update_meta_data('_duration', $tour->getDuration());
        $product->update_meta_data('_location', $tour->getLocation());

        // Save the WooCommerce product and update the association
        $product->save();
        update_post_meta($tour->getId(), '_associated_product_id', $product->get_id());


        // Save the WooCommerce product and update the association
        $product->save();
        update_post_meta($tour->getId(), '_associated_product_id', $product->get_id());

        return $product->get_id();
    }

    /**
     * Display an admin notice if WooCommerce is not active
     */
    public function woocommerce_required_notice(): void
    {
        echo '<div class="notice notice-error"><p>' . esc_html__(
                'WooCommerce is required to sync Tour data with WooCommerce products. Please install and activate WooCommerce.',
                'your-text-domain'
            ) . '</p></div>';
    }

}
