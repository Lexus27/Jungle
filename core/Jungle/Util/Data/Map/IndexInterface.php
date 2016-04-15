<?php
/**
 * Created by Kutuzov Alexey Konstantinovich <lexus.1995@mail.ru>.
 * Author: Kutuzov Alexey Konstantinovich <lexus.1995@mail.ru>
 * Project: jungle
 * IDE: PhpStorm
 * Date: 08.04.2016
 * Time: 18:48
 */
namespace Jungle\Util\Data\Map {

	interface IndexInterface{

		public function getFields();

		public function getType();

		public function setType($type);


	}
}

