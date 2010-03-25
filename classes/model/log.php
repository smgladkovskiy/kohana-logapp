<?php defined('SYSPATH') OR die('No direct access allowed.');

/**
 * Jelly Model log
 *
 * @author avis <smgladkovskiy@gmail.com>
 */
class Model_Log extends Jelly_Model {

	/**
	 * Initializating model meta information
	 *
	 * @param Jelly_Meta $meta
	 */
    public static function initialize(Jelly_Meta $meta)
    {
        $meta->table('logs')
             ->fields(array(
				'id' => new Field_Primary(array(
					'label' => __('nn')
				)),
				'time' => new Field_Timestamp(array(
					'label' => __('Время'),
					'pretty_format' => 'd.m.Y H:i'
				)),
				'type' => new Field_BelongsTo(array(
					'label' => __('Событие'),
					'foreign' => 'log_types',
				)),
				'result' => new Field_BelongsTo(array(
					'label' => __('Результат'),
					'foreign' => 'log_results',
				)),
				'user' => new Field_BelongsTo(array(
					'label' => __('Пользователь')
				)),
                'description' => new Field_Text(array(
					'label' => __('Описание')
				)),
             ))
			 ->load_with(array(
				'type',
				//'result',
			 ));
    }
} // End Jelly Model Log