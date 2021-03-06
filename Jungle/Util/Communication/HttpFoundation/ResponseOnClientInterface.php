<?php
/**
 * Created by Kutuzov Alexey Konstantinovich <lexus.1995@mail.ru>.
 * Author: Kutuzov Alexey Konstantinovich <lexus.1995@mail.ru>
 * Project: jungle
 * IDE: PhpStorm
 * Date: 04.10.2016
 * Time: 13:44
 */
namespace Jungle\Util\Communication\HttpFoundation {

	/**
	 * Interface ResponseOnClientInterface
	 * @package Jungle\Util\Communication\HttpFoundation
	 */
	interface ResponseOnClientInterface{

		/**
		 * @param $message
		 * @return mixed
		 */
		public function setMessage($message);

		/**
		 * @return string
		 */
		public function getMessage();

	}
}

