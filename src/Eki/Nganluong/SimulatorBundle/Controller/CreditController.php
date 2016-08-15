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

use Eki\Nganluong\SimulatorBundle\Controller\ProcessorController;
use Eki\Nganluong\SimulatorBundle\Helper\XmlHelper;

use Eki\Payum\Nganluong\Api\Errors;
use Eki\Payum\Nganluong\Api\Api;

use Symfony\Component\HttpFoundation\Request;

class CreditController extends ProcessorController
{
    /**
     * Obtain credit card action.
     *
     * @return Response
     */
    public function obtainCreditCardAction( Request $request, $token )
    {
		return $this->obtainCard(
			$request, $token, 
			$this->container->getParameter('nganluong.simulator.processor.controller.credit_card.form.type'),
			'EkiNganluongSimulatorBundle:Checkout:obtainCreditCard.html.twig'
		);
    }
}
