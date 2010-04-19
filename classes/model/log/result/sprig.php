<?php defined('SYSPATH') or die('No direct access allowed.');

/**
 * Sprig Log Result Model for Sprig
 *
 * @package Logapp
 * @author avis <smgladkovskiy@gmail.com>
 */
class Model_Log_Result_Sprig extends Sprig {

	protected $_table = 'log_results';

    protected function _init()
    {
        $this->_fields += array(
            'id' => new Sprig_Field_Auto,
            'name' => new Sprig_Field_Char(array(
				'empty' => FALSE,
			)),
        );
    }

} // End Model_Log_Result_Sprig