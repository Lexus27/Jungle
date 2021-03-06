<?php
/**
 * Created by PhpStorm.
 * User: Alexey
 * Date: 02.02.2016
 * Time: 21:40
 */
namespace Jungle\FileSystem\Model {

	use Jungle\FileSystem\Model\Exception\ActionError;

	/**
	 * Class File
	 * @package Jungle\FileSystem\Model
	 *
	 * @property string $extension
	 * @property string $name
	 *
	 * @property MIXED $content
	 */
	class File extends Node{

		/** @var  string */
		protected $extension;

		/** @var  string */
		protected $name;

		/** @var  mixed */
		protected $content;


		/**
		 * @param $content
		 */
		public function setContent($content){

		}

		/**
		 *
		 */
		public function getContent(){

		}

		protected function getDefaultPermissions(){
			return $this->getManager()->getDefaultFilePermissions();
		}
		/**
		 * @return int|null
		 */
		public function getSize(){
			return $this->real_path?$this->getAdapter()->filesize($this->real_path):null;
		}

		/**
		 * @return bool
		 */
		public function isEmpty(){
			return !boolval($this->content);
		}

		/**
		 * @param $extension
		 * @return $this
		 */
		public function setExtension($extension){
			$this->setBasename($this->name. ($extension?'.' . $extension:''));
		}

		/**
		 * @return string
		 */
		public function getExtension(){
			return $this->extension;
		}

		/**
		 * @param $name
		 */
		public function setName($name){
			$this->setBasename($name. ($this->extension?'.' . $this->extension:''));
		}

		/**
		 * @return string
		 */
		public function getName(){
			return $this->name;
		}

		/**
		 * @param $basename
		 * @return $this|void
		 * @throws Exception
		 */
		public function setBasename($basename){
			parent::setBasename($basename);
			$name = pathinfo($basename,PATHINFO_FILENAME);
			if($this->name !== $name){
				$this->name = $name;
			}
			$ext = pathinfo($basename,PATHINFO_EXTENSION);
			if($this->extension !== $ext){
				$this->extension = $ext;
			}
		}

		/**
		 * Удаляет существующий файл , не выставляя его удаленным, используя объект как новый
		 */
		public function overwrite(){
			if($this->exists){
				$this->_delete();
				$this->exists       = false;
				$this->real_path    = null;
			}
			return $this;
		}

		/**
		 * @param $path
		 * @return bool
		 */
		protected function checkExistingNodeType($path){
			return $this->getAdapter()->is_file($path);
		}

		/**
		 * @param string $path
		 * @return mixed
		 * @throws ActionError
		 * @throws Exception
		 */
		protected function _create($path){
			if(!@$this->getAdapter()->mkfile($path)){
				$e = error_get_last();
				throw new ActionError(sprintf('Could not to create file %s , message %s',$path, $e['message']));
			}
		}

		/**
		 * Based from @see real_path
		 * @param string $destinationPath
		 * @return mixed
		 * @throws ActionError
		 * @throws Exception
		 */
		protected function _copy($destinationPath){
			if(!@$this->getAdapter()->copy($this->real_path, $destinationPath)){
				$e = error_get_last();
				throw new ActionError(sprintf('Could not copyNode file from "%s" to "%s", message: %s',$this->real_path, $destinationPath , $e['message']));
			}
		}

		/**
		 * Based from @see real_path
		 * @return mixed
		 * @throws ActionError
		 * @throws Exception
		 */
		protected function _delete(){
			if(!@$this->getAdapter()->unlink($this->real_path)){
				$e = error_get_last();
				throw new ActionError(sprintf('Could not remove file "%s", message: %s',$this->real_path , $e['message']));
			}
		}

		/**
		 * @param bool|false $recursive
		 * @return $this
		 */
		public function setReadOnly($recursive = false){
			$this->setPermissions(PermissionsInterface::PERMISSIONS_READ_ONLY_FILE);
			return $this;
		}


		/**
		 * @param $key
		 * @param $value
		 * @throws Exception
		 */
		public function __set($key,$value){
			switch($key){
				case 'extension':
					$this->setExtension($value);
					break;
				case 'name':
					$this->setName($value);
					break;
				case 'content':
					$this->setContent($value);
					break;
				default:
					parent::__set($key,$value);
					break;
			}
		}

		/**
		 * @param $key
		 * @return Directory|null|string
		 * @throws Exception
		 */
		public function __get($key){
			switch($key){
				case 'extension':
					return $this->extension;
					break;
				case 'name':
					return $this->name;
					break;
				case 'content':
					return $this->getContent();
					break;
				default:
					return parent::__get($key);
					break;
			}
		}

		/**
		 * @return string
		 */
		public function __toString(){
			return $this->getPublicPath();
		}

	}
}

