<?php
/**
 * This file is part of the EkiPayumNganluongBundle package.
 *
 * (c) EkiPower <http://ekipower.github.com/>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */ 

namespace Eki\Payum\Nganluong\Action;

use Eki\Payum\Nganluong\Api;
use Eki\Payum\Nganluong\Api\Errors;
use Eki\Payum\Nganluong\Api\PaymentMethods;
use Eki\Payum\Nganluong\Api\TransactionStatus;
use Eki\Payum\Nganluong\Api\State\StateInterface;
use Eki\Payum\Nganluong\Request\Log;
//use Eki\Payum\Nganluong\Request\GetPaymentMethod;
use Eki\Payum\Nganluong\Request\DetermineBank;
use Eki\Payum\Nganluong\Request\Api\SetExpressCheckout;
use Eki\Payum\Nganluong\Request\Api\GetTransactionDetails;

use Payum\Core\Action\PaymentAwareAction;
use Payum\Core\ApiAwareInterface;
use Payum\Core\Bridge\Spl\ArrayObject;
use Payum\Core\Exception\LogicException;
use Payum\Core\Reply\HttpRedirect;
use Payum\Core\Request\Capture;
use Payum\Core\Exception\RequestNotSupportedException;

class CaptureAction extends PaymentAwareAction implements ApiAwareInterface
{
    /**
     * @var Api
     */
    protected $api;

    /**
     * {@inheritDoc}
     */
    public function setApi($api)
    {
        if (false == $api instanceof Api) {
            throw new UnsupportedApiException('Api not supported.');
        }
        
        $this->api = $api;
    }

    /**
     * {@inheritDoc}
     */
    public function execute($request)
    {
        /** @var $request Capture */
        RequestNotSupportedException::assertSupports($this, $request);

        $model = ArrayObject::ensureArrayObject($request->getModel());

        if ( false == $model['token'] ) 
		{
			$this->payment->execute(new Log('No token. First....', $this));

            if (false == $model['return_url'] && $request->getToken()) {
                $model['return_url'] = $request->getToken()->getTargetUrl();
            }

            if (false == $model['cancel_url'] && $request->getToken()) {
                $model['cancel_url'] = $request->getToken()->getTargetUrl();
            }
			
			$this->processPaymentInfo($request, $model);

			$model['state'] = StateInterface::STATE_WAITING;
			$this->payment->execute(new Log('Waiting for reply when calling SetExpressCheckout', $this));
            $this->payment->execute(new SetExpressCheckout($model));

			$this->payment->execute(new Log($model, $this, 'Return from SetExpressCheckout'));

			// Process return from Nganluong gateway
            if ( isset($model['error_code']) )
			{
				if ( $model['error_code'] === Errors::ERRCODE_NO_ERROR )
				{
			        if (isset($model['checkout_url'])) 
					{
						$model['state'] = StateInterface::STATE_REPLIED;
						$this->payment->execute(new Log('checkout_url='.$model['checkout_url'], $this));
			            throw new HttpRedirect($model['checkout_url']);
			        }
					else
					{
						$model['state'] = StateInterface::STATE_ERROR;
						$this->payment->execute(new Log('No checkout_url returned.', $this));
					}
				}
				else
				{
					$this->payment->execute(new Log('Return fron API with error_code='.$model['error_code'], $this));
				}
            }
			else
			{
				$this->payment->execute(new Log('No index error_code returned in model', $this));
			}
		}

		else
		{
			$this->payment->execute(new Log('Before calling GetTransactionDetails', $this));
			$this->payment->execute(new Log((array)$model, $this));
			
	        $copiedModel = new ArrayObject(array(
	            'token' => $model['token'],
	        ));
			
            $this->payment->execute(new GetTransactionDetails($copiedModel));

			$this->payment->execute(new Log('After calling GetTransactionDetails', $this));
			$this->payment->execute(new Log((array)$copiedModel, $this));
			
			if ( $copiedModel['error_code'] === Errors::ERRCODE_NO_ERROR )
			{
				$model['bank_code'] = $copiedModel['bank_code'];
				$model['transaction_id'] = $copiedModel['transaction_id'];
				$model['transaction_status'] = $copiedModel['transaction_status'];
				
				if ( $copiedModel['transaction_status'] == TransactionStatus::PAID )
				{
					$model['state'] = StateInterface::STATE_CONFIRMED;
					$this->payment->execute(new Log('Order paid. OK. OK. OK.', $this));
				}
				else if ( $copiedModel['transaction_status'] == TransactionStatus::NOT_PAID )
				{
					$model['state'] = StateInterface::STATE_ERROR;
					$this->payment->execute(new Log('Payer decided to avoid payment', $this));
				}
				else if ( $copiedModel['transaction_status'] == TransactionStatus::PAID_WAITING_FOR_PROCESS )
				{
					$model['state'] = StateInterface::STATE_NOTIFIED;
					$this->payment->execute(new Log('Payment process notified but not captured.', $this));
				}
				else
				{
					$model['state'] = StateInterface::STATE_ERROR;
					$this->payment->execute(new Log('Payment process return OK but transaction status is not invalid. Unknown error !!!', $this));
				}
			}
			else
			{
				$model['state'] = StateInterface::STATE_ERROR;
				$this->payment->execute(new Log('Error after calling GetTransactionDetails', $this));
			}
		}
    }

	/**
	* Process payment info (method, type, bakn, ...)
	* ) 
	* @param mixed $request
	* @param mixed $model
	* 
	* $return void
	*/
	protected function processPaymentInfo($request, $model)
	{
		// Default is nothing to do
	}
	
    /**
     * {@inheritDoc}
     */
    public function supports($request)
    {
        return
            $request instanceof Capture &&
            $request->getModel() instanceof \ArrayAccess
        ; 
    }
}
