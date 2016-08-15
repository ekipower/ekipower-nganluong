<?php
/**
 * This file is part of the EkiPayumBundle package.
 *
 * (c) EkiPower <http://ekipower.github.com/>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */ 

namespace Eki\Payum\Nganluong\Action\Api;

use Eki\Payum\Nganluong\Action\Api\BaseApiAwareAction;
use Eki\Payum\Nganluong\Request\Api\SetExpressCheckout;
use Eki\Payum\Nganluong\Request\Api\GetPaymentMethod;
use Eki\Payum\Nganluong\Request\Log;

use Payum\Core\Bridge\Spl\ArrayObject;
use Payum\Core\Exception\RequestNotSupportedException;
use Payum\Core\Exception\LogicException;

use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;

class SetExpressCheckoutAction extends BaseApiAwareAction
{
	/**
	* 
	* @var Psr\Log\LoggerInterface
	* 
	*/
	private $logger;
	
	public function setLogger(LoggerInterface $logger)
	{
		$this->logger = $logger;
		
		return $this;
	}
	
    /**
     * {@inheritDoc}
     */
    public function execute($request)
    {
        /** @var $request SetExpressCheckout */
        RequestNotSupportedException::assertSupports($this, $request);

        $model = ArrayObject::ensureArrayObject($request->getModel());

		$model->validateNotEmpty(array('total_amount', 'cur_code', 'order_code'));

        $model->replace(
            $this->api->setExpressCheckout((array) $model)
        );
    }

    /**
     * {@inheritDoc}
     */
    public function supports($request)
    {
        return
            $request instanceof SetExpressCheckout &&
            $request->getModel() instanceof \ArrayAccess
        ;
    }
}
