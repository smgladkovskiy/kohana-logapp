<?php defined('SYSPATH') OR die('No direct access allowed.');

/**
 * Logapp Driver for Jelly ORM
 *
 * @author avis <smgladkovskiy@gmail.com>
 */
class Logapp_Driver_Jelly extends Logapp implements Logapp_Interface {
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
		if( ! arr::get(Logapp::$log_types, $type))
		{
			$this->_set_namespace_item($type, 'log_types');
		}

		if( ! arr::get(Logapp::$log_results, $result))
		{
			$this->_set_namespace_item($result, 'log_results');
		}

		Jelly::factory('log_'.$this->_config['orm_driver'])->set(array(
					'time' => time(),
					'type' => arr::get(Logapp::$log_types, $type),
					'result' => arr::get(Logapp::$log_results, $result),
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
		$_logs = Jelly::select('log_'.$this->_config['orm_driver'])
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
		//$namespaces = Kohana::cache($type);
		//if( ! $namespaces)
		//{
			$namespaces = Jelly::select(Inflector::singular($type).'_'.$this->_config['orm_driver'])
				->execute();
		//}


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
		$_item = Jelly::factory(Inflector::singular($section).'_'.$this->_config['orm_driver'])
			->set(array(
				'name' => $item
			))->save();

		Logapp::${$section}[$item] = $_item->id;
	}

} // End Logapp Driver Jelly
