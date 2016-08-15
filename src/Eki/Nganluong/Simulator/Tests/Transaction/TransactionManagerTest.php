<?php
namespace Eki\Nganluong\Simulator\Tests\Transaction;

use Eki\Nganluong\Simulator\Transaction\TransactionManager;
use Eki\Nganluong\Simulator\Persistent\CachePersistent;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TransactionManagerTest extends WebTestCase
{
	private $transactionManager;
	private $transaction;
	private $client;
	
	protected function setUp()
	{
		$this->client = $client = static::createClient();
		$container = $client->getContainer();
		
		$persist = $container->get('doctrine_cache.providers.nganluong_simulator_transaction');
		echo 'Persistent class is '.get_class($persist);
		$transactionManager = new TransactionManager();
		//$transactionManager->setPersistent($persist);
		//$this->transactionManager = $transactionManager;
	}
	
	private function prepareTransactionData()
	{
		return array(
			'merchant_id' => '78979789as7dsad',
			'merchant_password' => 'Alkasjdkjsakjdksajkdjsa1kashd3',
			'receiver_email' => 'account@example.com',
			'return_url' => 'http://localhost',
			'cancel_url' => 'http://localhost',
		);		
	}
	
	private function generateTransaction()
	{
		return ( $this->transaction = $this->transactionManager->createTransaction() );
	}
	
	/**
	* @__test
	*/
	public function generateTransactionTest()
	{
		$transaction = $this->generateTransaction();
		$token = $transaction->getToken();
		
		assertNotNull($token);
		
		$fields = $this->prepareTransactionData();
		$this->transactionManager->updateTransaction($transaction, $fields);
		
		$oTransaction = $this->transactionManager->getTransaction($token);
		
		$controls = $oTransaction->getControls();

		assertTrue(isset($controls['return_url']));
		assertTrue(isset($controls['cancel_url']));
	}
}