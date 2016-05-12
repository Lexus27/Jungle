<?php
/**
 * Created by Kutuzov Alexey Konstantinovich <lexus.1995@mail.ru>.
 * Author: Kutuzov Alexey Konstantinovich <lexus.1995@mail.ru>
 * Project: jungle
 * IDE: PhpStorm
 * Date: 08.05.2016
 * Time: 0:50
 */
namespace App\Modules {
	
	use Jungle\Application\Dispatcher;

	/**
	 * Class Main
	 * @package App\Modules
	 */
	class Main extends Dispatcher\Module{

		/**
		 * @return string
		 */
		public function getControllerNamespace(){
			return __NAMESPACE__ . '\\Main\\Controller';
		}


	}
}
