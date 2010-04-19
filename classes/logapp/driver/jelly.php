<?php defined('SYSPATH') or die('No direct access allowed.');

/**
 * Logapp Driver for Jelly ORM
 *
 * @package Logapp
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

	/**
	 * Setting table lock. It can be used to prevent
	 * edditing table record by many people in CMS
	 *
	 * @param  string  $table_name
	 * @param  integer $record_id
	 * @param  integer $user_id
	 * @return object/FALSE
	 */
	public function _set_lock($table_name, $record_id, $user_id)
	{
		$lock = Jelly::factory('lock_jelly')->set(array(
			'time' => time(),
			'table_name' => $table_name,
			'table_record' => $record_id,
			'user' => $user_id
		))->save();
		if($lock->saved())
		{
			return $lock;
		}
		else
		{
			return FALSE;
		}
	}

	/**
	 * Getting table lock if it exists
	 *
	 * @param  string  $table_name
	 * @param  integer $record_id
	 * @return object/FALSE
	 */
	public function _get_lock($table_name, $record_id)
	{
		$lock = Jelly::select('lock_jelly')
			->where('table_name', '=', $table_name)
			->where('table_record', '=', $record_id)
			->load();
		if($lock->loaded())
		{
			return $lock;
		}
		else
		{
			return FALSE;
		}
	}

	/**
	 * Clears table lock
	 *
	 * @param  integer $lock
	 * @return boolean
	 */
	public function _clear_lock($lock_id)
	{
		if(Jelly::factory('lock_jelly')->delete($lock_id))
			return TRUE;

		return FALSE;
	}

	/**
	 * Clears all table locks
	 *
	 * @return boolean
	 */
	public function _clear_all_locks()
	{
		$locks = Jelly::select('lock_jelly')->execute();
		foreach($locks as $lock)
		{
			Jelly::factory('lock_jelly')->delete($lock->id);
		}
		return TRUE;
	}
	
} // End Logapp_Driver_Jelly