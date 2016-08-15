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

use Eki\Nganluong\Simulator\Process\ProcessInterface;

interface ProcessorInterface
{
	const RETURN_SUCCESSFUL = 'success';
	const RETURN_WAITING = 'waiting';
	const RETURN_ERROR = 'error';
	
	/**
	* Process a process
	* 
	* @param mixed $input
	*
	* @return ProcessInterface
	*/
	public function process($input);
}
