<?php
/**
 * Created by PhpStorm.
 * User: Alexey
 * Date: 07.03.2016
 * Time: 20:49
 */
namespace Jungle\Data\Storage\Db\Lexer\SignManager {

	use Jungle\Data\Storage\Db\Lexer\Sign;
	use Jungle\Util\Smart\Keyword\Factory;
	use Jungle\Util\Smart\Keyword\Pool;
	use Jungle\Util\Smart\Keyword\Storage;

	/**
	 * Class SignPool
	 * @package Jungle\Data\Storage\Db\Lexer
	 */
	class SignPool extends Pool{

		/**
		 * @param Storage $storage
		 */
		public function __construct(Storage $storage){
			parent::__construct('SignPool',$storage);
		}
		/**
		 * @return Factory
		 */
		public function getFactory(){
			if(!$this->factory){
				$this->factory = new Factory(function(){
					return new Sign();
				});
			}
			return $this->factory;
		}

	}
}

