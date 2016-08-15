<?php
/**
 * This file is part of the EkiPayumBundle package.
 *
 * (c) EkiPower <http://ekipower.github.com/>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */ 

namespace Eki\Payum\Nganluong\Action;

use Payum\Core\Action\ActionInterface;
use Payum\Core\Exception\RequestNotSupportedException;
use Payum\Core\Request\FillOrderDetails;
use Payum\Core\Security\GenericTokenFactoryInterface;

class FillOrderDetailsAction implements ActionInterface
{
    /**
     * @var GenericTokenFactoryInterface
     */
    protected $tokenFactory;

    /**
     * @param GenericTokenFactoryInterface $tokenFactory
     */
    public function __construct(GenericTokenFactoryInterface $tokenFactory = null)
    {
        $this->tokenFactory = $tokenFactory;
    }

    /**
     * {@inheritDoc}
     *
     * @param FillOrderDetails $request
     */
    public function execute($request)
    {
        RequestNotSupportedException::assertSupports($this, $request);

        $order = $request->getOrder();
        $divisor = pow(10, $order->getCurrencyDigitsAfterDecimalPoint());

        $details = $order->getDetails();
		
        $details['order_code'] = $order->getNumber();
        $details['total_amount'] = $order->getTotalAmount() / $divisor;
        $details['cur_code'] = strtolower($order->getCurrencyCode());
		$details['order_description'] = $order->getDescription();
		
		$details['buyer_fullname'] = $order->getClientId();
		$details['buyer_email'] = $order->getClientEmail();

        $order->setDetails($details);
    }

    /**
     * {@inheritDoc}
     */
    public function supports($request)
    {
        return $request instanceof FillOrderDetails;
    }
}
