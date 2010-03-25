<?php defined('SYSPATH') OR die('No direct access allowed.');

/**
 * Model Jelly Log Model
 *
 * @author avis <smgladkovskiy@gmail.com>
 */
class Model_Log_Jelly extends Jelly_Model {

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
					'model' => 'log_type_jelly',
					'foreign' => 'log_type_jelly',
					'column' => 'type_id',
				)),
				'result' => new Field_BelongsTo(array(
					'label' => __('Результат'),
					'model' => 'log_result_jelly',
					'foreign' => 'log_result_jelly',
					'column' => 'result_id'
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
				'result',
			 ));
    }
} // End Jelly Model Log