<?php
/**
 * This file is part of the EkiNganluongSimulatorBundle package.
 *
 * (c) EkiPower <http://ekipower.github.com/>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */ 

namespace Eki\Nganluong\SimulatorBundle\Controller;

use Eki\Nganluong\SimulatorBundle\Controller\ApiController;
use Eki\Nganluong\Simulator\Processor\ProcessorInterface;
use Eki\Nganluong\Simulator\Process\ProcessInterface;

use Eki\Payum\Nganluong\Api\TransactionStatus;

use Symfony\Component\HttpFoundation\Request;

abstract class ProcessorController extends ApiController
{
	/**
	* 
	* @var Eki\Nganluong\Simulator\Processor\ProcessorInterface
	* 
	*/
	private $processor;
	
	/**
	* Gets processor 
	* 
	* @return ProcessorInterface
	*/
	protected function getProcessor()
	{
		return $this->processor;
	}
	
	public function setProcessor(ProcessorInterface $processor)
	{
		$this->processor = $processor;
	}

    protected function obtainCard( Request $request, $token, $formType, $template )
    {
		$form = $this->createForm($formType);
		
	 	$form->handleRequest($request);

		if ($form->isValid())
		{
			$process = $this->getProcessor()->process($form->getData());

			$transactionStatus = $this->convertTransactionStatusFromProcessReturn($process);
			$this->getApi()->updateTransaction(
				$token, 
				array(
					'error_code' => $process->getProcessedCode(),
					'transaction_status' => $transactionStatus
				)
			);

        	return $this->redirect($this->getRedirectUrl(
				$token, $transactionStatus != TransactionStatus::NOT_PAID
			));
		}
			
        return $this->render( $template, array( 'form' => $form->createView() ) );
    }
	
	private function convertTransactionStatusFromProcessReturn(ProcessInterface $process)
	{
		if ($process->isPaid())
		{
			$status = TransactionStatus::PAID;
		}
		else if ($process->isNotPaid())
		{
			$status = TransactionStatus::NOT_PAID;
		}
		else if ($process->isWaitingForPaying())
		{
			$status = TransactionStatus::PAID_WAITING_FOR_PROCESS;
		}
		
		return $status;
	}
}
