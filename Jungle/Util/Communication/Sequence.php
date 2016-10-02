<?php
/**
 * Created by Kutuzov Alexey Konstantinovich <lexus.1995@mail.ru>.
 * Author: Kutuzov Alexey Konstantinovich <lexus.1995@mail.ru>
 * Project: jungle
 * IDE: PhpStorm
 * Date: 02.10.2016
 * Time: 19:34
 */
namespace Jungle\Util\Communication {

	use Jungle\Util\Communication\Sequence\CommandInterface;
	use Jungle\Util\Communication\Sequence\Exception;
	use Jungle\Util\Communication\Sequence\Exception\FatalException;
	use Jungle\Util\Communication\Sequence\Exception\RuleMessage;
	use Jungle\Util\Communication\Sequence\ProcessInterface;
	use Jungle\Util\Communication\Sequence\ProcessSequence;
	use Jungle\Util\Communication\Sequence\ProcessSequenceInterface;
	use Jungle\Util\Communication\Sequence\Specification;
	use Jungle\Util\Communication\Sequence\SpecificationInterface;

	/**
	 * Class Sequence
	 * @package Jungle\Util\Communication
	 */
	class Sequence implements SequenceInterface{

		/** @var array  */
		protected $config = [];

		/** @var  array */
		protected $sequence = [];

		/** @var  SpecificationInterface */
		protected $specification;

		/** @var  Connection */
		protected $connection;


		/**
		 * @param array $sequence
		 * @throws Exception
		 */
		public function setSequence(array $sequence){
			foreach($sequence as & $item){
				$item = array_replace([
					'name'          => null,
					'params'        => null,
					'aggregation'   => null,
				],$item);
				if(!isset($item['aggregation']) || !isset($item['params'])){
					$item['params'] = (array)$item['params'];
				}
				$item['command'] = $this->specification->getCommand($item['name']);
				if(!$item['command']){
					throw new Exception('Not found command with name "'.$item['name'].'"');
				}

			}
			$this->sequence = $sequence;
		}


		/**
		 * @param array $config
		 * @return $this
		 */
		public function setConfig(array $config){
			$this->config = $config;
			return $this;
		}

		/**
		 * @return array
		 */
		public function getConfig(){
			return $this->config;
		}

		/**
		 * @param SpecificationInterface $specification
		 * @return $this
		 */
		public function setSpecification(SpecificationInterface $specification){
			$this->specification = $specification;
			$this->connection = $specification->createConnection();
			return $this;
		}

		/**
		 * @return SpecificationInterface
		 */
		public function getSpecification(){
			return $this->specification;
		}


		/**
		 * @return ProcessSequenceInterface
		 */
		public function run(){
			$this->_reset();
			$processSequence = new ProcessSequence($this);
			$this->specification->beforeSequence($processSequence);
			try{
				foreach($this->sequence as $item){
					try{
						/** @var CommandInterface $command */
						$command = $item['command'];
						if(isset($item['aggregation'])){
							foreach($item['aggregation'] as $params){
								$command->run($processSequence, $this->prepareParams($params) );
							}
						}else{
							$command->run($processSequence, $this->prepareParams($item['params']) );
						}
					}catch(Exception\CanceledException $canceled){

					}

				}
				$this->specification->afterSequence($processSequence);
			}catch(Exception $e){
				return $this->_handleException($e, $processSequence->getLastProcess(), $processSequence);
			}finally{
				$this->specification->continueSequence($processSequence);
				$this->connection->close();
			}
			return $processSequence;
		}

		/**
		 * @param array $params
		 * @return array
		 */
		protected function prepareParams(array $params){
			if(isset($this->config['params_merge'])){
				$toAdd = $this->config;
				unset($toAdd['params_merge']);
				return array_replace($toAdd,$params);
			}
			return $params;
		}

		/**
		 * @param Exception $e
		 * @param ProcessInterface $process
		 * @param ProcessSequenceInterface $sequence
		 * @return mixed
		 * @throws Exception
		 */
		protected function _handleException(Exception $e, ProcessInterface $process, ProcessSequenceInterface $sequence){

			if($e instanceof Sequence\Exception\ParamRequired){
				$process->setTask('required', $e);
				return $sequence;
			}

			if($e instanceof FatalException){
				$process->setTask('error', $e);
				throw $e;
			}

			if($e instanceof RuleMessage){
				$process->setTask('rule', $e);
				return $sequence;
			}



			throw $e;
		}


		/**
		 * @param $data
		 * @return int
		 */
		public function send($data){
			return $this->connection->send($data);
		}

		/**
		 * @param $length
		 * @return string
		 */
		public function read($length){
			return $this->connection->read($length);
		}


		/**
		 *
		 */
		protected function _reset(){
			$this->connection->close();
			$this->connection->setConfig($this->config);
		}

	}
}

