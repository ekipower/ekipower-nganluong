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
use Eki\Nganluong\Simulator\Persistent\TokenInterface;

class Transaction implements TransactionInterface, TokenInterface
{
	/**
	* 
	* @var mixed
	* 
	*/
	private $token;
	
	/**
	* 
	* @var string
	* 
	*/
	private $version;

	/**
	* 
	* @var mixed
	* 
	*/
	private $id;
	
	/**
	* 
	* @var array
	* 
	*/
	private $merchant = array();
	
	/**
	* 
	* @var array
	* 
	*/
	private $order = array();
	
	/**
	* 
	* @var array
	* 
	*/
	private $buyer = array();
	
	/**
	* 
	* @var 
	* 
	*/
	private $payer = array();
	
	/**
	* 
	* @var array
	* 
	*/
	private $controls = array();
	
	/**
	* 
	* @var array
	* 
	*/
	private $misc = array();

	/**
	* @inheritdoc
	* 
	*/	
	public function toArray()
	{
		$ret = array();
		
		$ret['token'] = $this->getToken();
		$this->importArray($ret, $this->getMerchant());
		$this->importArray($ret, $this->getOrder());
		$this->importArray($ret, $this->getBuyer());
		$this->importArray($ret, $this->getPayer());
		$this->importArray($ret, $this->getControls());
		$this->importArray($ret, $this->getMisc());
		
		return $ret;
	}
	
	private function importArray(array &$arr, array $imp)
	{
		foreach($imp as $key => $value)
		{
			$arr[$key] = $value;
		}		
	}
	
	/**
	* @inheritdoc
	* 
	*/
	public function getToken()
	{
		return $this->token;
	}
	
	/**
	* @inheritdoc
	* 
	*/
	public function setToken($token)
	{
		$this->token = $token;
		return $this;
	}
	
	/**
	* @inheritdoc
	* 
	*/
	public function getVersion()
	{
		return $this->version;
	}

	/**
	* @inheritdoc
	* 
	*/
	public function setVersion($version)
	{
		$this->version = $version;
		return $this;
	}

	/**
	* Gets id
	* 
	* $return mixed
	*/
	public function getId()
	{
		return $this->id;
	}

	/**
	* Sets id
	* 
	* @params mixed $id
	*/
	public function setId($id)
	{
		$this->id = $id;
		$this->addMisc('transaction_id', array('id'=> $id));
		return $this;
	}
	
	/**
	* @inheritdoc
	* 
	*/
	public function getMerchant()
	{
		return $this->merchant;
	}

	/**
	* @inheritdoc
	* 
	*/
	public function setMerchant($merchant)
	{
		$this->merchant = $merchant;
		return $this;
	}

	/**
	* @inheritdoc
	* 
	*/
	public function updateMerchant(array $fields)
	{
		$this->updateComponent($fields, 'merchant');
	}

	/**
	* @inheritdoc
	* 
	*/
	public function getOrder()
	{
		return $this->order;
	}

	/**
	* @inheritdoc
	* 
	*/
	public function setOrder($order)
	{
		$this->order = $order;
		return $this;
	}

	/**
	* @inheritdoc
	* 
	*/
	public function updateOrder(array $fields)
	{
		$this->updateComponent($fields, 'order');
	}
	
	/**
	* @inheritdoc
	* 
	*/
	public function getBuyer()
	{
		return $this->buyer;
	}

	/**
	* @inheritdoc
	* 
	*/
	public function setBuyer($buyer)
	{
		$this->buyer = $buyer;
		return $this;
	}

	/**
	* @inheritdoc
	* 
	*/
	public function updateBuyer(array $fields)
	{
		$this->updateComponent($fields, 'buyer');
	}
	
	/**
	* @inheritdoc
	* 
	*/
	public function getPayer()
	{
		return $this->payer;
	}

	/**
	* @inheritdoc
	* 
	*/
	public function setPayer($payer)
	{
		$this->payer = $payer;
		return $this;
	}

	/**
	* @inheritdoc
	* 
	*/
	public function updatePayer(array $fields)
	{
		$this->updateComponent($fields, 'payer');
	}
	
	/**
	* @inheritdoc
	* 
	*/
	public function getControls()
	{
		return $this->controls;
	}

	/**
	* @inheritdoc
	* 
	*/
	public function setControls($controls)
	{
		$this->controls = $controls;
		return $this;
	}

	/**
	* @inheritdoc
	* 
	*/
	public function addControls($controls)
	{
		array_replace($this->controls, $controls);
		return $this;
	}
	
	/**
	* @inheritdoc
	* 
	*/
	public function updateControls(array $fields)
	{
		$this->updateComponent($fields, 'controls');
	}

	/**
	* @inheritdoc
	* 
	*/
	public function getMisc()
	{
		return $this->misc;
	}

	/**
	* @inheritdoc
	* 
	*/
	public function setMisc($misc)
	{
		$this->misc = $misc;
		return $this;
	}

	/**
	* @inheritdoc
	* 
	*/
	public function addMisc($misc)
	{
		array_replace($this->misc, $misc);
		return $this;
	}

	/**
	* @inheritdoc
	* 
	*/
	public function updateMisc(array $fields)
	{
		$this->updateComponent($fields, 'misc');
	}

	private function updateComponent(array $fields, $compName)
	{
		$get = 'get'.ucfirst($compName);
		$compData = $this->$get();
		
		foreach($this->getComponentIndices($compName) as $index)
		{
			if ( isset($fields[$index]) )
			{
				$compData[$index] = $fields[$index];
			}		
		}
		
		$set = 'set'.ucfirst($compName);
		$this->$set($compData);
	}

	private function getComponentIndices($compName)
	{
		static $indices = array(
			'merchant' => array(
				'merchant_id', 'merchant_password', 'receiver_email',
			),
			'order' => array(
				'order_code', 'order_description',
				'cur_code',
				'total_amount', 'tax_amount', 'discount_amount', 'fee_shipping',
			),
			'buyer' => array(
				'buyer_fullname', 'buyer_email', 'buyer_mobile', 'buyer_address',
			),
			'payer' => array(
			),
			'controls' => array(
				'error_code',
				'payment_method', 'payment_type',
				'return_url', 'cancel_url',
				'time_limit',
			),
			'misc' => array(
				'transaction_id', 'transaction_status',
				'bank_code',
				'affiliate_code',
				'description'
			),
		);

		return $indices[$compName];
	}
}
