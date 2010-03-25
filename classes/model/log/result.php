<?php defined('SYSPATH') OR die('No direct access allowed.');

/**
 * Jelly Model Log Result
 *
 * @author avis <smgladkovskiy@gmail.com>
 */
class Model_Log_Result extends Jelly_Model {

	/**
	 * Initializating model meta information
	 *
	 * @param Jelly_Meta $meta
	 */
    public static function initialize(Jelly_Meta $meta)
    {
        $meta->table('log_results')
             ->fields(array(
                 'id' => new Field_Primary,
                 'name' => new Field_String,
             ));
    }
} // End Jelly Model Log Result