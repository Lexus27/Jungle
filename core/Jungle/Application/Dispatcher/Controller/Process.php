<?php
/**
 * Created by Kutuzov Alexey Konstantinovich <lexus.1995@mail.ru>.
 * Author: Kutuzov Alexey Konstantinovich <lexus.1995@mail.ru>
 * Project: jungle
 * IDE: PhpStorm
 * Date: 07.05.2016
 * Time: 16:51
 */
namespace Jungle\Application\Dispatcher\Controller {
	
	use Jungle\Application\Dispatcher;
	use Jungle\Application\Dispatcher\ModuleInterface;
	use Jungle\Application\Dispatcher\Router\RoutingInterface;

	/**
	 * Class Process
	 * @package Jungle\Application\Dispatcher\Controller
	 */
	class Process implements ProcessInterface, ProcessInitiatorInterface{

		/** @var  Dispatcher */
		protected $dispatcher;

		/** @var  bool */
		protected $initiator_external;

		/** @var  ProcessInitiatorInterface|RoutingInterface|ProcessInterface|null */
		protected $initiator;

		/** @var  ModuleInterface|null */
		protected $module;

		/** @var  object|ControllerInterface|ControllerManuallyInterface */
		protected $controller;

		/** @var  mixed */
		protected $reference;

		/** @var  array */
		protected $params = [];

		/** @var  bool */
		protected $completed = false;

		/** @var  bool */
		protected $canceled = false;

		/** @var  mixed */
		protected $result = null;

		/** @var  bool */
		protected $output_buffering = false;

		/** @var  string|null */
		protected $output_buffer;

		/**
		 * Process constructor.
		 * @param Dispatcher $dispatcher
		 * @param object|ControllerInterface|ControllerManuallyInterface $controller
		 * @param array $params
		 * @param mixed $reference
		 * @param ModuleInterface $module
		 * @param ProcessInitiatorInterface|RoutingInterface|ProcessInterface $initiator
		 */
		public function __construct(
				Dispatcher $dispatcher,
				$controller,
				array $params,
				$reference,
				ModuleInterface $module = null,
				ProcessInitiatorInterface $initiator = null
		){
			$this->module				= $module;
			$this->dispatcher 			= $dispatcher;
			$this->initiator_external 	= $initiator instanceof RoutingInterface;
			$this->initiator 			= $initiator;
			$this->controller 			= $controller;
			$this->params 				= $params;
			$this->reference 			= $reference;
		}

		/**
		 * @return ProcessInterface|null
		 */
		public function getRoot(){
			$initiator = $this->getInitiator();
			if(!$initiator){
				return null;
			}
			if($initiator instanceof ProcessInterface){
				return $initiator;
			}else{
				return $initiator->getRoot();
			}
		}

		/**
		 * @return Dispatcher
		 */
		public function getDispatcher(){
			return $this->dispatcher;
		}

		/**
		 * @return ModuleInterface|null
		 */
		public function getModule(){
			return $this->module;
		}

		/**
		 * @return ControllerInterface|ControllerManuallyInterface|object
		 */
		public function getController(){
			return $this->controller;
		}

		/**
		 * @param array $requires
		 * @return mixed|void
		 */
		public function requires(array $requires){
			foreach($requires as $require){
				list($param, $type, $default) = array_replace([null,null,null],explode(':',$require,3));
				if(!array_key_exists($param,$this->params[$param])){



				}

			}
		}

		/**
		 * @return mixed
		 */
		public function getActionName(){
			return $this->reference['action'];
		}


		/**
		 * @return mixed
		 */
		public function getReference(){
			return $this->reference;
		}

		/**
		 * @return string
		 */
		public function getReferenceString(){

			$module = $this->reference['module']?$this->reference['module']:false;
			$controller = $this->reference['controller']?$this->reference['controller']:false;
			$action = $this->reference['action']?$this->reference['action']:false;
			if($module){
				return '#' . $module . ':' . $controller . ':' . $action;
			}else{
				if($controller){
					return $controller . ':' . $action;
				}else{
					return  $action;
				}
			}
		}

		/**
		 * @return array
		 */
		public function getParams(){
			return $this->params;
		}

		/**
		 * HMVC-Architecture
		 * @return mixed
		 */
		public function isExternal(){
			return $this->initiator_external;
		}

		/**
		 * @return ProcessInterface|RoutingInterface|null
		 */
		public function getInitiator(){
			return $this->initiator;
		}

