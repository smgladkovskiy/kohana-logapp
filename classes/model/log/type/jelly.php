<?php defined('SYSPATH') OR die('No direct access allowed.');

/**
 * Jelly Model Log Type
 *
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
} // End Jelly Model Log Type