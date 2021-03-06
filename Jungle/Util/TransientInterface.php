<?php
/**
 * Created by PhpStorm.
 * Project: MobileCasino
 * Date: 12.03.2015
 * Time: 0:12
 */

namespace Jungle\Util;

/**
 * Interface TransientInterface(Переходящий)
 * @package Jungle\Basic
 * Обеспечивающий целостность данных
 */
interface TransientInterface {

	/**
	 * Указать что объект был изменен или наоборот приведен к исходному состоянию
	 * @param bool|true $dirty
	 * @return $this
	 */
	public function setDirty($dirty = true);

	/**
	 * является ли объект измененным?
	 * @return bool
	 */
	public function isDirty();

}