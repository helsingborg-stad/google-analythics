GoogleAnalytics = GoogleAnalytics || {};
GoogleAnalytics.Admin = GoogleAnalytics.Admin || {};

GoogleAnalytics.Admin.Dashboard = (function ($) {

    function Dashboard() {
        if (pagenow !== 'dashboard') {
            return;
        }

        // Get access token and initialize analytics data chart
        $.when($.ajax({
            url: ajaxurl,
            type: 'post',
            data: {
                action : 'fetch_access_token'
            }
        })).then(function(data, textStatus, jqXHR) {
            gapi.analytics.ready(function() {
                // Authorize the user with an access token
                gapi.analytics.auth.authorize({
                    'serverAuth': {
                    'access_token': data
                    }
                });

                // Creates a new DataChart instance showing sessions
                var dataChart = new gapi.analytics.googleCharts.DataChart({
                    query: {
                        'ids': 'ga:' + googleanalytics.google_analytics_view,
                        'start-date': '30daysAgo',
                        'end-date': 'today',
                        'metrics': 'ga:sessions,ga:users',
                        'dimensions': 'ga:date'
                    },
                    chart: {
                        'container': 'line-chart-container',
                        'type': 'LINE',
                        'options': {
                            'width': '100%'
                        }
                    }
                });
                dataChart.execute();
            });
        });
    }

    return new Dashboard();

})(jQuery);
