<?php

namespace Abouterf\Tourify\Feeder;

use WP_Error;

class FeederService
{
    private $api_url;
    private $post_type;
    private $field_mapping;
    private $method;
    private $auth_type;
    private $auth_credentials;
    private $headers;
    private $body_data;

    public function __construct()
    {
        $this->api_url = carbon_get_theme_option('feeder_api_url');
        $this->post_type = carbon_get_theme_option('feeder_post_type');
        $this->method = carbon_get_theme_option('feeder_http_method') ?: 'GET';
        $this->auth_type = carbon_get_theme_option('feeder_auth_type');
        $this->field_mapping = $this->getFieldMapping();
        $this->headers = $this->getHeaders();
        $this->body_data = carbon_get_theme_option('feeder_body_data') ?: [];
        $this->auth_credentials = $this->getAuthCredentials();
    }

    /**
     * Get authentication credentials based on the selected auth type.
     */
    private function getAuthCredentials(): array
    {
        $auth_credentials = [];

        if ($this->auth_type === 'api_key') {
            $auth_credentials['api_key'] = carbon_get_theme_option('feeder_api_key');
        } elseif ($this->auth_type === 'basic') {
            $auth_credentials['username'] = carbon_get_theme_option('feeder_basic_username');
            $auth_credentials['password'] = carbon_get_theme_option('feeder_basic_password');
        } elseif ($this->auth_type === 'bearer') {
            $auth_credentials['token'] = carbon_get_theme_option('feeder_bearer_token');
        }

        return $auth_credentials;
    }

    /**
     * Get headers from theme options and merge with authentication headers.
     */
    private function getHeaders(): array
    {
        $custom_headers = json_decode(carbon_get_theme_option('feeder_headers'), true) ?? [];
        return array_merge($custom_headers, $this->prepareAuthHeaders());
    }

    /**
     * Prepare authentication headers based on the authentication type.
     */
    private function prepareAuthHeaders(): array
    {
        $auth_headers = [];

        switch ($this->auth_type) {
            case 'api_key':
                $auth_headers['Authorization'] = 'Bearer ' . ($this->auth_credentials['api_key'] ?? '');
                break;
            case 'basic':
                $auth_headers['Authorization'] = 'Basic ' . base64_encode(
                        ($this->auth_credentials['username'] ?? '') . ':' . ($this->auth_credentials['password'] ?? '')
                    );
                break;
            case 'bearer':
                $auth_headers['Authorization'] = 'Bearer ' . ($this->auth_credentials['token'] ?? '');
                break;
        }

        return $auth_headers;
    }

    /**
     * Get field mappings from theme options, organized as a key-value pair.
     */
    private function getFieldMapping(): array
    {
        $mapping = [];
        $field_mapping = carbon_get_theme_option('feeder_field_mapping') ?? [];

        foreach ($field_mapping as $field) {
            if (!empty($field['api_field']) && !empty($field['wp_field'])) {
                $mapping[$field['api_field']] = $field['wp_field'];
            }
        }

        return $mapping;
    }

    /**
     * Fetch data from the API based on the method (GET or POST).
     */
    public function fetchData(): array|false
    {
        $args = [
            'method' => $this->method,
            'headers' => $this->headers,
        ];

        if ($this->method === 'POST') {
            $args['body'] = $this->body_data;
        }

        $response = wp_remote_request($this->api_url, $args);

        if (is_wp_error($response)) {
            error_log('API fetch error: ' . $response->get_error_message());
            return false;
        }

        $body = wp_remote_retrieve_body($response);
        return json_decode($body, true);
    }

    /**
     * Map API data to WordPress post fields based on the field mapping.
     */
    private function mapDataToPost(array $data): array
    {
        $post_data = [];
        foreach ($this->field_mapping as $api_field => $post_field) {
            $post_data[$post_field] = $data[$api_field] ?? null;
        }
        return $post_data;
    }

    /**
     * Create or update a WordPress post with mapped data.
     */
    public function createOrUpdatePost(array $data): WP_Error|bool|int
    {
        $post_data = $this->mapDataToPost($data);

        $post_id = wp_insert_post([
            'post_type' => $this->post_type,
            'post_title' => $post_data['title'] ?? 'Default Title',
            'post_content' => $post_data['description'] ?? '',
            'post_status' => 'publish',
        ]);

        if (is_wp_error($post_id)) {
            error_log('Post insertion error: ' . $post_id->get_error_message());
            return false;
        }

        // Update custom fields
        foreach ($post_data as $key => $value) {
            update_post_meta($post_id, $key, $value);
        }

        return $post_id;
    }

    /**
     * Process the feed by fetching data and inserting posts.
     */
    public function processFeed(): void
    {
        $data = $this->fetchData();
        if (!$data || !is_array($data)) {
            error_log('No data retrieved or invalid format from API.');
            return;
        }

        foreach ($data as $item) {
            $this->createOrUpdatePost($item);
        }
    }
}
