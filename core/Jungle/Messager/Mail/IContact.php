<?php
/**
 * Created by PhpStorm.
 * User: Alexey
 * Date: 30.12.2015
 * Time: 22:38
 */
namespace Jungle\Messager\Mail {

	use Jungle\Messager\IContactNamed;

	/**
	 * Interface IMailDestination
	 * @package Jungle\Messager\Mail
	 */
	interface IContact extends IContactNamed{

		const TYPE_MAIN     = 0;
		const TYPE_CC       = 1;
		const TYPE_BCC      = 2;

		/**
		 * @param int $type
		 * @return $this
		 */
		public function setType($type);

		/**
		 * @return int
		 */
		public function getType();

	}
}

