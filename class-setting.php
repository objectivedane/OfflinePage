<?php
/**
 * Created by PhpStorm.
 * User: objdane dev@objective-d.co.uk
 * Date: 21/09/17
 * Time: 11:48
 */

/**
 * Class Setting
 * Setup work for admin settings
 */
class Setting
{

	/**
	 * Provides section title
	 */
	public static function offline_page_section_content()
	{
		echo "Section";
	}

	/**
	 * Provides setting field with input
	 */
	public static function offline_page_field_content()
	{
		$setting = get_option('offline_page');
		$current_value = (isset($setting) ? esc_attr($setting) : '');
		echo <<<lt
		<input type='text' name='offline_page' value='$current_value' />
lt;

	}
}