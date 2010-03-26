<?php defined('SYSPATH') OR die('No direct access allowed.');

/**
 * Logapp class for logging application actions
 *
 * @author avis <smgladkovskiy@gmail.com>
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

	/**
	 * Writing a log issue
	 *
	 * @param string  $type
	 * @param string  $result
	 * @param integer $user
	 * @param string  $description
	 */
	public function write($type, $result, $user = NULL, $description = NULL)
	{
		if( ! arr::get(Logapp::$log_types, $type))
		{
			$this->_set_namespace_item($type, 'log_types');
		}

		if( ! arr::get(Logapp::$log_results, $result))
		{
			$this->_set_namespace_item($result, 'log_results');
		}

		$this->_write_log($type, $result, $user, $description);
	}

} // End Logapp_Core