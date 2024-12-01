<?php
// src/Managers/TourManager.php

namespace Abouterf\Tourify\Managers;

use Abouterf\Tourify\Models\Tour;
use WP_Post;
use Carbon_Fields\Carbon_Fields;

class TourManager {
    /**
     * Create a Tour model from a WordPress Post
     *
     * @param WP_Post $post The WordPress post object
     * @return Tour
     */
    public function createTourFromPost(WP_Post $post): Tour {
        // Use Carbon Fields to get post meta
        $price = (float) carbon_get_post_meta($post->ID, 'price'); // Cast to float
        $duration = carbon_get_post_meta($post->ID, 'duration');
        $location = carbon_get_post_meta($post->ID, 'location');

        return new Tour(
            $post->ID,
            $post->post_title,
            $post->post_content,
            $price,
            $duration,
            $location
        );
    }

    /**
     * Save Tour data to the database
     *
     * @param Tour $tour
     */
    public function saveTour(Tour $tour) {
        wp_update_post([
            'ID' => $tour->getId(),
            'post_title' => $tour->getTitle(),
            'post_content' => $tour->getDescription(),
        ]);

        // Since Carbon Fields is initialized to use update_post_meta, we continue using it here
        update_post_meta($tour->getId(), 'price', $tour->getPrice());
        update_post_meta($tour->getId(), 'duration', $tour->getDuration());
        update_post_meta($tour->getId(), 'location', $tour->getLocation());
    }

    /**
     * Get a Tour model by ID
     *
     * @param int $tourId
     * @return Tour|null
     */
    public function getTourById($tourId): ?Tour {
        $post = get_post($tourId);
        if ($post && $post->post_type === 'tour') {
            return $this->createTourFromPost($post);
        }
        return null;
    }

    /**
     * Delete a Tour
     *
     * @param int $tourId
     * @return bool True if deleted, false otherwise
     */
    public function deleteTour($tourId): bool {
        $deleted = wp_delete_post($tourId, true);
        return $deleted !== false;
    }
}