		/**
		 * @return RoutingInterface|null
		 */
		public function getRouting(){
			$initiator = $this->initiator;
			if(!$initiator){
				return null;
			}
			if($initiator instanceof RoutingInterface){
				return $initiator;
			}else{
				return $initiator->getRouting();
			}
		}


		/**
		 * @return Dispatcher\RouterInterface|null
		 */
		public function getRouter(){
			$routing = $this->getRouting();
			if(!$routing){
				return null;
			}
			return $routing->getRouter();
		}


		/**
		 * @return ProcessInterface|null
		 */
		public function getParent(){
			return $this->initiator_external? null : $this->initiator;
		}

		/**
		 * @param $reference
		 * @param $data
		 * @param array $options
		 * @return mixed
		 * @throws Dispatcher\Exception\Control
		 */
		public function call($reference, $data = null, array $options = null){
			$reference = $this->dispatcher->normalizeReference($reference,null,false);
			return $this->dispatcher->control($reference, $data, $options, $this);
		}

		/**
		 * @param $reference
		 * @param $data
		 * @param array $options
		 * @return mixed
		 * @throws Dispatcher\Exception\Control
		 */
		public function callIn($reference, $data = null, array $options = null){
			$reference = $this->dispatcher->normalizeReference($reference,null,false);
			$reference['module']		= $this->reference['module'];
			$reference['controller']	= $this->reference['controller'] . '.' . $reference['controller'];
			return $this->dispatcher->control($reference, $data, $options, $this);
		}

		/**
		 * @param $action
		 * @param $data
		 * @param array $options
		 * @return mixed
		 * @throws Dispatcher\Exception\Control
		 */
		public function callCurrent($action, $data, array $options = null){
			$reference = $this->reference;
			if(strcasecmp($reference['action'],$action)===0){
				throw new \LogicException('Executing current action not allowed');
			}
			$reference['action'] = $action;
			return $this->dispatcher->control($reference, $data, $options, $this);
		}

		/**
		 * @param $data
		 * @param $action
		 * @param array $options
		 * @return mixed
		 * @throws Dispatcher\Exception\Control
		 */
		public function callParent($data, $action = null, array $options = null){
			if($this->initiator instanceof Process){
				$reference = $this->initiator->reference;
				if($action!==null){
					$reference['action'] = $action;
				}
				return $this->dispatcher->control($reference, $data, $options, $this);
			}else{
				throw new \LogicException('Call Parent: initiator is not Process');
			}
		}

		/**
		 * @param $key
		 * @return mixed
		 */
		public function __get($key){
			return isset($this->params[$key])?$this->params[$key]:null;
		}

		/**
		 * @param $key
		 * @return mixed
		 */
		public function __isset($key){
			return isset($this->params[$key]);
		}

		/**
		 * @param $key
		 * @param $value
		 * @return mixed
		 */
		public function __set($key, $value){
			throw new \LogicException('Not Effect');
		}

		/**
		 * @param $key
		 * @return mixed
		 */
		public function __unset($key){
			throw new \LogicException('Not Effect');
		}

		/**
		 * @return bool
		 */
		public function isCompleted(){
			return $this->completed;
		}

		/**
		 * @param bool|true $completed
		 * @return $this
		 */
		public function setCompleted($completed = true){
			$this->completed = $completed;
			return $this;
		}

		/**
		 * @param $result
		 * @param bool $completed
		 * @return $this
		 */
		public function setResult($result, $completed = true){
			$this->result = $result;
			$this->completed = $completed;
			return $this;
		}

		/**
		 * @return $this
		 */
		public function cancel(){
			$this->canceled = true;
			return $this;
		}

		/**
		 * @return bool
		 */
		public function isCanceled(){
			return $this->canceled;
		}

		/**
		 * @return mixed
		 */
		public function getResult(){
			return $this->result;
		}

		/**
		 * @return mixed
		 */
		public function startOutputBuffering(){
			if(!$this->output_buffering){
				ob_start();
				$this->output_buffer = null;
				$this->output_buffering = true;
			}
		}

		/**
		 * @return mixed
		 */
		public function endOutputBuffering(){
			if($this->output_buffering){
				$this->output_buffer = ob_get_clean();
				$this->output_buffering = false;
			}
		}

		/**
		 * @return mixed
		 */
		public function getOutputBuffer(){
			return $this->output_buffer;
		}


	}
}

