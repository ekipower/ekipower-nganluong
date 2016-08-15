<?php
/**
 * This file is part of the EkiNganluongSimulator package.
 *
 * (c) EkiPower <http://ekipower.github.com/>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */ 

namespace Eki\Nganluong\Simulator\Processor;

use Eki\Nganluong\Simulator\Processor\ProcessorInterface;
use Eki\Nganluong\Simulator\Process\ProcessInterface;

abstract class BaseProcessor implements ProcessorInterface
{
	protected $dataClass;

	/**
	* @inheritdoc
	*/	
	public function process($input)
	{
		if ( $this->dataClass === null )
		{
			throw new \LogicException('Processor has not data class');
		}
		
		if ( !$input instanceof $this->dataClass )
		{
			throw new \LogicException('input object must be instance of class '.$this->dataClass.'. But object of class '.get_class($input).' given.');
		}
		
		return $this->continueProcess($input);
	}
	
	public function setDataClass($class)
	{
		if ( !class_exists($class) )
		{
			throw new \LogicException('Data class is not defined.');
		}
		
		$this->dataClass = $class;
	}
	
	/**
	* Continue process in child ...
	* 
	* @param mixed $input
	* 
	* @return ProcessInterface
	*/
	abstract protected function continueProcess($input);
}
