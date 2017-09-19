<?php

namespace GoogleAnalytics\Admin;

class Settings
{
    public function __construct()
    {
        add_action('admin_menu', array($this, 'addSettingsFields'));
        add_action('wp_ajax_save_account_key', array($this, 'saveAccountKey'));
    }

    /**
     * Callback for the settings page.
     */
    public function analyticsSettingsMarkup()
    {
        if (isset($_REQUEST['track_property']) && current_user_can('manage_options') && wp_verify_nonce($_REQUEST['save-tracked-property'], 'save')) {
            $post = json_decode(stripslashes($_POST['track_property']), true);
            update_option('options_google_analytics_ua', (!empty($post['id']) ? $post['id'] : ''));
            update_option('options_google_analytics_view', (!empty($post['view']) ? $post['view'] : ''));
        }

        $service_key = get_option('_ga_service_account_key');
        $tracked_property = get_option('options_google_analytics_ua');

        $properties = array();
        if ($service_key) {
            // Decode JSON-key as array
            $service_key = json_decode($service_key, true);
            $account_email = (!empty($service_key['client_email'])) ? $service_key['client_email'] : '';

            // Creates a new authenticated Google client
            $client = new \Google_Client();
            $client->setAuthConfig($service_key);
            // Set the scopes required for the API
            $client->addScope(\Google_Service_Analytics::ANALYTICS_READONLY);
            $client->setSubject($account_email);
            $analytics_service = new \Google_Service_Analytics($client);
            $web_properties = $analytics_service->management_webproperties->listManagementWebproperties('~all');

            if (!empty($web_properties->items)) {
                foreach ($web_properties->items as $item) {
                    $properties[] = array(
                                        'id'   => $item->id,
                                        'name' => $item->name,
                                        'view' => $item->defaultProfileId
                                    );
                }
            }
        }

        include GOOGLEANALYTICS_TEMPLATE_PATH . 'settings.php';
    }

    public function saveAccountKey()
    {
        if (!isset($_POST['key'])) {
            wp_send_json_error(__('JSON key contents is missing', 'google-analytics'));
        }
        update_option('_ga_service_account_key', json_encode($_POST['key']));
        wp_send_json_success(__('Request succeeded', 'google-analytics'));
    }

    /**
     * Adds a settings page for Google Analytics.
     */
    public function addSettingsFields()
    {
        add_submenu_page(
            'options-general.php',
            __('Google Analytics', 'google-analytics'),
            __('Google Analytics', 'google-analytics'),
            'manage_options',
            'google-analytics',
            array($this, 'analyticsSettingsMarkup')
        );
    }
}
