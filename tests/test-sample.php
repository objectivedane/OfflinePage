<?php
/**
 * Class SampleTest
 *
 * @package OfflinePage
 */

/**
 * Sample test case.
 */
class SampleTest extends WP_UnitTestCase {

	const PLUGIN_PATH = 'OfflinePage/OfflinePage.php';

	function setUp() {
		require_once __DIR__ . '/../OfflinePage.php';
		do_action('admin_init');
	}

	/**
	 * Does the plugin activate succesfully
	 */
	function test_activation() {
		$this->assertNull( activate_plugin( self::PLUGIN_PATH ) , 'WP could not install plugin');
		$this->assertTrue( is_plugin_active( self::PLUGIN_PATH ) , 'Plugin did not remain active');
	}

	/**
	 * Does the plugin deactivate succesfully
	 */
	function test_deactivation() {
		$this->assertTrue( is_plugin_active( self::PLUGIN_PATH ) , 'Plugin must be active to deactivate it');
		$this->assertNull( deactivate_plugins( self::PLUGIN_PATH ) , 'Plugin could not be deactivated' );
	}

	/**
	 * Has(ve) the JS file(s) been queued up by WP
	 */
	function test_javascript_accessibilty()
	{
		$this->assertTrue( wp_script_is('OfflinePageJs') , 'OfflinePageJs is not in the script queue' );
	}

	/**
	 * Has the default option been set
	 */
	function test_setting_fields()
	{
		$this->assertEquals( get_option( 'offline_page' ), '' , 'The default offline_page option was ' . get_option( 'offline_page' ) . '. It should have been an empty string.');
	}

	/**
	 * Set a custom slug and trigger the update_option
	 * Get the newly built service.js
	 * Check that the custom slug was correctly inserted into service.js
	 */
	function test_update_url()
	{
		update_option( 'offline_page' , 'test-location');
		do_action('updated_option', get_option('offline_page'), 'test-location');
		$file_contents = file_get_contents(__DIR__ . '/../assets/js/service.js');
		$this->assertTrue((bool) strpos($file_contents, get_option( 'offline_page' )), 'Slug in options was not found in service.js');

	}


}
