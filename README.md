# Google Analytics

Plugin to integrate Google Analytics tracking and display statistics on the admin dashboard.
It requires a Google Service Account with read permissions connected to the desired Google Analytics web property.

## Getting started

### Install libraries

This plugin requires [Google APIs Client Library for PHP](https://github.com/google/google-api-php-client) and is installed with [Composer](https://getcomposer.org):

```sh
composer install
```

### Google Service Account setup

* Create a Project in the [Google APIs Console](https://code.google.com/apis/console/)
* Enable the **Analytics API** under APIs & services
* Create a Service Account for the project with view cababilities
* Download the private key (JSON)
* Finally add **Service account ID** as a new user to your [Google Analytics](https://analytics.google.com/analytics/web/) account.

## Filters

#### GoogleAnalytics/TrackingId/ua
Filters the Google Analytics UA (user id) used to load Google Analytics.

- ```@param string $ua``` - The Google Analytics UA

```php
apply_filters('GoogleAnalytics/TrackingId/ua', $ua);
```
