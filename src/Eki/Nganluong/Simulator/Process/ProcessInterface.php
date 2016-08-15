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

interface ProcessInterface
{
	const STATE_PAID = 'paid';
	const STATE_NOT_PAID = 'not_paid';
	const STATE_WAITING = 'waiting';
	const STATE_UNKNOWN = 'unknown';
	
	public function isProcessed();
	public function isPaid();
	public function isNotPaid();
	public function isWaitingForPaying();
	
	public function getProcessedCode();
}
