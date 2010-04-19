<?php defined('SYSPATH') or die('No direct access allowed.');

/**
 * Logapp class for logging application actions
 *
 * @package Logapp
 * @author avis <smgladkovskiy@gmail.com>
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


	/**
	 * Setting table lock. It can be used to prevent
	 * edditing table record by many people in CMS
	 *
	 * @param  string  $table_name
	 * @param  integer $record_id
	 * @param  integer $user_id
	 * @return object/FALSE
	 */
	public function set_lock($table_name, $record_id, $user_id)
	{
		return $this->_set_lock($table_name, $record_id, $user_id);
	}

	/**
	 * Getting table lock if it exists
	 *
	 * @param  string  $table_name
	 * @param  integer $record_id
	 * @return object/FALSE
	 */
	public function get_lock($table_name, $record_id)
	{
		return $this->_get_lock($table_name, $record_id);
	}

	/**
	 * Clears table lock
	 *
	 * @param  object $lock
	 * @return boolean
	 */
	public function clear_lock($lock)
	{
		return $this->_clear_lock($lock->id);
	}

	/**
	 * Clears all table locks
	 *
	 * @return boolean
	 */
	public function clear_all_locks()
	{
		return $this->_clear_all_locks();
	}

} // End Logapp_Core