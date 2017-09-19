<?php

namespace GoogleAnalytics;

class App
{
    public function __construct()
    {
        new Admin\Settings();
        new Admin\Dashboard();

        add_action('wp_enqueue_scripts', array($this, 'googleAnalytics'), 999);
        add_action('admin_enqueue_scripts', array($this, 'enqueueScripts'));
    }

    /**
     * Enqueue Google Analytics
     * @return void
     */
    public function googleAnalytics()
    {
        $gaUser = apply_filters('GoogleAnalytics/TrackingId/ua', get_option('options_google_analytics_ua'));

        if (empty($gaUser)) {
            return;
        }

        wp_enqueue_script('google-analytics', 'https://www.google-analytics.com/analytics.js', '', '1.0.0', true);
        add_filter('script_loader_tag', function ($tag, $handle) use ($gaUser) {
            if ($handle != 'google-analytics') {
                return $tag;
            }

            $ga = "<script>
                        window.ga=function(){ga.q.push(arguments)};ga.q=[];ga.l=+new Date;
                        ga('create','" . $gaUser . "','auto');ga('send','pageview')
                    </script>";

            return $ga . str_replace(' src', ' async defer src', $tag);
        }, 10, 2);
    }

    /**
     * Enqueue admin scripts
     * @return void
     */
    public function enqueueScripts()
    {
        $screen = get_current_screen();
        if ($screen->base != 'dashboard' && $screen->base != 'settings_page_google-analytics') {
            return;
        }

        $property_view = get_option('options_google_analytics_view');

        wp_enqueue_script('google-analytics', GOOGLEANALYTICS_URL . '/dist/js/google-analytics.min.js', '', '1.0.0', true);
        wp_localize_script('google-analytics', 'googleanalytics', array(
            'google_analytics_view' => $property_view,
            'invalid_json' => __('Not valid JSON', 'google-analytics')
        ));
        wp_enqueue_script('google-analytics');

        add_filter('script_loader_tag', function ($tag, $handle) {
            if ($handle != 'google-analytics') {
                return $tag;
            }

            $embed_script = "
            <script type='text/javascript' src='https://www.google.com/jsapi'></script>
            <script>
                    (function(w,d,s,g,js,fs){
                        g=w.gapi||(w.gapi={});g.analytics={q:[],ready:function(f){this.q.push(f);}};
                        js=d.createElement(s);fs=d.getElementsByTagName(s)[0];
                        js.src='https://apis.google.com/js/platform.js';
                        fs.parentNode.insertBefore(js,fs);js.onload=function(){g.load('analytics');};
                    }(window,document,'script'));
                </script>";

            return $embed_script . str_replace(' src', ' async defer src', $tag);
        }, 10, 2);
    }
}
