<?php

namespace Abouterf\Tourify\Managers;

use Abouterf\Tourify\Managers\TourManager;
use Abouterf\Tourify\Managers\WooCommerceProductSync;

/**
 *
 */
class ActionHandler {
    /**
     * @var \Abouterf\Tourify\Managers\TourManager
     */
    protected $tourManager;
    /**
     * @var \Abouterf\Tourify\Managers\WooCommerceProductSync
     */
    protected $productSync;

    /**
     * @param \Abouterf\Tourify\Managers\TourManager $tourManager
     * @param \Abouterf\Tourify\Managers\WooCommerceProductSync $productSync
     */
    public function __construct(TourManager $tourManager, WooCommerceProductSync $productSync) {
        $this->tourManager = $tourManager;
        $this->productSync = $productSync;
    }

    /**
     * @return void
     */
    public function registerActions(): void
    {
        add_action('save_post_tour', [$this, 'syncTourToProduct']);
    }

    /**
     * @param $post_id
     * @return void
     */
    public function syncTourToProduct($post_id): void
    {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

        $tour = $this->tourManager->createTourFromPost(get_post($post_id));
        $this->productSync->sync($tour);
    }
}
