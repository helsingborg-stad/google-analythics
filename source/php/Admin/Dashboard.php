<?php

namespace GoogleAnalytics\Admin;

class Dashboard
{
    public function __construct()
    {
        add_action('wp_dashboard_setup', array($this, 'createDashboardWidgets'));
        add_action('wp_ajax_fetch_access_token', array($this, 'fetchAccessToken'));
    }

    /**
     * Add widget to the dashboard.
     * @return void
     */
    public function createDashboardWidgets()
    {
        if (! get_option('options_google_analytics_view')) {
            return;
        }

        wp_add_dashboard_widget(
            'google_analytics',
            'Google Analytics',
            array($this, 'dashboardCallback')
        );
    }

    /**
     * Dislay div container
     * @return void
     */
    public function dashboardCallback()
    {
        echo '<div id="line-chart-container"></div>';
    }

    /**
     * Ajax method to fetch access token from Google Analytics
     */
    public function fetchAccessToken()
    {
        $service_key = json_decode(get_option('options_google_analytics_acc_key'), true);
        $account_email = (!empty($service_key['client_email'])) ? $service_key['client_email'] : '';
        $access_token = '';

        if ($service_key && $account_email) {
            $sa = new \Google\Auth\Credentials\ServiceAccountCredentials(
                'https://www.googleapis.com/auth/analytics.readonly',
                $service_key,
                $account_email
            );

            $fetch_token = $sa->fetchAuthToken();
            if (!empty($fetch_token['access_token'])) {
                $access_token = $fetch_token['access_token'];
            }
        }

        echo $access_token;
        wp_die();
    }
}
