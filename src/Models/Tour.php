<?php
// src/Models/Tour.php

namespace Abouterf\Tourify\Models;

class Tour {
    private int $id;
    private string $title;
    private string $description;
    private float $price;
    private string $duration;
    private string $location;

    /**
     * Tour constructor.
     *
     * @param int $id
     * @param string $title
     * @param string $description
     * @param float $price
     * @param string $duration
     * @param string $location
     */
    public function __construct(int $id, string $title, string $description, float $price, string $duration, string $location) {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->price = $price;
        $this->duration = $duration;
        $this->location = $location;
    }

    // Getter methods

    /**
     * Get the tour ID
     *
     * @return int
     */
    public function getId(): int {
        return $this->id;
    }

    /**
     * Get the tour title
     *
     * @return string
     */
    public function getTitle(): string {
        return $this->title;
    }

    /**
     * Get the tour description
     *
     * @return string
     */
    public function getDescription(): string {
        return $this->description;
    }

    /**
     * Get the tour price
     *
     * @return float
     */
    public function getPrice(): float {
        return $this->price;
    }

    /**
     * Get the tour duration
     *
     * @return string
     */
    public function getDuration(): string {
        return $this->duration;
    }

    /**
     * Get the tour location
     *
     * @return string
     */
    public function getLocation(): string {
        return $this->location;
    }

    // Additional lightweight logic related to the tour can be added here
}
