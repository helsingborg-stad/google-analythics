<?php

namespace GoogleAnalytics;

class Dashboard
{
	public function __construct()
	{
		add_action('wp_dashboard_setup', array($this, 'createDashboardWidgets'));
	}

	/**
	 * Add a widget to the dashboard.
	 * This function is hooked into the 'wp_dashboard_setup' action below.
	 */
	function createDashboardWidgets()
	{
		wp_add_dashboard_widget(
			'google_analytics',
			'Google Analytics',
			array($this, 'dashboardCallback')
	    );
	}

	/**
	 * Create the function to output the contents of our Dashboard Widget.
	 */
	public function dashboardCallback() {
		echo '<div>Test</div>
		<div id="embed-api-auth-container"></div>
				<div id="chart-container"></div>
				<div id="view-selector-container"></div>';
	}


}
