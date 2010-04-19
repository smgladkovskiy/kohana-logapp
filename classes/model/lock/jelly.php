<?php defined('SYSPATH') or die('No direct access allowed.');

/**
 * Lock Model for Jelly ORM
 *
 * @package Logapp
 * @author avis <smgladkovskiy@gmail.com>
 */
class Model_Lock_Jelly extends Jelly_Model {

	/**
	 * Initializating model meta information
	 *
	 * @param Jelly_Meta $meta
	 */
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->table('locks')
			->fields(array(
				'id'           => new Field_Primary,
				'time'         => new Field_Timestamp,
				'table_name'   => new Field_String,
				'table_record' => new Field_Integer,
				'user'         => new Field_BelongsTo
			));
	}
} // End Model_Lock_Jelly