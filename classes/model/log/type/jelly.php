<?php defined('SYSPATH') or die('No direct access allowed.');

/**
 * Jelly Model Log Type
 *
 * @package Logapp
 * @author avis <smgladkovskiy@gmail.com>
 */
class Model_Log_Type_Jelly extends Jelly_Model {

	/**
	 * Initializating model meta information
	 *
	 * @param Jelly_Meta $meta
	 */
    public static function initialize(Jelly_Meta $meta)
    {
        $meta->table('log_types')
             ->fields(array(
                 'id' => new Field_Primary,
                 'name' => new Field_String,
             ));
    }
} // End Model_Log_Type_Jelly