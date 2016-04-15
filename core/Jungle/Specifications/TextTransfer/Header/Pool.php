<?php
/**
 * Created by PhpStorm.
 * User: Alexey
 * Date: 10.01.2016
 * Time: 0:22
 */
namespace Jungle\Specifications\TextTransfer\Header {

	use Jungle\Smart\Keyword\Factory;
	use Jungle\Smart\Keyword\Pool as KeyPool;
	use Jungle\Smart\Keyword\Storage\Dummy;
	use Jungle\Specifications\TextTransfer\Header;
	use Phalcon\Text;

	/**
	 * Class Pool
	 * @package Jungle\HeaderCover\Header
	 */
	class Pool extends KeyPool{

		/**
		 * @var bool
		 */
		protected $dummy_allowed = true;

		/**
		 * @var bool
		 */
		protected $case_insensitive = true;

		/**
		 * @var Pool
		 */
		protected static $default_manager = null;

		/**
		 * @return Pool
		 */
		public static function getDefault(){
			if(!self::$default_manager){
				self::$default_manager = new self('RFCHeaderPool',new Dummy());
			}
			return self::$default_manager;
		}

		/**
		 * @param Pool $manager
		 */
		public static function setDefault(Pool $manager){
			self::$default_manager = $manager;
		}

		public static function getConcreteClassNameByHeader($header){
			return __NAMESPACE__.'\\Concrete\\'.(Text::camelize((string)$header));
		}

		/**
		 * @return Factory
		 */
		public function getFactory(){
			if(!$this->factory){
				$this->factory = new Factory(function($identifier){
					$className = self::getConcreteClassNameByHeader($identifier);
					if(class_exists($className) && is_a($className,__NAMESPACE__,true)){
						return new $className();
					}
					return new Header();
				});
			}
			return parent::getFactory();
		}


		/**
		 * @param string $key
		 * @return \Jungle\Smart\Keyword\Keyword
		 */
		public function get($key){
			return parent::get(Header::normalize($key));
		}


	}
}

