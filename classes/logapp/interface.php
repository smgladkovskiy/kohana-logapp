<?php defined('SYSPATH') OR die('No direct access allowed.');

/**
 * Logapp Interface for driver implementation
 *
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
	
} // End Class Logapp_Interface
