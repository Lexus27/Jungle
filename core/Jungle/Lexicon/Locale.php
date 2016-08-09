<?php
/**
 * Created by Kutuzov Alexey Konstantinovich <lexus.1995@mail.ru>.
 * Author: Kutuzov Alexey Konstantinovich <lexus.1995@mail.ru>
 * Project: jungle
 * IDE: PhpStorm
 * Date: 20.07.2016
 * Time: 21:14
 */
namespace Jungle\Lexicon {

	/**
	 * Class Locale
	 * @package Jungle\Lexicon
	 */
	class Locale{

		/** @var  string */
		protected $language_code;

		/** @var  string */
		protected $region_code;

		/**
		 * @param $locale_name
		 * @return $this
		 */
		public function setLanguageCode($locale_name){
			$this->language_code = $locale_name;
			return $this;
		}

		/**
		 * @return string
		 */
		public function getLanguageCode(){
			return $this->language_code;
		}

		/**
		 * @param $regionCode
		 * @return $this
		 */
		public function setRegionCode($regionCode){
			$this->region_code = $regionCode;
			return $this;
		}

		/**
		 * @return string
		 */
		public function getRegionCode(){
			return $this->region_code;
		}

	}
}

