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

use Eki\Nganluong\Simulator\Api\Api;
use Eki\Payum\Nganluong\Api\PaymentMethods;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

abstract class ApiController extends Controller
{
	const DEFAULT_VERSION = 'default';
	
	/**
	* 
	* @var Eki\Nganluong\Simulator\Api\Api
	* 
	*/
	private $api;
	
	protected function getApi($version = self::DEFAULT_VERSION)
	{
		return $this->api;
	}

	public function setApi(Api $api)
	{
		$router = $this->get('router');
		$api->setCheckoutUrl(PaymentMethods::METHOD_VISA, $router->generate('nl_credit_card_obtain',array('token'=>'token_key')));
		$api->setCheckoutUrl(PaymentMethods::METHOD_ATM_ONLINE, $router->generate('nl_atm_card_obtain',array('token'=>'token_key')));
		$api->setCheckoutUrl(PaymentMethods::METHOD_NL_ONLINE, $router->generate('nl_nl_account_obtain',array('token'=>'token_key')));
		
		$this->api = $api;
	}

	protected function getRedirectUrl($token, $valid)
	{
		$transaction = $this->getApi()->getTransaction($token);
		$controls = $transaction->getControls();
		return $valid ? $controls['return_url'] : $controls['cancel_url'];
	}
}
