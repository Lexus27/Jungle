<?php
/**
 * Created by PhpStorm.
 * User: Alexey
 * Date: 03.02.2016
 * Time: 15:42
 */
namespace Jungle\FileSystem\Adapter {

	use Jungle\FileSystem;
	use Jungle\FileSystem\Model\Exception;

	/**
	 * Class Adapter
	 * @package Jungle\FileSystem\Model\Manager
	 */
	abstract class Adapter{

		/** @var string */
		protected $root_path;

		/** @var bool  */
		protected $relative_enabled = true;


		public $charset              = 'utf-8';

		public $charset_file_system  = 'utf-8';


		/**
		 * @param null $enabled
		 * @return bool
		 */
		public function relativeEnabled($enabled = null){
			if(is_bool($enabled)){
				$this->relative_enabled = $enabled;
			}
			return $this->relative_enabled;
		}

		public function transfer(
			Adapter $origin,        $originPath,
			Adapter $destination,   $destinationPath
		){
			$content = $origin->file_get_contents($originPath);
			$destination->file_put_contents($destinationPath,$content);
		}

		/**
		 * @param null $root
		 * @param bool $auto_create
		 * @param null $fs_charset
		 * @throws Exception
		 */
		public function __construct($root = null, $auto_create = false, $fs_charset = null){
			if($fs_charset){
				$this->charset_file_system = $fs_charset;
			}
			$this->setRootPath($root,$auto_create);
		}

		/**
		 * @param $path
		 * @param bool $auto_create
		 * @throws Exception
		 */
		public function setRootPath($path,$auto_create = false){
			if($this->root_path!==null){
				throw new Exception("Root absolute already isset");
			}elseif($path){
				if(!$this->is_dir($path)){
					if($auto_create){
						$this->mkdir($path,0755,true);
					}else{
						throw new Exception("Could not set root absolute to not exists directory");
					}
				}
				$this->root_path = ltrim(dirname($path),'.\\/').$this->ds().basename($path);
			}else{
				$this->root_path = false;
			}
		}

		/**
		 * @return string
		 */
		public function getRootPath(){
			return $this->root_path;
		}

		/**
		 * @return string
		 */
		public function ds(){
			return DIRECTORY_SEPARATOR;
		}

		/**
		 * @param $path
		 * @return string
		 */
		public function normalize($path){
			return iconv($this->charset, $this->charset_file_system . '//TRANSLIT' ,$path);
		}

		/**
		 * @param $path
		 * @return string
		 */
		public function absolute($path, $for_fs = false){
			$absolute_path = $this->relative_enabled && $this->root_path?($this->root_path . $this->ds() . ltrim($path,'\\/')):$path;
			return $for_fs?$this->normalize($absolute_path):$absolute_path;
		}


		/**
		 * @param $path
		 * @return null|string
		 */
		public function relative($path){
			if($this->root_path){
				if(strpos($path,$this->root_path)===0){
					return substr($path,0,strlen($this->root_path));
				}else{
					return null;
				}
			}else{
				return $path;
			}
		}

		/**
		 * @param $path
		 * @return int
		 */
		abstract public function filesize($path);

		/**
		 * @param $path
		 * @return float
		 */
		abstract public function disk_free_space($path);

		/**
		 * @param $path
		 * @return float
		 */
		abstract public function disk_total_space($path);

		/**
		 * @param $path
		 * @param null $modifyTime
		 * @param null $accessTime
		 * @return mixed
		 */
		abstract public function touch($path, $modifyTime = null, $accessTime = null);

		/**
		 * @param $path
		 * @return mixed
		 */
		abstract public function fileatime($path);

		/**
		 * @param $path
		 * @return mixed
		 */
		abstract public function filemtime($path);

		/**
		 * @param $path
		 * @return mixed
		 */
		abstract public function filectime($path);

		/**
		 * @param string $path
		 * @return bool
		 */
		abstract public function is_link($path);

		/**
		 * @param string $path
		 * @return bool
		 */
		abstract public function is_dir($path);

		/**
		 * @param string $path
		 * @return bool
		 */
		abstract public function is_file($path);

		/**
		 * @param string $path
		 * @return bool
		 */
		abstract public function is_readable($path);

		/**
		 * @param string $path
		 * @return bool
		 */
		abstract public function is_writable($path);

		/**
		 * @param string $path
		 * @return bool
		 */
		abstract public function is_executable($path);

		/**
		 * @param string $path
		 * @return int
		 */
		abstract public function fileperms($path);

		/**
		 * @param string $path
		 * @return int
		 */
		abstract public function fileowner($path);

		/**
		 * @param string $path
		 * @return bool
		 */
		abstract public function file_exists($path);

		/**
		 * @param string $path
		 * @return bool
		 */
		abstract public function unlink($path);

		/**
		 * @param string $path
		 * @param int $mod
		 * @param bool $recursive
		 * @return bool
		 */
		abstract public function mkdir($path, $mod = 0777, $recursive = false);

		/**
		 * @param $path
		 * @return bool
		 * @throws \LogicException
		 */
		abstract public function mkfile($path);

		/**
		 * @param string $path
		 * @return bool
		 */
		abstract public function rmdir($path);

		/**
		 * @param string $path
		 * @param int $owner
		 * @return bool
		 */
		abstract public function chown($path, $owner);

		/**
		 * @param string $path
		 * @param int $mod
		 * @return bool
		 */
		abstract public function chmod($path, $mod);

		/**
		 * @param $path
		 * @param $group
		 * @return mixed
		 */
		abstract public function chgrp($path, $group);

		/**
		 * @param string $path
		 * @param string $newPath
		 * @return bool
		 */
		abstract public function rename($path, $newPath);

		/**
		 * @param string $path
		 * @param string $destination
		 * @return bool
		 */
		abstract public function copy($path, $destination);

		/**
		 * @param $path
		 * @return array
		 */
		abstract public function nodeList($path);

		/**
		 * @param $pattern
		 * @return array
		 */
		abstract public function nodeListMatch($pattern);

		/**
		 * @param string $filePath
		 * @return string
		 */
		abstract public function file_get_contents($filePath);

		/**
		 * @param string $filePath
		 * @param string $content
		 * @return mixed
		 */
		abstract public function file_put_contents($filePath, $content);



	}
}

