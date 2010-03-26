<?php defined('SYSPATH') OR die('No direct access allowed.');

/**
 * Sprig Model sprig
 *
 * @author avis <smgladkovskiy@gmail.com>
 */
class Model_Log_Type_Sprig extends Sprig {

	protected $_table = 'log_types';

    protected function _init()
    {
        $this->_fields += array(
            'id' => new Sprig_Field_Auto,
            'name' => new Sprig_Field_Char(array(
				'empty' => FALSE,
			)),
        );
    }

} // End Model_Log_Type_Sprig