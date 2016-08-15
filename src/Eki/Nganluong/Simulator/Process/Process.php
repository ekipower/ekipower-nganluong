<?php
/**
 * This file is part of the EkiNganluongSimulator package.
 *
 * (c) EkiPower <http://ekipower.github.com/>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */ 

namespace Eki\Nganluong\Simulator\Process;

use Eki\Nganluong\Simulator\Process\ProcessInterface;

class Process implements ProcessInterface
{
	protected $processed = false;
	protected $state = ProcessInterface::STATE_UNKNOWN;
	protected $processedCode;
	
	/**
	* @inheritdoc
	*
	*/
	public function isProcessed()
	{
		return $this->processed;
	}
	
	protected function setProcessed($processed)
	{
		$this->processed = $processed;
	}
	
	/**
	* @inheritdoc
	* 
	*/	
	public function isPaid()
	{
		return $this->state === ProcessInterface::STATE_PAID;	
	}
	
	/**
	* @inheritdoc
	* 
	*/	
	public function isNotPaid()
	{
		return $this->state === ProcessInterface::STATE_NOT_PAID;	
	}
	
	/**
	* @inheritdoc
	* 
	*/	
	public function isWaitingForPaying()
	{
		return $this->state === ProcessInterface::STATE_WAITING;	
	}
	
	public function setState($state)
	{
		if ( $state != ProcessInterface::STATE_PAID && 
		     $state != ProcessInterface::STATE_NOT_PAID && 
			 $state != ProcessInterface::STATE_WAITING     )
		{
			throw new \LogicException('State must be one of ProcessInterface::STATE_PAID, ProcessInterface::STATE_NOT_PAID, ProcessInterface::STATE_WAITING');
		}
		
		$this->setProcessed(true);
		$this->state = $state;
	}

	/**
	* @inheritdoc
	* 
	*/	
	public function getProcessedCode()
	{
		return $this->processedCode;		
	}
	
	public function setProcessedCode($code)
	{
		$this->processedCode = $code;
	}

}
