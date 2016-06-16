<?php
/**
 * Created by Kutuzov Alexey Konstantinovich <lexus.1995@mail.ru>.
 * Author: Kutuzov Alexey Konstantinovich <lexus.1995@mail.ru>
 * Project: jungle
 * IDE: PhpStorm
 * Date: 20.05.2016
 * Time: 20:50
 */
namespace Jungle\Data\Foundation\Record {

	use Jungle\Data\Foundation\Record;
	use Jungle\Data\Foundation\Record\Collection\Relationship;
	use Jungle\Data\Foundation\Record\Head\Field;
	use Jungle\Data\Foundation\Record\Head\Schema;

	/**
	 * Class DataMap - Предвестник ORM ~ Моделей
	 * @package modelX
	 */
	class DataMap extends Record{

		/** @var array */
		protected $_processed = [];

		/** @var array  */
		protected $_properties = [];

		/**
		 * DataMap constructor.
		 * @param Schema $schema
		 * @param null $data
		 */
		public function __construct(Schema $schema, $data = null){
			parent::__construct();
			$this->setSchema($schema);
			if($data!==null){
				$this->_operation_made = self::OP_UPDATE;
				$this->setOriginalData($data);
			}else{
				$this->_operation_made = self::OP_CREATE;
			}
		}

		/**
		 * @param null $fieldName
		 * @return mixed
		 */
		public function reset($fieldName = null){
			if($fieldName === null){
				$this->_properties = [];
			}else{
				unset($this->_properties[$fieldName]);
			}
			$this->onRecordReady();
		}

		/**
		 * @param null $fieldName
		 */
		protected function _resetAll($fieldName = null){
			if($fieldName === null){
				$this->_processed = [];
				$this->_properties = [];
			}else{
				unset($this->_processed[$fieldName]);
				unset($this->_properties[$fieldName]);
			}
			$this->onRecordReady();
		}


		/**
		 * @param \Jungle\Data\Foundation\Record\Head\Schema $schema
		 * @param $condition
		 * @param null $limit
		 * @param null $offset
		 * @param null $orderBy
		 * @param array $options
		 * @return DataMap[]
		 */
		public static function loadCollection(Schema $schema, $condition, $limit = null, $offset = null, $orderBy = null, array $options = null){
			$records = [];
			if(!$options)$options = [];
			$options['for_update'] = true;
			//$options['lock_in_shared'] = true;
			foreach(new \ArrayIterator($schema->storageLoad($condition,$limit,$offset,$orderBy,$options)) as $record){
				$records[] = new DataMap($schema, $record);
			}
			return $records;
		}


		/**
		 * @param $name
		 * @param $value
		 * @return mixed
		 */
		protected function _setFrontProperty($name, $value){
			$this->_properties[$name] = $value;
		}

		/**
		 * @param $name
		 * @return mixed
		 */
		protected function _getFrontProperty($name){
			if(!array_key_exists($name, $this->_properties)){
				return $this->_properties[$name] = $this->_getProcessed($name);
			}
			return $this->_properties[$name];
		}

		/**
		 * @param $name
		 * @return mixed
		 */
		public function isInitializedProperty($name){
			return array_key_exists($name,$this->_properties);
		}


		/**
		 * @return bool
		 */
		protected function _doCreate(){
			if(parent::_doCreate()){
				$this->_processed = $this->_properties;
				return true;
			}
			return false;
		}

		/**
		 * @param $changed
		 * @return bool
		 */
		protected function _doUpdate($changed){
			if(parent::_doUpdate($changed)){
				$this->_processed = $this->_properties;
				return true;
			}
			return false;
		}

	}
}

