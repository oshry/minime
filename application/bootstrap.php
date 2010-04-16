<?php defined('SYSPATH') or die('No direct script access.');

//-- Environment setup --------------------------------------------------------

/**
 * Set the default time zone.
 *
 * @see  http://docs.kohanaphp.com/features/localization#time
 * @see  http://php.net/timezones
 */
date_default_timezone_set('America/Chicago');

/**
 * Enable the Kohana auto-loader.
 *
 * @see  http://docs.kohanaphp.com/features/autoloading
 * @see  http://php.net/spl_autoload_register
 */
spl_autoload_register(array('Kohana', 'auto_load'));

/**
 * Set if the application is in development (FALSE)
 * or if the application is in production (TRUE).
 */
define('IN_PRODUCTION', ($_SERVER['SERVER_NAME'] !== 'localhost' && $_SERVER['SERVER_NAME'] !== '10.0.0.100'));

//-- Configuration and initialization -----------------------------------------

/**
 * Initialize Kohana, setting the default options.
 *
 * The following options are available:
 *
 * - string   base_url    path, and optionally domain, of your application   NULL
 * - string   index_file  name of your index file, usually "index.php"       index.php
 * - string   charset     internal character set used for input and output   utf-8
 * - string   cache_dir   set the internal cache directory                   APPPATH/cache
 * - boolean  errors      enable or disable error handling                   TRUE
 * - boolean  profile     enable or disable internal profiling               TRUE
 * - boolean  caching     enable or disable internal caching                 FALSE
 */
Kohana::init(
	array
	(
		'base_url'   => '/minime/',
		'index_file' => FALSE,
		'profile'    => ! IN_PRODUCTION,     // Disabling profiling if we are in production
		'caching'    => IN_PRODUCTION,       // Enable caching if we are in production
	)
);

/**
 * Attach the file write to logging. Multiple writers are supported.
 */
Kohana::$log->attach(new Kohana_Log_File(APPPATH.'logs'));

/**
 * Attach a file reader to config. Multiple readers are supported.
 */
Kohana::$config->attach(new Kohana_Config_File);

/**
 * Enable modules. Modules are referenced by a relative or absolute path.
 */
Kohana::modules(array(
	 'auth'       => MODPATH.'auth',       // Basic authentication
	// 'devils'     => MODPATH.'devils',     //
	// 'codebench'  => MODPATH.'codebench',  // Benchmarking tool
	 'database'   => MODPATH.'database',   // Database access
	 'image'      => MODPATH.'image',      // Image manipulation
	 'orm'        => MODPATH.'orm',        // Object Relationship Mapping
	 'pagination' => MODPATH.'pagination', // Paging of results
	 'userguide'  => MODPATH.'userguide',  // User guide and API documentation
	));

/**
 * Set the routes. Each route must have a minimum of a name, a URI and a set of
 * defaults for the URI.
 */
Route::set('property', 'property(/<id>(/<name>))', array('name' => '.*?'))
    ->defaults(array(
        'controller' => 'property',
        'action'     => 'view',
    ));
Route::set('about', 'about(<controller>(/<action>(/<id>)))')
	->defaults(array(
		'controller' => 'about',
		'action'     => 'index',
	));
Route::set('default', '(<controller>(/<action>(/<id>)))')
	->defaults(array(
		'controller' => 'home',
		'action'     => 'index',
	));
/*
Route::set('catch_all', '<path>', array('path' => '.+'))
	->defaults(array(
		'controller' => 'errors',
		'action' => '404',
	));
*/

/**
 * Execute the main request. A source of the URI can be passed, eg: $_SERVER['PATH_INFO'].
 * If no source is specified, the URI will be automatically detected.
 */
echo Request::instance()
	->execute()
	->send_headers()
	->response;
