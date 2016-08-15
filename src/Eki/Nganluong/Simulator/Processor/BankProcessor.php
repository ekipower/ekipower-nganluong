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
use Eki\Nganluong\Simulator\Process\Process;
use Eki\Nganluong\Simulator\Processor\BaseProcessor;

use Eki\Payum\Nganluong\Api\Errors;

class BankProcessor extends BaseProcessor
{
	/**
	* @inheritdoc
	* 
	*/
	protected function continueProcess($input)
	{
		$process = new Process();
		$process->setState(ProcessInterface::STATE_PAID);
		$process->setProcessedCode(Errors::ERRCODE_NO_ERROR);
		
		return $process;
	}
}
