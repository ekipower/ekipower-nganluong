<?php
/**
 * This file is part of the EkiSyliusPayumBundle package.
 *
 * (c) EkiPower <http://ekipower.github.com/>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */ 

namespace Eki\Payum\Nganluong\Bridge\Sylius;

use Eki\Payum\Nganluong\Bridge\Symfony\Action\GetPaymentMethodAction as BaseGetPaymentMethodAction;
use Eki\Payum\Nganluong\Request\GetPaymentMethod;

use Sylius\Component\Payment\Model\PaymentInterface;

class GetPaymentMethodAction extends BaseGetPaymentMethodAction
{
    /**
     * {@inheritDoc}
     */
    public function supports($request)
    {
        return 
			$request instanceof GetPaymentMethod &&
			$request->getModel() instanceof PaymentInterface
		;
    }

	/**
	* @inheritdoc
	*/
	protected function getPaymentMethodName($model)
	{
		/**
		* @var Sylius\Component\Payment\Model\PaymentInterface $payment
		*/
		$payment = $model;
		return $payment->getMethod()->getName();
	}
}
