<?php
/**
 * Created by Kutuzov Alexey Konstantinovich <lexus.1995@mail.ru>.
 * Author: Kutuzov Alexey Konstantinovich <lexus.1995@mail.ru>
 * Project: jungle
 * IDE: PhpStorm
 * Date: 30.06.2016
 * Time: 13:34
 */
namespace Jungle\Util\Communication\HttpFoundation {

	use Jungle\User\AccessAuth\Auth;
	use Jungle\Util\Communication\Hypertext\HeaderRegistryReadInterface;
	use Jungle\Util\Communication\URL;

	/**
	 * Interface RequestInterface
	 * @package Jungle\Util\Communication\HttpFoundation
	 */
	interface RequestInterface extends HeaderRegistryReadInterface{

		/**
		 * @return ResponseInterface
		 */
		public function getResponse();

		/**
		 * @return BrowserInterface
		 */
		public function getBrowser();

		/**
		 * @return ServerInterface
		 */
		public function getServer();

		/**
		 * @return ClientInterface
		 */
		public function getClient();

		/**
		 * @return string
		 */
		public function getAuthType();

		/**
		 * @return Auth|null
		 */
		public function getAuth();

		/**
		 * @return string
		 */
		public function getUserAgent();

		/**
		 * @return int
		 */
		public function getTime();


		/**
		 * @return string
		 */
		public function getMethod();

		/**
		 * @return string
		 */
		public function getUrl();

		/**
		 * @return string
		 */
		public function getFullPath();

		/**
		 * @return bool
		 */
		public function isPost();

		/**
		 * @return bool
		 */
		public function isGet();

		/**
		 * @return bool
		 */
		public function isHead();

		/**
		 * @return bool
		 */
		public function isDelete();

		/**
		 * @return bool
		 */
		public function isPatch();

		/**
		 * @return bool
		 */
		public function isOptions();

		/**
		 * @return bool
		 */
		public function isConnect();

		/**
		 * @return bool
		 */
		public function isTrace();


		/**
		 * @return mixed
		 */
		public function isSecure();

		/**
		 * @return mixed
		 */
		public function getScheme();

		/**
		 * @return string
		 */
		public function getUri();

		/**
		 * @param $parameter
		 * @param null $default
		 * @return mixed
		 */
		public function getParam($parameter = null, $default = null);

		/**
		 * @param $parameter
		 * @return bool
		 */
		public function hasParam($parameter = null);

		/**
		 * @param $key
		 * @param null $default
		 * @return mixed
		 */
		public function getQuery($key = null, $default = null);

		/**
		 * @param $key
		 * @return mixed
		 */
		public function hasQuery($key = null);

		/**
		 * @param $key
		 * @param null $default
		 * @return mixed
		 */
		public function getPost($key = null, $default = null);

		/**
		 * @return bool
		 */
		public function hasObject();

		/**
		 * @return array|mixed|null
		 */
		public function getObject();

		/**
		 * @param $key
		 * @param null $default
		 * @return mixed|null
		 */
		public function getObjectParam($key, $default = null);

		/**
		 * @param $key
		 * @return bool
		 */
		public function hasObjectParam($key);

		/**
		 * @param $key
		 * @return mixed
		 */
		public function hasPost($key = null);

		/**
		 * @return bool
		 */
		public function isPut();

		/**
		 * @return string|null
		 */
		public function getReferrer();

		/**
		 * @return mixed
		 */
		public function getRequestedWith();

		/**
		 * @param $name
		 * @return mixed
		 */
		public function getCookie($name);

		/**
		 * @param $name
		 * @return mixed
		 */
		public function hasCookie($name);

		/**
		 * @return bool
		 */
		public function isAjax();

		/**
		 * @return string
		 */
		public function getContentType();

		/**
		 * @return mixed
		 */
		public function getContent();

		/**
		 * @return bool
		 */
		public function hasFiles();

		/**
		 * @return array
		 */
		public function getFiles();

	}
}

