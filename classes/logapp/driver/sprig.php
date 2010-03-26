<?php defined('SYSPATH') OR die('No direct access allowed.');

/**
 * Logapp Driver for Sprig ORM
 *
 * @author avis <smgladkovskiy@gmail.com>
 */
class Logapp_Driver_Sprig extends Logapp implements Logapp_Interface {

	/**
	 * Watching last Log issues
	 *
	 * @param integer $limit
	 * @return object Logs
	 */
	public function watch($limit = 10)
	{
		$query = DB::select()->limit((int) $limit)
			->order_by('id', 'DESC');
		$logs = Sprig::factory('log_sprig')
			->load($query);
		return $logs;
	}

	/**
	 * Getting namespaces by type
	 *
	 * @param string $type
	 */
	public function _get_namespaces($type)
	{
		$namespaces = Sprig::factory(Inflector::singular($type).'_sprig')
			->load();

		foreach ($namespaces as $namespace)
		{
			Logapp::${$type}[$namespace->name] = $namespace->id;
		}

	}

	/**
	 * Setting namespace item for a log section
	 *
	 * @param string $item
	 * @param string $section
	 */
	public function _set_namespace_item($item, $section)
	{
		$item = Sprig::factory(Inflector::singular($section).'_sprig',
			array(
				'name' => $item
			));
		$item->create();

		Logapp::${$section}[$item] = $_item->id;
	}

	/**
	 * Writing a log issue
	 *
	 * @param string  $type
	 * @param string  $result
	 * @param integer $user
	 * @param string  $description
	 */
	public function _write_log($type, $result, $user = NULL, $description = NULL)
	{
		$log = Sprig::factory('log_sprig',
			array(
				'time' => time(),
				'type' => arr::get(Logapp::$log_types, $type),
				'result' => arr::get(Logapp::$log_results, $result),
				'user' => $user,
				'description' => __($description)
			));
		$log->create();
	}

} // End Logapp_Driver_Jelly
