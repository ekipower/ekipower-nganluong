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

class NLController extends ProcessorController
{
    /**
     * Obtain Nganluong account action.
     *
     * @return Response
     */
    public function obtainNLAccountAction( Request $request, $token )
    {
		return $this->obtainCard(
			$request, $token, 
			$this->container->getParameter('nganluong.simulator.processor.controller.nl_account.form.type'),
			'EkiNganluongSimulatorBundle:Checkout:obtainNLAccount.html.twig'
		);
    }
}
