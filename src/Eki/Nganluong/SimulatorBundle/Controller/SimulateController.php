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

use Eki\Nganluong\SimulatorBundle\Controller\ApiControler;
use Eki\Nganluong\SimulatorBundle\Helper\XmlHelper;

use Eki\Payum\Nganluong\Api\Errors;
use Eki\Payum\Nganluong\Api\ApiException;
use Eki\Payum\Nganluong\Api\PaymentMethods;

use Eki\Nganluong\Simulator\Api\Api;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class SimulateController extends ApiController
{
    /**
     * Sandbox action.
     *
     * @return Response
     */
    public function simulateAction( Request $request )
    {
		$logger = $this->get('logger');

		if ( !$request->isMethod('POST') )
		{
			throw new \LogicException('It is only POST method supported.');
		}

		$fields = $this->getFields($request);
		
		foreach($fields as $fieldName => $fieldValue)
		{
			$logger->info($fieldName.'='.$fieldValue);
		}
		
		try
		{
			$this->getApi()->checkFields($fields);
		}
		catch(ApiException $e)
		{
			$result = $this->getApi()->getErrorResult($e->getCode());
		}
		catch(\InvalidArgumentException $e)
		{
			$result = $this->getApi()->getErrorResult(Errors::ERRCODE_WRONG_FIELDS);
		}
		catch(\Exception $e)
		{
			$result = $this->getApi()->getErrorResult(Errors::ERRCODE_UNKNOWN);
		}

		$result = $this->getApi()->doFunction($fields);
		if ( !isset($result['error_code']) )
		{
			throw new \LogicException('"error_code" field must be set after running doFunction.');
		}
		
		if ( $result['error_code'] === Errors::ERRCODE_NO_ERROR )
		{
		}
		else
		{
			$result['description'] = Errors::ErrorMessages()[$result['error_code']];
		}
		
		$xml = XmlHelper::array2xml($result, 'result');
		$response = new Response($xml, '200');
		$response->headers->set('Content-Type', 'text/xml');
		
		return $response;		
    }
	
	private function getCheckoutUrl($method, $token)
	{
		$routes = array(
			PaymentMethods::METHOD_VISA => 'nl_credit_card_obtain',
			PaymentMethods::METHOD_ATM_ONLINE => 'nl_atm_card_obtain',
			PaymentMethods::METHOD_NL_ONLINE => 'nl_nl_account_obtain',
		);
		return $this->get('router')->generate($routes[$method], array( 'token' => $result['token']));
	}
	
	private function getFields(Request $request)
	{
		return $request->request->all();
	}
	
    /**
     * Error checkout action.
     *
	 * @param string $code
	 * 
     * @return Response
     */
    public function errorAction( $code )
	{
        return $this->render(
            'EkinganluongSimulatorBundle:Error:error_checkout.html.twig',
			array(
				'code' => $code,
				$messages => array( $this->getApi()->getErrorMessage($code) )
			)
        );
	}
}
