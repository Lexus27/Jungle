<?php
/**
 * Created by Kutuzov Alexey Konstantinovich <lexus.1995@mail.ru>.
 * Author: Kutuzov Alexey Konstantinovich <lexus.1995@mail.ru>
 * Project: b2c-pay
 * IDE: PhpStorm
 * Date: 09.11.2016
 * Time: 20:38
 */
namespace Jungle\Application\Router {

	/**
	 * Class NotFoundRoute
	 * @package Jungle\Jungle\Application\Router
	 */
	class NotFoundRoute extends Route{

		/**
		 * NotFoundRoute constructor.
		 * @param array $reference
		 * @param array $params
		 */
		public function __construct(array $reference, array $params){
			$this->default_reference = $reference;
			$this->default_params = $params;
		}


		public function beforeMatch(callable $beforeMatch = null){}

		public function isDynamic(){
			return false;
		}

		public function getDynamics(){
			return [];
		}

		public function generateRequest($params, $reference, $preferred_request){
			throw new \Exception('NotFound route not create request');
		}

		public function generateLink($params = null, $reference = null, array $specials = null){
			throw new \Exception('NotFound route not create link');
		}

		public function match(RoutingInterface $routing){
			throw new \Exception('NotFound route not matchable');
		}

		protected function getTemplateManager(){
			throw new \Exception('NotFound route not template managers');
		}

		public function bind($parameter, callable $decomposite, callable $composite){
			return parent::bind($parameter, $decomposite, $composite); // TODO: Change the autogenerated stub
		}

		protected function _compilePattern(){
			throw new \Exception('NotFound route not _compilePattern usable');
		}


		public function prepareRenderBindParams(array $params){
			return $params;
		}

		public function prepareMatchedBindParams(array $params){
			return $params;
		}

		public function getConverter(){
			return null;
		}


	}
}

