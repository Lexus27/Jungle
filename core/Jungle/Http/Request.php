<?php
/**
 * Created by Kutuzov Alexey Konstantinovich <lexus.1995@mail.ru>.
 * Author: Kutuzov Alexey Konstantinovich <lexus.1995@mail.ru>
 * Project: jungle
 * IDE: PhpStorm
 * Date: 30.06.2016
 * Time: 18:36
 */
namespace Jungle\Http {
	
	use Jungle\Application\RequestInterface;
	use Jungle\User\AccessAuth\Auth;
	use Jungle\Util\Specifications\Http\BrowserInterface;
	use Jungle\Util\Specifications\Http\ResponseInterface;
	use Jungle\Util\Specifications\Http\ServerInterface;
	use Jungle\Util\Value;


	/**
	 * Class Request
	 * @package Jungle\Http\Request
	 */
	class Request implements \Jungle\Util\Specifications\Http\RequestInterface, RequestInterface{

		const AUTH_DIGEST   = 'digest';
		const AUTH_BASE     = 'base';

		/** @var  Request */
		protected static $instance;

		protected static $request_time;

		/** @var  array */
		protected $headers = [];

		/** @var  Auth */
		protected $auth;

		/** @var  Browser  */
		protected $browser;

		/** @var  Server  */
		protected $server;

		/** @var  Client  */
		protected $client;

		/** @var  Response  */
		protected $response;

		protected $uri;

		/**
		 * @return mixed
		 */
		public static function serverRequestTime(){
			if(is_null(self::$request_time)){
				self::$request_time = $_SERVER['REQUEST_TIME'];
			}
			return self::$request_time;
		}

