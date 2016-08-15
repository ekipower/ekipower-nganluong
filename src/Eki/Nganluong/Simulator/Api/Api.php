<?php
/**
 * This file is part of the EkiNganluongSimulator package.
 *
 * (c) EkiPower <http://ekipower.github.com/>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */ 

namespace Eki\Nganluong\Simulator\Api;

use Eki\Nganluong\Simulator\Transaction\TransactionInterface;
use Eki\Nganluong\Simulator\Transaction\TransactionManagerInterface;

use Eki\Payum\Nganluong\Api\AbstractApi;
use Eki\Payum\Nganluong\Api\Errors;
use Eki\Payum\Nganluong\Api\PaymentMethods;
use Eki\Payum\Nganluong\Api\ApiException;

use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;

class Api extends AbstractApi
{
	const VERSION = '3.1';
	const DEFAULT_TIME_LIMIT = 1440;

	/**
	* 
	* @var Psr\Log\LoggerInterface
	* 
	*/
	private $logger;
	
	/**
	* 
	* @var Eki\Nganluong\Simulator\Transaction\TransactionManagerInterface
	* 
	*/
	private $transactionManager;

	/**
	* 
	* @var string[]
	* 
	*/
	private $checkoutUrls;

	/**
	* 
	* @param string $index
	* @param string $url
	* 
	*/
	public function setCheckoutUrl($index, $url)
	{
		if ( $this->checkoutUrls === null )
		{
			$this->checkoutUrls = array();
		}
		
		$this->checkoutUrls[$index] = $url;
	}

	protected function getCheckoutUrl($index, $token)
	{
		if ( isset($this->checkoutUrls[$index]) )
		{
			$urlTemplate = $this->checkoutUrls[$index];
			$url = str_replace('token_key', $token, $urlTemplate);
			return $url;
		}
	}	
	
	public function setLogger(LoggerInterface $logger)
	{
		$this->logger = $logger;
	}

	/**
	* Sets transaction manager 
	* 
	* @param TransactionManagerInterface $manager
	* 
	*/
	public function setTransactionManager(TransactionManagerInterface $manager)
	{
		$this->transactionManager = $manager;
	}

	/**
	* @inheritdoc
	* 
	*/
	public function getVersion()
	{
		return self::VERSION;
	}

	/**
	* @inheritdoc
	*/
	public function checkFields(array $fields)
	{
		$this->checkVersion($fields);
		$this->checkAuthorize($fields);
	}
	
	private function checkVersion(array $fields)
	{
		if ( !isset($fields['version']) || $fields['version'] != self::VERSION )
		{
			throw new ApiException(Errors::ERRCODE_VERSION_WRONG);
		}
	}
	
	private function checkAuthorize(array $fields)
	{
		if ( !isset($fields['merchant_id']) )
		{
			throw new ApiException(Errors::ERRCODE_MERCHANT_ID_INVALID);
		}

		if ( !isset($fields['merchant_password']) )
		{
			throw new ApiException(Errors::ERRCODE_MERCHANT_PASSWORD_INVALID);
		}

		if ( !isset($fields['receiver_email']))
		{
			throw new ApiException(Errors::ERRCODE_MERCHANT_EMAIL_INVALID);
		}
	}

	private function checkOrder(array $fields)
	{
		
	}
	
	private function checkBuyer(array $fields)
	{
		
	}

	/**
	* @inheritdoc
	* 
	*/
	protected function getSupportedFunctions()
	{
		return array(
			'SetExpressCheckout' => 'setExpressCheckout',
			'GetTransactionDetail' => 'getTransactionDetails',
		);
	}
	
	protected function doFunction_setExpressCheckout(array $fields)
	{
		$this->checkOrder($fields);
		$this->checkBuyer($fields);

		if ( null === ( $token = $this->createTransaction() ) )
		{
			throw new ApiException(Errors::ERRCODE_UNKNOWN);
		} 

		$this->updateTransaction($token, $fields);
		
		if ( isset($fields['payment_method']) && 
			 in_array( $fields['payment_method'], array_keys( $suppotedFunctions = $this->supportedPaymentMethods() ) ) 
		)
		{
			$fields['token'] = $token;
			$method = $suppotedFunctions[$fields['payment_method']];
			return $this->$method($fields);
		}
		else
		{
			throw new ApiException(Errors::ERRCODE_PAYMENT_METHOD_WRONG);
		}
	}
	
	/**
	 * Get supported payment methods 
	 * 
	 * @return 
	*/
	protected function supportedPaymentMethods()
	{
		return array(
			PaymentMethods::METHOD_VISA => 'VISACheckOut',
			PaymentMethods::METHOD_ATM_ONLINE => 'BankCheckout',
			PaymentMethods::METHOD_NL_ONLINE => 'NLCheckout',
		);
	}

	private function VISACheckout(array $fields)
	{
		return $this->Checkout($fields);	
	}

	private function BankCheckout(array $fields)
	{
		return $this->Checkout($fields);	
		
	}

	private function TTVPCheckout(array $fields)
	{
		return $this->Checkout($fields);	
		
	}

	private function NLCheckout(array $fields)
	{
		return $this->Checkout($fields);	
		
	}
	
	private function Checkout(array $fields)
	{
		$result = array(
			'error_code' => Errors::ERRCODE_NO_ERROR,
			'token' => $fields['token'],
			'checkout_url' => $this->getCheckoutUrl($fields['payment_method'], $fields['token']),
			'time_limit' => self::DEFAULT_TIME_LIMIT,
		);
		
		return $result;	
	}
	
	protected function doFunction_getTransactionDetails(array $fields)
	{
		if ( !isset($fields['token']) || null === ( $transaction = $this->getTransaction($fields['token']) ))
		{
			throw new ApiException(Errors::ERRCODE_TOKEN_NOT_EXIST);
		}
		
		// Check version
		$this->checkVersion($fields);

		// Check authozize
		$this->checkAuthorize($fields);

		$result = $transaction->toArray();
		
		return $result;
	}
	
	private function createTransaction()
	{
		if ( null === ( $transaction = $this->transactionManager->createTransaction() ) )
		{
			throw new ApiException(Errors::ERRCODE_UNKNOWN);
		}
		
		return $transaction->getToken();
	}
	
	public function updateTransaction($token, array $fields)
	{
		if ( null === ( $transaction = $this->transactionManager->getTransaction($token) ) )
		{
			throw new ApiException(Errors::ERRCODE_TRANSACTION_NOT_EXIST);
		}
		
		$this->transactionManager->updateTransaction($transaction, $fields);
	}

	public function getTransaction($token)
	{
		return $this->transactionManager->getTransaction($token);
	}
}
