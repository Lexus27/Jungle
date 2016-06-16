<?php
/**
 * Created by Kutuzov Alexey Konstantinovich <lexus.1995@mail.ru>.
 * Author: Kutuzov Alexey Konstantinovich <lexus.1995@mail.ru>
 * Project: jungle
 * IDE: PhpStorm
 * Date: 07.06.2016
 * Time: 16:36
 */
namespace Jungle\Data\Foundation\Record\Head\Field {
	
	use Jungle\Data\Foundation\Record;
	use Jungle\Data\Foundation\Record\Head\Field;
	use Jungle\Data\Foundation\Schema\OuterInteraction\ValueAccessor;

	/**
	 * Class Virtual
	 * @package Jungle\Data\Foundation\Record\Head\Field
	 */
	class Virtual extends Field{

		/** @var   */
		protected $formula_key;

		protected $getter;

		protected $setter;

		/**
		 * @param $formulaField
		 * @param null $getter
		 * @param null $setter
		 * @return $this
		 */
		public function setFormula($formulaField, $getter = null, $setter = null){
			$this->formula_key = $formulaField;
			$this->getter = $getter;
			$this->setter = $setter;
			return $this;
		}

		/**
		 * @return ValueAccessor\SetterInterface
		 */
		public function getSetter(){
			return $this->setter;
		}

		/**
		 * @return ValueAccessor\GetterInterface
		 */
		public function getGetter(){
			return $this->getter;
		}

		/**
		 * @param Record $data
		 * @param $key
		 * @return mixed
		 */
		public function formulaGet(Record $data, $key){
			return $data->getProperty($this->formula_key);
		}

		/**
		 * @param Record $data
		 * @param $key
		 * @param $value
		 * @return mixed
		 */
		public function formulaSet(Record $data, $key, $value){
			return $data->setProperty($this->formula_key,$value);
		}

		/**
		 * @param Record $data
		 * @param $key
		 * @return mixed|null
		 */
		public function valueAccessGet($data, $key){

			if(!$data instanceof Record){
				throw new \LogicException('Relation field valueAccessGet($data,$key) - $data must be Record instance');
			}

			$value = $data->getProperty($this->formula_key);
			$getter = $this->getGetter();
			if(!$getter){
				$value = call_user_func([$this,'formulaGet']);
			}else{
				$value = ValueAccessor::handleGetter($this->getGetter(),$data,$this->_getOuterInteractionKey(),[$this]);
			}
			if($value === null){
				$value = $this->getDefault();
			}
			return $value;
		}


		/**
		 * @param Record $data
		 * @param $key
		 * @param $value
		 * @return mixed|null
		 */
		public function valueAccessSet($data, $key, $value){

			if(!$data instanceof Record){
				throw new \LogicException('Relation field valueAccessGet($data,$key) - $data must be Record instance');
			}

			return $data->getOriginalData();
		}

		/**
		 * @return null|string
		 */
		protected function _getOuterInteractionKey(){
			if($this->formula_key){

			}
			if($this->original_key){
				return $this->original_key;
			}
			return parent::_getOuterInteractionKey();
		}




	}
}

