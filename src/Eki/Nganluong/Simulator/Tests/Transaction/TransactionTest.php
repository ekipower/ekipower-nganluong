<?php
namespace Eki\Nganluong\Simulator\Tests\Transaction;

use Eki\Nganluong\Simulator\Transaction\Transaction;

use Eki\Payum\Nganluong\Api\PaymentMethods;
use Eki\Payum\Nganluong\Api\PaymentTypes;

class TransactionTest extends \PHPUnit_Framework_TestCase
{
	private function prepareTransactionControlsInput($compName)
	{
		$input =  array(
			'controls' => array(
				'payment_method' => PaymentMethods::METHOD_VISA, 
				'payment_type' => PaymentTypes::TYPE_IMMEDIATE,
				'return_url' => 'http://localhost',			
				'cancel_url' => 'http://localhost',			
				'time_limit' => 1440,
			),
		);
		
		return $input[$compName];
	}
	
	/**
	* 
	*/
	private function transactionUpdateComponent($compName)
	{
		$fields = $this->prepareTransactionControlsInput($compName);
		
		$tr = new Transaction();
		$get = 'get'.ucfirst($compName);
		$compData = $tr->$get();

		$this->assertEmpty($compData, 'Component data must be empty after constructing of transaction.');

		$update = 'update'.ucfirst($compName);
		$tr->$update($fields);
		
		$compData = $tr->$get();
		
		$this->assertNotEmpty($compData, 'Component data must be not empty after updating.');
		
		foreach($fields as $index => $value)
		{
			$this->assertTrue(isset($compData[$index]));
			$this->assertEquals($compData[$index], $fields[$index]);
		}
	}
	
	/**
	* @test
	* 
	*/
	public function transactionUpdateControlsTest()
	{
		$this->transactionUpdateComponent('controls');
	}
}