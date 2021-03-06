<?php
/**
 * Created by Kutuzov Alexey Konstantinovich <lexus.1995@mail.ru>.
 * Author: Kutuzov Alexey Konstantinovich <lexus.1995@mail.ru>
 * Project: jungle
 * IDE: PhpStorm
 * Date: 14.07.2016
 * Time: 23:04
 */
namespace Jungle\Application {

	use Jungle\Di\DiInterface;
	use Jungle\Util\Named\NamedInterface;

	/**
	 * Interface StrategyInterface
	 * @package Jungle\Application
	 */
	interface StrategyInterface extends DiInterface, NamedInterface{

		/**
		 * @param $type
		 * @return mixed
		 */
		public function setName($type);

		/**
		 * @return string
		 */
		public function getName();

		/**
		 * @param ResponseInterface $response
		 * @param ViewInterface $view
		 */
		public function complete(ResponseInterface $response, ViewInterface $view);

		/**
		 * @return void
		 */
		public function registerServices();

		/**
		 * @param RequestInterface $request
		 * @return bool
		 */
		public static function check(RequestInterface $request);

	}
}

