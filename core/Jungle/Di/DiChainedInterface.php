<?php
/**
 * Created by Kutuzov Alexey Konstantinovich <lexus.1995@mail.ru>.
 * Author: Kutuzov Alexey Konstantinovich <lexus.1995@mail.ru>
 * Project: jungle
 * IDE: PhpStorm
 * Date: 15.07.2016
 * Time: 16:39
 */
namespace Jungle\Di {

	/**
	 * Interface DiChainedInterface
	 * @package Jungle\Di
	 */
	interface DiChainedInterface{

		/**
		 * @return array|DiInterface[]
		 */
		public function getChains();

		/**
		 * @param $alias
		 * @param DiInterface $di
		 * @return $this
		 */
		public function setLayout($alias, DiInterface $di);

		/**
		 * @param $alias
		 * @return null
		 */
		public function getLayout($alias);

		/**
		 * @param array $order
		 * @return $this
		 */
		public function setLayoutsOrder(array $order);

	}
}

