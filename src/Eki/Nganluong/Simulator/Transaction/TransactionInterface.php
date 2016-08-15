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

interface TransactionInterface
{
	/**
	* Export to array
	*
	* @return array 
	*/
	public function toArray();
	
	public function getVersion();
	public function setVersion($version);
	
	public function getMerchant();
	public function setMerchant($merchant);
	public function updateMerchant(array $fields);
	
	public function getOrder();
	public function setOrder($order);
	public function updateOrder(array $fields);
	
	public function getBuyer();
	public function setBuyer($buyer);
	public function updateBuyer(array $fields);
	
	public function getPayer();
	public function setPayer($payer);
	public function updatePayer(array $fields);
	
	public function getControls();
	public function setControls($controls);
	public function addControls($controls);
	public function updateControls(array $fields);
	
	public function getMisc();
	public function setMisc($misc);
	public function addMisc($misc);
	public function updateMisc(array $fields);
}
