<?php
/**
 * Created by PhpStorm.
 * User: Alexey
 * Date: 16.02.2016
 * Time: 18:59
 */
namespace Jungle\User\AccessControl\Policy\ConditionResolver\Exception {

	/**
	 * Class PathNotFound
	 * @package Jungle\User\AccessControl\Policy\ConditionResolver\Exception
	 */
	class PathNotFound extends Query{
		protected $type = 'path_not_found';

	}
}
