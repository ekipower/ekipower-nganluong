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

use Eki\Payum\Nganluong\Request\Api\GetPaymentMethod;
use Eki\Payum\Nganluong\Request\Log;

use Eki\Payum\Nganluong\Api\PaymentMethods;
use Eki\Payum\Nganluong\Api\PaymentTypes;

use Payum\Core\Security\TokenInterface;
use Sylius\Bundle\PayumBundle\Payum\Action\AbstractCapturePaymentAction;
use Sylius\Component\Core\Model\AdjustmentInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Payment\Model\PaymentInterface;
use Sylius\Component\Addressing\Model\AddressInterface;

class CapturePaymentUsingNganluongAction extends AbstractCapturePaymentAction
{
    /**
     * {@inheritdoc}
     */
    protected function composeDetails(PaymentInterface $payment, TokenInterface $token)
    {
        if ($payment->getDetails()) {
            return;
        }

        $order = $payment->getOrder();

        $details = array();
	
		$billingAddress = $order->getBillingAddress();
		$details['buyer_fullname'] = $this->getBuyerFullname($billingAddress);
		$details['buyer_email'] = $order->getUser()->getEmail();
		$details['buyer_mobile'] = $billingAddress->getPhoneNumber();
		$details['buyer_address'] = $this->getBuyerAddress($billingAddress);

        $details['order_code'] = $order->getNumber().'-'.$payment->getId();
        $details['cur_code'] = strtolower($order->getCurrency());
		$details['total_item'] = count($order->getItems());

		$totalItemsAmount = 0;
        $m = 1;
        foreach ($order->getItems() as $item) 
		{
            $details['item_name'.$m] = $item->getProduct()->getName(); //$item->getId();
            $details['item_amount'.$m] = round($item->getTotal()/$item->getQuantity()/100, 2);
            $details['item_quantity'.$m] = $item->getQuantity();

			$totalItemsAmount += $details['item_amount'.$m];
            $m++;
        }
        $details['total_amount'] = $totalItemsAmount;

        if (0 !== $taxTotal = $this->calculateNonNeutralTaxTotal($order)) 
		{
            $details['tax_amount']  = round($taxTotal / 100, 2);
        }

        if (0 !== $promotionTotal = $order->getAdjustmentsTotal(AdjustmentInterface::PROMOTION_ADJUSTMENT)) 
		{
            $details['discount_amount']  = round($promotionTotal / 100, 2);
        }

        if (0 !== $shippingTotal = $order->getAdjustmentsTotal(AdjustmentInterface::SHIPPING_ADJUSTMENT)) {
            $details['fee_shipping']  = round($shippingTotal / 100, 2);
        }

        $payment->setDetails($details);
    }

    private function calculateNonNeutralTaxTotal(OrderInterface $order)
    {
        $nonNeutralTaxTotal = 0;
        foreach ($order->getAdjustments(AdjustmentInterface::TAX_ADJUSTMENT) as $taxAdjustment) 
		{
            if (!$taxAdjustment->isNeutral()) {
                $nonNeutralTaxTotal = $taxAdjustment->getAmount();
            }
        }

        return $nonNeutralTaxTotal;
    }

	private function getBuyerFullname(AddressInterface $address)
	{
		$fullName = '';
		
		$fullName = $address->getFirstName();
		if ( method_exists($address, 'getMiddleName') && !empty($middleName = $address->getMiddleName()) )
		{
			$fullName = $fullName . ' ' . $middleName;
		}
		
		$fullName = $fullName . ' ' . $address->getLastName();
		
		return $fullName;
	}

	private function getBuyerAddress(AddressInterface $address)
	{
		$street = $address->getStreet();
		$place = null;
		if ( method_exists($address, 'getPlace') && null !== $placeObj = $address->getPlace() )
		{
			$placeObj = $placeObj->getName();
		}
		$city = $address->getCity();
		$province = $address->getProvince()->getName();
		$country = $address->getCountry()->getName();
		
		return
			( empty($street) ? '' : ( $street . ', ' ) )     .
			( empty($place) ? '' : ( $place . ', ' ) )         .
			( empty($city) ? '' : ( $city . ', ' ) )         .
			( empty($province) ? '' : ( $province . ', ' ) ) .
			( empty($country) ? '' : ( $country . ', ' ) )
		;		
	}
}
