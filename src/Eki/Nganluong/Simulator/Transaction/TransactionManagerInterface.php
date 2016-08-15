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

use Eki\Nganluong\Simulator\Transaction\TransactionInterface;

interface TransactionManagerInterface
{
	/**
	* Create a transaction
	*
	* @return Eki\Nganluong\Simulator\Transaction\TransactionInterface 
	*/
	public function createTransaction();
	
	/**
	* Remove an existing transaction
	* 
	* @param Eki\Nganluong\Simulator\Transaction\TransactionInterface $transaction
	* 
	*/
	public function removeTransaction(TransactionInterface $transaction);
	
	/**
	* Update an existing transaction
	* 
	* @param Eki\Nganluong\Simulator\Transaction\TransactionInterface $transaction
	* @param array $fields
	* 
	*/
	public function updateTransaction(TransactionInterface $transaction, array $fields);
	
	/**
	* Find transaction by 
	* 
	* @param array $criteria
	*
	* @return Eki\Nganluong\Simulator\Transaction\TransactionInterface 
	*/
	public function findTransactionBy(array $criteria);
	
	/**
	* Gets transaction by main key 
	* 
	* @param mixed $key
	*
	* @return Eki\Nganluong\Simulator\Transaction\TransactionInterface 
	*/
	public function getTransaction($key);
}
