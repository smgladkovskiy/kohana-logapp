<?php defined('SYSPATH') or die('No direct access allowed.');

/**
 * Logapp Driver for Sprig ORM
 *
 * @package Logapp
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
		$lock = Sprig::factory('lock_sprig', array(
			'time' => time(),
			'table_name' => $table_name,
			'table_record' => $record_id,
			'user' => $user_id
		))->create();
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
		$query = DB::select()
			->where('table_name', '=', $table_name)
			->where('table_record', '=', $record_id);
		$logs = Sprig::factory('lock_sprig')
			->load($query);
		
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
		if(Sprig::factory('lock_sprig')->delete($lock_id))
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
		$locks = Sprig::factory('lock_sprig')->load();
		foreach($locks as $lock)
		{
			Sprig::factory('lock_sprig')->delete($lock->id);
		}
		return TRUE;
	}

} // End Logapp_Driver_Sprig