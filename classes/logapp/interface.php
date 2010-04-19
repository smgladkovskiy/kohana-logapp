<?php defined('SYSPATH') or die('No direct access allowed.');

/**
 * Logapp Interface for driver implementation
 *
 * @package Logapp
 * @author avis <smgladkovskiy@gmail.com>
 */
interface Logapp_Interface {

	/**
	 * Watching last Log issues
	 *
	 * @param integer $limit
	 * @return object Logs
	 */
	public function watch($limit = 10);

	/**
	 * Getting namespaces by type
	 *
	 * @param string $type
	 */
	public function _get_namespaces($type);

	/**
	 * Setting namespace item for a log section
	 *
	 * @param string $item
	 * @param string $section
	 */
	public function _set_namespace_item($item, $section);

	/**
	 * Writing a log issue
	 *
	 * @param string $type
	 * @param string $result
	 * @param integer $user
	 * @param string $description
	 */
	public function _write_log($type, $result, $user = NULL, $description = NULL);

	/**
	 * Setting table lock. It can be used to prevent
	 * edditing table record by many people in CMS
	 *
	 * @param  string  $table_name
	 * @param  integer $record_id
	 * @param  integer $user_id
	 * @return object/FALSE
	 */
	public function set_lock($table_name, $record_id, $user_id);

	/**
	 * Getting table lock if it exists
	 *
	 * @param  string  $table_name
	 * @param  integer $record_id
	 * @return object/FALSE
	 */
	public function get_lock($table_name, $record_id);

	/**
	 * Clears table lock
	 *
	 * @param  object $lock
	 * @return boolean
	 */
	public function clear_lock($lock);

	/**
	 * Clears all table locks
	 *
	 * @return boolean
	 */
	public function clear_all_locks();
	
} // End Class Logapp_Interface