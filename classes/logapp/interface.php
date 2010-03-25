<?php defined('SYSPATH') OR die('No direct access allowed.');

/**
 * Class Logapp_Interface
 *
 * @author avis <smgladkovskiy@gmail.com>
 */
interface Logapp_Interface {

	/**
	 * Writing a log issue
	 *
	 * @param string $type
	 * @param string $result
	 * @param integer $user
	 * @param string $description
	 */
	public function write ($type, $result, $user = NULL, $description = NULL);

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
	
} // End Class Logapp_Interface
