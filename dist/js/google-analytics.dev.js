var GoogleAnalytics = {};

GoogleAnalytics = GoogleAnalytics || {};
GoogleAnalytics.Admin = GoogleAnalytics.Admin || {};

GoogleAnalytics.Admin.Dashboard = (function ($) {

    function Dashboard() {
        if (pagenow !== 'dashboard' || !googleanalytics.google_analytics_view) {
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

GoogleAnalytics = GoogleAnalytics || {};
GoogleAnalytics.Admin = GoogleAnalytics.Admin || {};

GoogleAnalytics.Admin.Settings = (function ($) {

    function Settings() {
        $(function(){
            this.handleEvents();
        }.bind(this));
    }

    Settings.prototype.saveAccountKey = function(key) {
        $.ajax({
            url: ajaxurl,
            type: 'post',
            data: {
                action : 'save_account_key',
                key    : key
            },
            success: function(response) {
                if (response.success) {
                    location.reload();
                } else {
                    $('.notice').addClass('error').removeClass('updated').empty().append('<p>' + response.data + '</p>').show();
                }
            }
        });
    };

    /**
     * Handle events
     * @return {void}
     */
    Settings.prototype.handleEvents = function () {
        $("#save-service-account").submit(function(e) {
            e.preventDefault();
            var key = $('[name="service_account_key"]').val();
                key = this.isJson(key);

            if (key === false) {
                $('.notice').addClass('error').removeClass('updated').empty().append('<p>' + googleanalytics.invalid_json + '</p>').show();
                return;
            }

            Settings.prototype.saveAccountKey(key);
        }.bind(this));
    };

    Settings.prototype.isJson = function (str) {
        try {
            JSON.parse(str);
        } catch (e) {
            return false;
        }

        return JSON.parse(str);
    };

    return new Settings();

})(jQuery);
