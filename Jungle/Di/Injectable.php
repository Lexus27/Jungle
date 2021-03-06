<?php
/**
 * Created by Kutuzov Alexey Konstantinovich <lexus.1995@mail.ru>.
 * Author: Kutuzov Alexey Konstantinovich <lexus.1995@mail.ru>
 * Project: jungle
 * IDE: PhpStorm
 * Date: 22.06.2016
 * Time: 18:07
 */
namespace Jungle\Di {

	use Jungle\Application;
	use Jungle\Application\Dispatcher;
	use Jungle\Application\Dispatcher\Process;
	use Jungle\Application\RequestInterface as ApplicationRequestInterface;
	use Jungle\Application\ResponseInterface as ApplicationResponseInterface;
	use Jungle\Application\View\ViewStrategyInterface;
	use Jungle\Application\ViewInterface;
	use Jungle\Data\Record\SchemaManager;
	use Jungle\EventManager\EventManager;
	use Jungle\Loader;
	use Jungle\Messenger;
	use Jungle\User\Account;
	use Jungle\User\SessionManager;
	use Jungle\Util\Communication\HttpFoundation\Cookie\ManagerInterface;
	use Jungle\Util\Communication\HttpFoundation\RequestInterface;
	use Jungle\Util\Communication\HttpFoundation\ResponseInterface;
	use Jungle\Util\Communication\HttpFoundation\ResponseOnServerInterface;
	use Jungle\Util\Communication\HttpFoundation\ResponseSettableInterface;

	/**
	 * Class Injectable
	 * @package Jungle\Di
	 *
	 * @property Application $application
	 * @property Dispatcher $dispatcher
	 * @property \Jungle\Application\RouterInterface|\Jungle\Application\Strategy\Http\Router $router
	 * @property ApplicationRequestInterface|RequestInterface $request
	 * @property ApplicationResponseInterface|ResponseInterface|ResponseSettableInterface|ResponseOnServerInterface $response
	 * @property $cache
	 * @property $event
	 * @property EventManager $event_manager
	 *
	 * @property ViewInterface $view
	 * @property ViewStrategyInterface $view_strategy
	 *
	 * @property $filesystem
	 * @property $database
	 * @property SchemaManager $schema
	 *
	 * @property Loader $loader
	 *
	 * @property Account $account
	 * @property \Jungle\User\AccessControl\Manager $access
	 * @property SessionManager $session
	 * @property ManagerInterface $cookie
	 * @property Messenger $messenger
	 * @property Process process
	 */
	abstract class Injectable implements InjectionAwareInterface{

		use InjectionAwareTrait;

		/** @var bool  */
		protected static $_dependency_injection_cacheable = false;

		/** @var array  */
		protected $_dependency_injection_cache = [];

		/**
		 * @param $name
		 * @return mixed
		 */
		public function __get($name){
			if(static::$_dependency_injection_cacheable){
				if(!array_key_exists($name,$this->_dependency_injection_cache)){
					$result = $this->_dependency_injection->get($name);
					$this->_dependency_injection_cache[$name] = $result;
					return $result;
				}
				return $this->_dependency_injection_cache[$name];
			}else{
				if(!$this->_dependency_injection){
					throw new \LogicException('DependencyInjector is not supplied in object');
				}
				return $this->getDi()->get($name);
			}
		}

	}
}

