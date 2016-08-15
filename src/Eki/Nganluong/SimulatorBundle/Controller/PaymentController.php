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

use Eki\Payum\Nganluong\Api\Errors;
use Eki\Nganluong\Simulator\Api\Api;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class PaymentController extends Controller
{
	/**
	* 
	* @var Eki\Nganluong\Simulator\Api\Api
	* 
	*/
	private $api;
	
    /**
     * Sandbox action.
     *
     * @return Response
     */
    public function getPaymentInfoAction( $paymentType )
    {
    }
}
