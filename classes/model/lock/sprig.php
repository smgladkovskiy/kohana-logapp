<?php defined('SYSPATH') or die('No direct access allowed.');

/**
 * Lock Model for Sprig ORM
 *
 * @package Logapp
 * @author avis <smgladkovskiy@gmail.com>
 */
class Model_Lock_Sprig extends Sprig {

	protected $_table = 'locks';

	protected function _init()
	{
		$this->_fields += array(
			'id'           => new Sprig_Field_Auto,
			'time'         => new Sprig_Field_Timestamp,
			'table_name'   => new Sprig_Field_Char,
			'table_record' => new Sprig_Field_Integer,
			'user'         => new Sprig_Field_BelongsTo
		);
	}
} // End Model_Lock_Sprig