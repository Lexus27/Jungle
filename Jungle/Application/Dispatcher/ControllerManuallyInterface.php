<?php
/**
 * Created by Kutuzov Alexey Konstantinovich <lexus.1995@mail.ru>.
 * Author: Kutuzov Alexey Konstantinovich <lexus.1995@mail.ru>
 * Project: jungle
 * IDE: PhpStorm
 * Date: 07.05.2016
 * Time: 17:57
 */
namespace Jungle\Application\Dispatcher {

	/**
	 * Interface ControllerManuallyInterface
	 * @package Jungle\Application\Dispatcher\Controller
	 */
	interface ControllerManuallyInterface extends ControllerInterface{

		/**
		 * @param string $actionName
		 * @return bool
		 */
		public function has($actionName);

		/**
		 * @param string $actionName
		 * @param ProcessInterface $process
		 * @param array $options
		 * @return mixed
		 */
		public function call($actionName, ProcessInterface $process, array $options = []);

		/**
		 * @param $actionName
		 * @return array
		 */
		public function getActionMetadata($actionName);

		/**
		 * @return string[]
		 */
		public function getActionNames();

		/**
		 * @param $actionName
		 * @param \Exception $exception
		 * @param ProcessInterface $process
		 * @return bool
		 */
		public function interceptException($actionName, \Exception $exception, ProcessInterface $process);

		/**
		 * @param $actionName
		 * @param \Exception $exception
		 * @param ProcessInterface $process
		 * @return bool
		 */
		public function interceptedException($actionName, \Exception $exception, ProcessInterface $process);

	}
}

