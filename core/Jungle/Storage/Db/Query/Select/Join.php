<?php
/**
 * Created by PhpStorm.
 * User: Alexey
 * Date: 05.03.2016
 * Time: 20:20
 */
namespace Jungle\Storage\Db\Query\Select {

	use Jungle\Storage\Db\Query\Entity\Table;

	/**
	 * Class Join
	 * @package Jungle\Storage\Db\Query
	 */
	class Join{

		/** @var  Table */
		protected $target;

		/** @var  string */
		protected $condition;

	}
}