		/**
		 *
		 */
		public function getUrl(){
			return $_SERVER['HTTP_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		}

		/**
		 * @return Request
		 */
		public static function getInstance(){
			if(!self::$instance){
				self::$instance = new Request();
			}
			return self::$instance;
		}

		/**
		 * Request constructor.
		 */
		protected function __construct(){
			$this->headers = getallheaders();
			if(isset($_SERVER['PHP_AUTH_USER']) && $_SERVER['PHP_AUTH_USER']){
				$this->auth = Auth::getAccessAuth([$_SERVER['PHP_AUTH_USER'],$_SERVER['PHP_AUTH_PW']]);
			}
			$this->browser  = new Browser();
			$this->server   = new Server();
			$this->client   = new Client($this);
			$this->response = new Response($this);
		}

		protected function __clone(){}



		/**
		 * @return ResponseInterface
		 */
		public function getResponse(){
			return $this->response;
		}

		/**
		 * @param $specificity
		 * @return bool
		 */
		public function hasSpecificity($specificity){
			return stripos($specificity,'http')!==false;
		}

		/**
		 * @return BrowserInterface
		 */
		public function getBrowser(){
			return $this->browser;
		}

		/**
		 * @return ServerInterface
		 */
		public function getServer(){
			return $this->server;
		}

		/**
		 * @return Client
		 */
		public function getClient(){
			return $this->client;
		}

		/**
		 * @param $name
		 * @return null
		 */
		public function getCookie($name){
			return isset($_COOKIE[$name])?$_COOKIE[$name]:null;
		}

		/**
		 * @param $name
		 * @return bool
		 */
		public function hasCookie($name){
			return isset($_COOKIE[$name]);
		}

		/**
		 * @return mixed
		 */
		public function getUserAgent(){
			return $_SERVER['HTTP_USER_AGENT'];
		}

		/**
		 * @return int
		 */
		public function getTime(){
			return $_SERVER['REQUEST_TIME'];
		}

		/**
		 * @return string
		 */
		public function getMethod(){
			return $_SERVER['REQUEST_METHOD'];
		}

		/**
		 * @return string
		 */
		public function getScheme(){
			return $_SERVER['REQUEST_SCHEME'];
		}


		/**
		 * @return string
		 */
		public function getAuthType(){
			return isset($_SERVER['PHP_AUTH_DIGEST']) && $_SERVER['PHP_AUTH_DIGEST']?self::AUTH_DIGEST:self::AUTH_BASE;
		}


		/**
		 * @return Auth|null
		 */
		public function getAuth(){
			return $this->auth;
		}

		/**
		 * @return string
		 */
		public function getUri(){
			if(is_null($this->uri)){
				$arr = explode('?',$_SERVER['REQUEST_URI']);
				$this->uri = $arr[0];
			}
			return $this->uri;
		}

		/**
		 * @return string
		 */
		public function getPath(){
			if(is_null($this->uri)){
				$arr = explode('?',$_SERVER['REQUEST_URI']);
				$this->uri = $arr[0];
			}
			return $this->uri;
		}

		/**
		 * @return bool
		 */
		public function isDelete(){
			return stripos($_SERVER['REQUEST_METHOD'],'delete')!==false;
		}

		/**
		 * @return bool
		 */
		public function isHead(){
			return stripos($_SERVER['REQUEST_METHOD'],'head')!==false;
		}

		/**
		 * @return bool
		 */
		public function isPatch(){
			return stripos($_SERVER['REQUEST_METHOD'],'patch')!==false;
		}

		/**
		 * @return bool
		 */
		public function isOptions(){
			return stripos($_SERVER['REQUEST_METHOD'],'options')!==false;
		}

		/**
		 * @return bool
		 */
		public function isPost(){
			return stripos($_SERVER['REQUEST_METHOD'],'post')!==false;
		}

		/**
		 * @return bool
		 */
		public function isGet(){
			return stripos($_SERVER['REQUEST_METHOD'],'get')!==false;
		}

		/**
		 * @return bool
		 */
		public function isPut(){
			return stripos($_SERVER['REQUEST_METHOD'],'put')!==false;
		}

		/**
		 * @return bool
		 */
		public function isSecure(){
			return (isset($_SERVER['HTTPS'])?true:false) && stripos($_SERVER['REQUEST_SCHEME'],'https')!==false;
		}


		/**
		 * @param $key
		 * @param null $filter
		 * @param null $default
		 * @return mixed
		 */
		public function getPost($key = null, $filter = null, $default = null){
			if($key === null){
				return $_POST;
			}
			if(isset($_POST[$key])){
				return $this->_handleValueFilter($_POST[$key],$filter);
			}
			return $default;
		}

		/**
		 * @param $key
		 * @return mixed
		 */
		public function hasPost($key = null){
			if($key === null)return !empty($_POST);
			return isset($_POST[$key]);
		}

		/**
		 * @param $parameter
		 * @param null $filter
		 * @param null $default
		 * @return mixed
		 */
		public function getParam($parameter = null, $filter = null, $default = null){
			if($parameter === null){
				return $_REQUEST;
			}
			if(isset($_REQUEST[$parameter])){
				return $this->_handleValueFilter($_REQUEST[$parameter],$filter);
			}
			return $default;
		}

		/**
		 * @param $parameter
		 * @return bool
		 */
		public function hasParam($parameter = null){
			if($parameter === null)return !empty($_REQUEST);
			return isset($_REQUEST[$parameter]);
		}

		/**
		 * @param $key
		 * @param null $filter
		 * @param null $default
		 * @return mixed
		 */
		public function getQuery($key = null, $filter = null, $default = null){
			if($key === null){
				return $_GET;
			}
			if(isset($_GET[$key])){
				return $this->_handleValueFilter($_GET[$key],$filter);
			}
			return $default;
		}

		/**
		 * @param $key
		 * @return mixed
		 */
		public function hasQuery($key = null){
			if($key === null)return !empty($_GET);
			return isset($_GET[$key]);
		}

		/**
		 * @param $key
		 * @return mixed
		 */
		public function getPut($key){

		}

		/**
		 * @param $key
		 * @return mixed
		 */
		public function hasPut($key){

		}

		/**
		 * @param $headerKey
		 * @param null $default
		 * @return mixed
		 */
		public function getHeader($headerKey, $default = null){
			return isset($this->headers[$headerKey])?$this->headers[$headerKey]:$default;
		}

		/**
		 * @return mixed
		 */
		public function getRequestedWith(){
			return $this->getHeader('Requested-With');
		}

		/**
		 * @return bool
		 */
		public function isAjax(){
			return strcasecmp($this->getHeader('Requested-With'),'XmlHttpRequest')===0;
		}




		/**
		 * @return string|null
		 */
		public function getReferrer(){
			return isset($_SERVER['HTTP_REFERRER'])?$_SERVER['HTTP_REFERRER']:null;
		}

		/**
		 * @param $headerKey
		 * @return bool
		 */
		public function hasHeader($headerKey){
			return isset($this->headers[$headerKey]);
		}

		/**
		 * @return mixed
		 */
		public function getContent(){
			return file_get_contents('php://input');
		}

		/**
		 * @return string
		 */
		public function getContentType(){
			return $this->getHeader('Content-Type');
		}

		/**
		 * @return bool
		 */
		public function isSoap(){
			return strpos($this->getContentType(),'soap')!==false;
		}

		/**
		 * @return bool
		 */
		public function isJson(){
			return strpos($this->getContentType(),'json')!==false;
		}

		/**
		 * @return bool
		 */
		public function isXml(){
			return strpos($this->getContentType(),'xml')!==false;
		}

		/**
		 * @return bool
		 */
		public function hasFiles(){
			return !empty($_FILES);
		}

		/**
		 * @return array
		 */
		public function getFiles(){
			return $_FILES;
		}
		/**
		 * @param $value
		 * @param null $filter
		 * @return mixed|null
		 *
		 * @TODO: Sanitize & Filter Value in DataBase and other, by RegExp Type component or implement filtering abstract subject for all usage
		 */
		protected function _handleValueFilter($value, $filter = null){
			if($filter === null){
				return $value;
			}
			if(is_array($filter)){
				if(isset($filter['filter'])){
					$_filter = array_replace([
						'type' => FILTER_DEFAULT,
						'options' => []
					],(array)$filter['filter']);
					$value = filter_var($value, $_filter['type'],$_filter['options']);
				}elseif(isset($filter['type'])){
					$value = filter_var($value, $filter['type']);
				}

				if(isset($filter['vartype'])){
					Value::settype($value, $filter['vartype']);
				}
				return $value;
			}else{
				return filter_var($value, $filter);
			}
		}

	}
}

