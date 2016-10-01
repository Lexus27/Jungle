<?php
/**
 * Created by PhpStorm.
 * User: Alexey
 * Date: 28.01.2016
 * Time: 18:05
 */
namespace Jungle\Util\Communication\Stream\Connection {

	use Jungle\Util\Communication\Stream\Connection;

	/**
	 * Class Test
	 * @package Jungle\Util\Communication\Stream\Connection
	 */
	class Test extends Connection{
		/**
		 * @param $length
		 * @param callable|null $reader
		 * @return mixed
		 */
		protected function _read($length, callable $reader = null){
			return '200 Success data from this connection';
		}


		/**
		 * @param $data
		 * @param null $length
		 */
		protected function _send($data, $length = null){

		}

		protected function _connect(){
			$this->connection = true;
		}
	}
}

