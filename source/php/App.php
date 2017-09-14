<?php

namespace GoogleAnalytics;

class App
{
    public function __construct()
    {
        new Options();
        new Dashboard();

        add_action('wp_enqueue_scripts', array($this, 'googleAnalytics'), 999);
        add_action('admin_enqueue_scripts', array($this, 'enqueueStyles'));
        add_action('admin_enqueue_scripts', array($this, 'enqueueScripts'));
    }

    /**
     * Enqueue Google Analytics
     * @return void
     */
    public function googleAnalytics()
    {
        $gaUser = apply_filters('GoogleAnalytics/TrackingId/ua', get_field('google_analytics_ua', 'option'));

        if (empty($gaUser)) {
            return;
        }

        wp_register_script('google-analytics', 'https://www.google-analytics.com/analytics.js', '', '1.0.0', true);
        wp_enqueue_script('google-analytics');

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
     * Enqueue required style
     * @return void
     */
    public function enqueueStyles()
    {

    }

    /**
     * Enqueue required scripts
     * @return void
     */
    public function enqueueScripts()
    {
        wp_register_script('analytics-dashboard', GOOGLEANALYTICS_URL . '/dist/js/google-analytics.dev.js', '', '1.0.0', true);
        wp_enqueue_script('analytics-dashboard');

        add_filter('script_loader_tag', function ($tag, $handle) {
            if ($handle != 'analytics-dashboard') {
                return $tag;
            }

            $lib = "<script>
                        (function(w,d,s,g,js,fs){
                          g=w.gapi||(w.gapi={});g.analytics={q:[],ready:function(f){this.q.push(f);}};
                          js=d.createElement(s);fs=d.getElementsByTagName(s)[0];
                          js.src='https://apis.google.com/js/platform.js';
                          fs.parentNode.insertBefore(js,fs);js.onload=function(){g.load('analytics');};
                        }(window,document,'script'));
                    </script>";

            return $lib . str_replace(' src', ' async defer src', $tag);
        }, 10, 2);

    }
}
