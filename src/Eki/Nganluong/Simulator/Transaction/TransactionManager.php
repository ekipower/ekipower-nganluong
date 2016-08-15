<?php
/**
 * This file is part of the EkiNganluongSimulator package.
 *
 * (c) EkiPower <http://ekipower.github.com/>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */ 

namespace Eki\Nganluong\Simulator\Transaction;

use Eki\Nganluong\Simulator\Transaction\TransactionManagerInterface;
use Eki\Nganluong\Simulator\Transaction\TransactionInterface;

use Eki\Nganluong\Simulator\Persistent\PersistentInterface;

use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;

class TransactionManager implements TransactionManagerInterface
{
	/**
	* 
	* @var Psr\Log\LoggerInterface
	* 
	*/
	private $logger;

	public function setLogger(LoggerInterface $logger)
	{
		$this->logger = $logger;
	}

	/**
	* 
	* @var Eki\Nganluong\Simulator\Persistent\PersistentInterface
	* 
	*/
	private $persist;
	
	public function setPersistent(PersistentInterface $persist)
	{
		$this->persist = $persist;
	}

	/**
	* Create a transaction
	*
	* @return Eki\Nganluong\SimulatorNganluong\Transaction\TransactionInterface 
	*/
	public function createTransaction()
	{
		$transaction = new Transaction();
		$token = $this->persist->createToken($transaction);
		$transaction->setToken($token);
		if ( $this->persist->save($transaction) === true )
		{
			return $transaction;
		}
	}
	
	/**
	* Remove an existing transaction
	* 
	* @param Eki\Nganluong\SimulatorNganluong\Transaction\TransactionInterface $transaction
	* 
	*/
	public function removeTransaction(TransactionInterface $transaction)
	{
		$this->persist->delete($obj);
	}
	
	/**
	* Update an existing transaction
	* 
	* @param Eki\Nganluong\SimulatorNganluong\Transaction\TransactionInterface $transaction
	* @param array $fields
	* 
	*/
	public function updateTransaction(TransactionInterface $transaction, array $fields)
	{
$this->logger->info(__CLASS__.'::'.__FUNCTION__.'===============================');		
foreach($fields as $key => $value)
{
	$this->logger->info('fields: '.$key.'='.$value);		
}
$this->logger->info(__CLASS__.'::'.__FUNCTION__.' before');		
$this->xxx($this->logger, $transaction);

		$transaction->updateMerchant($fields);
		$transaction->updateOrder($fields);
		$transaction->updateBuyer($fields);
		$transaction->updatePayer($fields);
		$transaction->updateControls($fields);
		$transaction->updateMisc($fields);
		
$this->logger->info(__CLASS__.'::'.__FUNCTION__.' after');
$this->xxx($this->logger, $transaction);

		$this->persist->save($transaction);
	}
	
	private function xxx($logger, $transaction)
	{
		$logger->info(__CLASS__.'::'.__FUNCTION__.'------------ merchant');		
		foreach($transaction->getMerchant() as $key => $value)
		{
			$logger->info(__CLASS__.'::'.__FUNCTION__.' '.$key.'='.$value);		
		}		
		$logger->info(__CLASS__.'::'.__FUNCTION__.'------------ order');		
		foreach($transaction->getOrder() as $key => $value)
		{
			$logger->info(__CLASS__.'::'.__FUNCTION__.' '.$key.'='.$value);		
		}		
		$logger->info(__CLASS__.'::'.__FUNCTION__.'------------ buyer');		
		foreach($transaction->getBuyer() as $key => $value)
		{
			$logger->info(__CLASS__.'::'.__FUNCTION__.' '.$key.'='.$value);		
		}		
		$logger->info(__CLASS__.'::'.__FUNCTION__.'------------ payer');		
		foreach($transaction->getPayer() as $key => $value)
		{
			$logger->info(__CLASS__.'::'.__FUNCTION__.' '.$key.'='.$value);		
		}		
		$logger->info(__CLASS__.'::'.__FUNCTION__.'------------ controls');		
		foreach($transaction->getControls() as $key => $value)
		{
			$logger->info(__CLASS__.'::'.__FUNCTION__.' '.$key.'='.$value);		
		}		
		$logger->info(__CLASS__.'::'.__FUNCTION__.'------------ misc');		
		foreach($transaction->getMisc() as $key => $value)
		{
			$logger->info(__CLASS__.'::'.__FUNCTION__.' '.$key.'='.$value);		
		}		
	}
	
	/**
	* Get transaction by 
	* 
	* @param array $criteria
	*
	* @return Eki\Nganluong\SimulatorNganluong\Transaction\TransactionInterface 
	*/
	public function findTransactionBy(array $criteria)
	{
		throw new \Exception('Not support.');
	}
	
	/**
	* Gets transaction by main key 
	* 
	* @param mixed $key
	*
	* @return Eki\Nganluong\SimulatorNganluong\Transaction\TransactionInterface 
	*/
	public function getTransaction($key)
	{
		return $this->persist->get($key);
	}
}
