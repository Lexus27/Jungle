<?php
/**
 * Created by Kutuzov Alexey Konstantinovich <lexus.1995@mail.ru>.
 * Author: Kutuzov Alexey Konstantinovich <lexus.1995@mail.ru>
 * Project: jungle
 * IDE: PhpStorm
 * Date: 17.11.2016
 * Time: 21:14
 */
namespace Jungle\Data\Record\Validation {

	use Jungle\Data\Record;

	/**
	 * Class CheckExpected
	 * @package Jungle\Data\Record\Validation
	 */
	class CheckExpected extends Validation{

		/** @var array  */
		public $value_list = [];

		public $type = 'CheckExpected';


		public function __construct($value_list, $fields){
			$this->value_list = $value_list;
			parent::__construct($fields);
		}

		/**
		 * @param Record $record
		 * @param ValidationCollector $collector
		 * @return array
		 */
		public function validate(Record $record, ValidationCollector $collector){
			$data = $record->getProperties($this->fields);
			$error_fields = [];
			foreach($data as $k => $v){
				if(!is_null($v) && !in_array($v, $this->value_list)){
					$error_fields[$k] = $this;
				}
			}
			return $error_fields;
		}


	}
}

