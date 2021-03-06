<?php
/**
 * Created by Kutuzov Alexey Konstantinovich <lexus.1995@mail.ru>.
 * Author: Kutuzov Alexey Konstantinovich <lexus.1995@mail.ru>
 * Project: jungle
 * IDE: PhpStorm
 * Date: 17.10.2016
 * Time: 15:48
 */
namespace Jungle\Util\ProcessUnit {

	/**
	 * Class ProcessCollector
	 * @package Jungle\Util\ProcessUnit
	 */
	class ProcessCollector implements ProcessCollectorInterface{

		/** @var  Process[]  */
		protected $processes = [];

		/**
		 * @param ProcessInterface $process
		 * @return $this
		 */
		public function push(ProcessInterface $process){
			$this->processes[] = $process;
			return $this;
		}

		/**
		 * @return Process
		 */
		public function last(){
			return end($this->processes);
		}

		/**
		 * @return Process
		 */
		public function first(){
			reset($this->processes);
			return current($this->processes);
		}

		/**
		 * @return int
		 */
		public function count(){
			return count($this->processes);
		}

		/**
		 * @return Process[]
		 */
		public function getCollection(){
			return $this->processes;
		}

	}
}

