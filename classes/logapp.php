<?php defined('SYSPATH') OR die('No direct access allowed.');

/**
 * Controller Logapp
 *
 * @author avis <smgladkovskiy@gmail.com>
 * @todo внедрить кэширование справочника
 */
class Logapp {

	// Log instance
	protected static $instance;

	// Log types array
	protected static $log_types = array(
			'_exists' => FALSE,
			'_parent_id' => NULL);

	// Log results array
	protected static $log_results = array(
			'_exists' => FALSE,
			'_parent_id' => NULL);

	/**
	 * Creates a singleton of a Log Class.
	 *
	 * @return  Log
	 */
	public static function instance()
	{
		if ( ! isset(Loagapp::$instance))
		{
			// Create a new log instance
			Loagapp::$instance = new Log();
		}

		return Loagapp::$instance;
	}
	
	/**
	 * Constructor
	 */
	public function  __construct()
	{
		$this->_get_namespaces('log_types');
		$this->_get_namespaces('log_results');
	}

	/**
	 * Writing a log issue
	 *
	 * @param string $type
	 * @param string $result
	 * @param integer $user
	 * @param string $description
	 */
	public function write ($type, $result, $user = NULL, $description = NULL)
	{
		if( ! arr::get(Loagapp::$log_types, $type))
		{
			$this->_set_namespace_item($type, 'log_types');
		}

		if( ! arr::get(Loagapp::$log_results, $result))
		{
			$this->_set_namespace_item($result, 'log_results');
		}

		Jelly::factory('log')->set(array(
					'time' => time(),
					'type' => arr::get(Loagapp::$log_types, $type, NULL),
					'result' => arr::get(Loagapp::$log_results, $result, NULL),
					'user' => $user,
					'description' => __($description)
				))->save();
		
	}

	/**
	 * Watching last Log issues
	 *
	 * @param integer $limit
	 * @return object Logs
	 */
	public function watch($limit = 10)
	{
		$logs = Jelly::select('log')
			->limit((int) $limit)
			->order_by('id', 'DESC');
		$logs = $logs->execute();
		return $logs;
	}

	/**
	 * Getting namespaces by type
	 *
	 * @param string $type
	 */
	protected function _get_namespaces($type)
	{
		$namespaces = Kohana::cache($type);
		if( ! $namespaces)
		{
			$namespaces = Jelly::select($type)
				->execute();
		}

		foreach ($namespaces as $namespace)
		{
			Loagapp::${$type}[$namespace->name] = $namespace->id;
		}

	}

	/**
	 * Setting namespace item for a log section
	 *
	 * @param string $item
	 * @param string $section
	 */
	protected function _set_namespace_item($item, $section)
	{
		$_item = Jelly::factory($section)
			->set(array(
				'name' => $item
			))->save();

		Loagapp::${$section}[$item] = $_item->id;
	}

} // End Controller log