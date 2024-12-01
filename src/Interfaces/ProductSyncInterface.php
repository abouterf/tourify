<?php
// src/Interfaces/ProductSyncInterface.php

namespace Abouterf\Tourify\Interfaces;

interface ProductSyncInterface {
    /**
     * Sync a model (e.g., Tour, Room, Flight) with a WooCommerce Product
     *
     * @return int The WooCommerce Product ID
     */
    public function sync(object $model): int;
}
