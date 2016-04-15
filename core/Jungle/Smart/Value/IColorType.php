<?php
/**
 * Created by PhpStorm.
 * Project: localhost
 * Date: 18.05.2015
 * Time: 17:08
 */

namespace Jungle\Smart\Value {

	use Jungle\Basic\INamed;

	/**
	 * Interface IColorType
	 * @package Jungle\Smart\Value
	 */
	interface IColorType extends INamed{

		/**
		 * @param string|array $color
		 * @return bool|array [$hue, $saturation, $luminance, $alpha]
		 */
		public function parse($color);

		/**
		 * @param int $hue [from 0 to 360 degree]
		 * @param int $saturation [percentage from 0 to 100]
		 * @param int $luminance [percentage from 0 to 100]
		 * @param double $alpha [from 0.0 to 1.0, double value]
		 * @return string $string_representation
		 */
		public function render($hue, $saturation, $luminance, $alpha = 1.0);

		/**
		 * @param int $hue [from 0 to 360 degree]
		 * @param int $saturation [percentage from 0 to 100]
		 * @param int $luminance [percentage from 0 to 100]
		 * @param double $alpha [from 0.0 to 1.0, double value]
		 * @return array
		 */
		public function represent($hue, $saturation, $luminance, $alpha = 1.0);

	}
}