<?php

namespace Abouterf\Tourify\Integrations;

/**
 *
 */
class WooCommerceSetup {
    /**
     * @return void
     */
    public function initialize(): void
    {
        add_action('woocommerce_product_options_general_product_data', [$this, 'addProductMetaFields']);
        add_action('woocommerce_process_product_meta', [$this, 'saveProductMetaFields']);
    }

    /**
     * @return void
     */
    public function addProductMetaFields(): void
    {
        woocommerce_wp_text_input([
            'id' => '_duration',
            'label' => __('Duration', 'tourify'),
            'description' => __('Duration of the tour.', 'tourify'),
        ]);
        woocommerce_wp_text_input([
            'id' => '_location',
            'label' => __('Location', 'tourify'),
            'description' => __('Location of the tour.', 'tourify'),
        ]);
    }

    /**
     * @param $post_id
     * @return void
     */
    public function saveProductMetaFields($post_id): void
    {
        if (isset($_POST['_duration'])) {
            update_post_meta($post_id, '_duration', sanitize_text_field($_POST['_duration']));
        }
        if (isset($_POST['_location'])) {
            update_post_meta($post_id, '_location', sanitize_text_field($_POST['_location']));
        }
    }
}
