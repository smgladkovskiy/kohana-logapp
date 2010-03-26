<?php defined('SYSPATH') OR die('No direct access allowed.');

/**
 * Logapp Driver for Jelly ORM
 *
 * @author avis <smgladkovskiy@gmail.com>
 */
class Logapp_Driver_Jelly extends Logapp implements Logapp_Interface {

	/**
	 * Watching last Log issues
	 *
	 * @param integer $limit
	 * @return object Logs
	 */
	public function watch($limit = 10)
	{
		$_logs = Jelly::select('log_jelly')
			->limit((int) $limit)
			->order_by('id', 'DESC');
		$logs = $_logs->execute();
		return $logs;
	}

	/**
	 * Getting namespaces by type
	 *
	 * @param string $type
	 */
	public function _get_namespaces($type)
	{
		$namespaces = Jelly::select(Inflector::singular($type).'_jelly')
			->execute();

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
		$_item = Jelly::factory(Inflector::singular($section).'_jelly')
			->set(array(
				'name' => $item
			))->save();

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
		Jelly::factory('log_jelly')
			->set(array(
				'time' => time(),
				'type' => arr::get(Logapp::$log_types, $type),
				'result' => arr::get(Logapp::$log_results, $result),
				'user' => $user,
				'description' => __($description)
			))->save();
	}

} // End Logapp_Driver_Jelly