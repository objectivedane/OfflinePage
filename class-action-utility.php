<?php
/**
 * Created by PhpStorm.
 * User: objdane dev@objective-d.co.uk
 * Date: 21/09/17
 * Time: 08:40
 */

/**
 * Class Action_Utility
 * Static methods called to respond to hooks
 */
class Action_Utility
{

	/**
	 * Adds app.js to the WP script queue
	 */
	public static function add_javascript_files()
	{
		wp_enqueue_script('OfflinePageJs', plugin_dir_url(__FILE__) . '/assets/js/app.js');
	}

	/**
	 * Create the settings section to allow the user to choose their offline page
	 */
	public static function add_settings_field()
	{
		register_setting('reading', 'offline_page');
		add_settings_section(
			'offline_page_section',
			'Offline Page Settings Section',
			array('Setting', 'offline_page_section_content'),
			'reading'
		);
		add_settings_field(
			'offline_page_field',
			'Offline Page Settings Field',
			array('Setting', 'offline_page_field_content'),
			'reading',
			'offline_page_section'
		);

		add_option('offline_page', '');
	}

	/**
	 * Called whenever an option is updated and creates the service worker script
	 * @param $options The updated option
	 *
	 */
	public static function update_js_file($options)
	{
		if($options === 'offline_page')
		{
			$offline_page = get_option('offline_page');
			$the_script = self::write_js($offline_page);

			if(!$js_file = fopen(__DIR__ . '/assets/js/service.js', 'w+'))
			{
				error_log('OfflinePage could not open/write the updated service.js');
			}
			fwrite($js_file, $the_script);
			fclose($js_file);

		}
	}

	/**
	 * Helper to assign the JS to a variable.
	 * @param $offline_page The offline page slug
	 *
	 * @return string - the service.js script
	 */
	private static function write_js($offline_page)
	{
		return <<<lt
self.addEventListener('install', function (event) {
    var offlineRequest = new Request('/$offline_page');
    event.waitUntil(
        fetch(offlineRequest).then(function (response) {
            return caches.open('offline').then(function (cache) {
                //console.log('[oninstall] Cached offline page', response.url);
                return cache.put(offlineRequest, response);
            });
        })
    );
});

self.addEventListener('fetch', function (event) {
    var request = event.request;
    if (request.method === 'GET') {
        event.respondWith(
            fetch(request).catch(function (error) {
                /*console.error(
                 '[onfetch] Failed. Serving cached offline fallback ' +
                 error
                 );*/
                return caches.open('offline').then(function (cache) {
                    return cache.match('/$offline_page');
                });
            })
        );
    }
});
lt;

	}
}