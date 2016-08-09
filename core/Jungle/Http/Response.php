<?php
/**
 * Created by Kutuzov Alexey Konstantinovich <lexus.1995@mail.ru>.
 * Author: Kutuzov Alexey Konstantinovich <lexus.1995@mail.ru>
 * Project: jungle
 * IDE: PhpStorm
 * Date: 30.06.2016
 * Time: 21:23
 */
namespace Jungle\Http {
	
	use Jungle\Util\Specifications\Http\Cookie;
	use Jungle\Util\Specifications\Http\CookieInterface;
	use Jungle\Util\Specifications\Http\RequestInterface;
	use Jungle\Util\Specifications\Http\ResponseInterface;
	use Jungle\Util\Specifications\Http\ResponseSettableInterface;
	use Jungle\Util\Specifications\Http\ServerInterface;

	/**
	 * Class Response
	 * @package Jungle\Http
	 */
	class Response implements \Jungle\Application\ResponseInterface,ResponseInterface, ResponseSettableInterface{

		/** @var  bool */
		protected $sent = false;

		/** @var  int */
		protected $code;

		/** @var  array */
		protected $headers = [];

		/** @var  CookieInterface[] */
		protected $cookies = [];

		/** @var  mixed */
		protected $content;

		/** @var  Request */
		protected $request;

		/**
		 * Response constructor.
		 * @param Request $request
		 */
		public function __construct(Request $request){
			$this->request = $request;
		}

		/**
		 * @param null $path
		 * @param int $code
		 */
		public function sendRedirect($path = null, $code = 302){
			$this->headers['Location'] = $path;
			$this->setCode($code);
			$this->send();
			exit(0);
		}

		/**
		 * @param null $path
		 * @param int $code
		 * @return $this
		 */
		public function setRedirect($path = null, $code = 302){
			$this->headers['Location'] = $path;
			$this->setCode($code);
			return $this;
		}

		/**
		 * @return bool
		 */
		public function isRedirect(){
			return isset($this->headers['Location']);
		}

		/**
		 * @return bool
		 */
		public function isTemporalRedirect(){
			return $this->code === 302;
		}

		/**
		 * @return null
		 */
		public function getRedirectUrl(){
			return isset($this->headers['Location'])?$this->headers['Location']:null;
		}


		/**
		 * @param null $code
		 * @return $this
		 */
		public function setCode($code = null){
			$this->code = $code;
			return $this;
		}

		/**
		 * @return mixed
		 */
		public function getCode(){
			return $this->code;
		}

		/**
		 * @param $key
		 * @param $value
		 * @return mixed
		 */
		public function setHeader($key, $value){
			$this->headers[$key] = $value;
			return $this;
		}

		/**
		 * @param $key
		 * @return mixed
		 */
		public function getHeader($key){
			return $this->headers[$key];
		}



		/**
		 * @param $key
		 * @param $value
		 * @param int $expire
		 * @param string $path
		 * @param null $secure
		 * @param null $httpOnly
		 * @param null $host
		 * @return CookieInterface
		 */
		public function setCookie($key, $value, $expire = null, $path = null, $secure = null, $httpOnly = null, $host = null){
			if(isset($this->cookies[$key])){
				$cookie = $this->cookies[$key];
			}else{
				$this->cookies[$key] = $cookie = new Cookie();
				$cookie->setName($key);
			}
			$cookie->setValue($value);
			$cookie->setExpires($expire);
			$cookie->setPath($path);
			$cookie->setSecure($secure);
			$cookie->setHttpOnly($httpOnly);
			$cookie->setHost($host);
			return $cookie;
		}

		/**
		 * @param $key
		 * @return Cookie
		 */
		public function getCookie($key){
			return isset($this->cookies[$key])?$this->cookies[$key]:null;
		}

		/**
		 * @return \Jungle\Util\Specifications\Http\CookieInterface[]
		 */
		public function getCookies(){
			return $this->cookies;
		}

		/**
		 * @param $content
		 * @return mixed
		 */
		public function setContent($content){
			$this->content = $content;
			return $this;
		}

		/**
		 * @return mixed
		 */
		public function getContent(){
			return $this->content;
		}

		/**
		 * @param $type
		 * @return mixed
		 */
		public function setContentType($type = null){
			$this->headers['Content-Type'] = $type;
			return $this;
		}

		/**
		 * @return mixed
		 */
		public function getContentType(){
			return isset($this->headers['Content-Type'])?$this->headers['Content-Type']:'text/html';
		}

		/**
		 * @param $disposition
		 * @return mixed
		 */
		public function setContentDisposition($disposition = null){
			$this->headers['Content-Disposition'] = $disposition;
			return $this;
		}

		/**
		 * @return mixed
		 */
		public function getContentDisposition(){
			return $this->headers['Content-Disposition'];
		}

		/**
		 * @return bool
		 */
		public function isSent(){
			return $this->sent;
		}

		/**
		 * @return void
		 */
		public function send(){
			if(!$this->sent){
				$time = $_SERVER['REQUEST_TIME'];
				$this->sent = true;
				http_response_code($this->code);
				foreach($this->cookies as $cookie){
					$name = $cookie->getName();
					$value = $cookie->getValue();
					$expire = $cookie->getExpires();
					$path = $cookie->getPath();
					$host = $cookie->getHost();
					$secure = $cookie->isSecure();
					$httpOnly = $cookie->isHttpOnly();
					if(is_array($value) || is_object($value)){
						if($old = $this->request->getCookie($name)){
							if(is_array($old)){
								setcookie($name,null,$time-3600);
								foreach($old as $i => $v){
									setcookie($name.'['.$i.']',null,$time-3600);
								}
							}else{
								setcookie($name,null,$time-3600);
							}
						}
						foreach($value as $i => $v){
							setcookie($name.'['.$i.']',$v,$expire,$path,$host,$secure,$httpOnly);
						}
					}else{
						setcookie($name,$value,$expire,$path,$host,$secure,$httpOnly);
					}
				}
				foreach($this->headers as $key => $header){
					if($header){
						header($key.': '.$header);
					}
				}
				echo $this->content;
			}

		}

		/**
		 * @param RequestInterface $request
		 * @return mixed
		 * @throws \Exception
		 */
		public function setRequest(RequestInterface $request){
			throw new \Exception('Not effect');
		}

		/**
		 * @return RequestInterface
		 */
		public function getRequest(){
			return $this->request;
		}

		/**
		 * @param ServerInterface $server
		 * @return mixed
		 * @throws \Exception
		 */
		public function setServer(ServerInterface $server){
			throw new \Exception('Not effect');
		}

		/**
		 * @return ServerInterface
		 */
		public function getServer(){
			return $this->request->getServer();
		}
	}
}

