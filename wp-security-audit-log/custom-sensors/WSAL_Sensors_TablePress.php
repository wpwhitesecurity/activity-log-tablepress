<?php
/**
 * Custom Sensors for PLUGINNAME
 *
 * Class file for alert manager.
 *
 * @since   1.0.0
 * @package Wsal
 */
class WSAL_Sensors_TablePress extends WSAL_AbstractSensor {

	/**
	 * Holds a cached value if the checked alert has recently fired.
	 *
	 * @var null|array
	 */
	private $cached_alert_checks = null;

	/**
	 * Hook events related to sensor.
	 *
	 * @since 1.0.0
	 */
	public function HookEvents() {
		if ( is_user_logged_in() ) {
			
		}
	}
	
}
