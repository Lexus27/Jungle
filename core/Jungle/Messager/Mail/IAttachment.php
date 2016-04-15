<?php
/**
 * Created by PhpStorm.
 * User: Alexey
 * Date: 30.12.2015
 * Time: 22:38
 */
namespace Jungle\Messager\Mail {

	/**
	 * Interface IMessageAttachment
	 * @package Jungle\Messager\Mail
	 */
	interface IAttachment{

		const TYPE_DEFAULT = 'application/octet-stream';

		const DISPOSITION_DEFAULT = 'attachment';

		/**
		 * @param $disposition
		 * @return mixed
		 */
		public function setDisposition($disposition = self::DISPOSITION_DEFAULT);

		/**
		 * @return mixed
		 */
		public function getDisposition();

		/**
		 * @param $type
		 * @return $this
		 * Mime-Type
		 */
		public function setType($type = self::TYPE_DEFAULT);

		/**
		 * @return mixed
		 */
		public function getType();


		/**
		 * @param $raw
		 * @return $this
		 */
		public function setRaw($raw);

		/**
		 * @return string
		 */
		public function getRaw();

		/**
		 * @param $src
		 * @return $this
		 */
		public function setSrc($src);

		/**
		 * @return string
		 */
		public function getSrc();

		/**
		 * @param null $name
		 * @return $this
		 */
		public function setName($name=null);

		/**
		 * @return mixed
		 */
		public function getName();

		public function setHeaders(array $headers);

		public function getHeaders();
	}
}

