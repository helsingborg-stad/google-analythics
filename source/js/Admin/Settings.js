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
