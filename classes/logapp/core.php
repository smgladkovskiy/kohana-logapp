<?php defined('SYSPATH') OR die('No direct access allowed.');

/**
 * Controller Logapp
 *
 * @author avis <smgladkovskiy@gmail.com>
 *
 * @todo implement data caching
 */
abstract class Logapp_Core {

	// Log instance
	protected static $instance;

	// Logapp config
	protected $_config;

	// Log types array
	protected static $log_types = array();

	// Log results array
	protected static $log_results = array();

	/**
	 * Creates a singleton of a Log Class.
	 *
	 * @return  Log
	 */
	public static function instance()
	{
		if ( ! isset(Logapp::$instance))
		{
			$config = Kohana::config('logapp');
			$classname = 'Logapp_Driver_'.$config['orm_driver'];
			// Create a new log instance
			Logapp::$instance = new $classname();
		}

		return Logapp::$instance;
	}
	
	/**
	 * Constructor
	 */
	public function  __construct()
	{
		$this->_config = Kohana::config('logapp');
		$this->_get_namespaces('log_types');
		$this->_get_namespaces('log_results');
	}

} // End Controller Log