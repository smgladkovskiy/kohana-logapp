<?php defined('SYSPATH') OR die('No direct access allowed.');

/**
 * Log Model for Sprig ORM
 *
 * @author avis <smgladkovskiy@gmail.com>
 */
class Model_Log_Sprig extends Sprig {

	protected $_table = 'logs';

    protected function _init()
    {
        $this->_fields += array(
            'id' => new Sprig_Field_Auto,
            'time' => new Sprig_Field_Timestamp(array(
				'label' => __('Время'),
				'pretty_format' => 'd.m.Y H:i',
				'empty' => FALSE,
			)),
			'type' => new Sprig_Field_BelongsTo(array(
				'label' => __('Событие'),
				'model' => 'log_type_sprig',
				'foreign' => 'log_type_sprig',
				'column' => 'type_id',
			)),
			'result' => new Sprig_Field_BelongsTo(array(
				'label' => __('Результат'),
				'model' => 'log_result_sprig',
				'foreign' => 'log_result_sprig',
				'column' => 'result_id'
			)),
			'user' => new Sprig_Field_BelongsTo(array(
				'label' => __('Пользователь')
			)),
			'description' => new Sprig_Field_Text(array(
				'label' => __('Описание')
			)),
		 );
    }

} // End Model_Log_Sprig