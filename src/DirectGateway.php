<?php

namespace Omnipay\SagePay;

use Omnipay\Common\AbstractGateway;

/**
 * Sage Pay Direct Gateway
 */
class DirectGateway extends AbstractGateway
{
    // Gateway identification.

    public function getName()
    {
        return 'Sage Pay Direct';
    }

    public function getDefaultParameters()
    {
        return [
            'vendor' => '',
            'testMode' => false,
            'referrerId' => '',
        ];
    }

    /**
     * Vendor identification.
     */
    public function getVendor()
    {
        return $this->getParameter('vendor');
    }

    public function setVendor($value)
    {
        return $this->setParameter('vendor', $value);
    }

    public function getReferrerId()
    {
        return $this->getParameter('referrerId');
    }

    public function setReferrerId($value)
    {
        return $this->setParameter('referrerId', $value);
    }

    /**
     * Basket type control.
     */
    public function setUseOldBasketFormat($value)
    {
        $value = (bool)$value;

        return $this->setParameter('useOldBasketFormat', $value);
    }

    public function getUseOldBasketFormat()
    {
        return $this->getParameter('useOldBasketFormat');
    }

    // Access to the HTTP client for debugging.
    // NOTE: this is likely to be removed or replaced with something
    // more appropriate.

    public function getHttpClient()
    {
        return $this->httpClient;
    }

    /**
     * Direct methods.
     */

    /**
     * Authorize and handling of return from 3D Secure or PayPal redirection.
     */
    public function authorize(array $parameters = [])
    {
        return $this->createRequest(Message\DirectAuthorizeRequest::class, $parameters);
    }

    public function completeAuthorize(array $parameters = [])
    {
        return $this->createRequest(Message\DirectCompleteAuthorizeRequest::class, $parameters);
    }

    /**
     * Purchase and handling of return from 3D Secure or PayPal redirection.
     */
    public function purchase(array $parameters = [])
    {
        return $this->createRequest(Message\DirectPurchaseRequest::class, $parameters);
    }

    public function completePurchase(array $parameters = [])
    {
        return $this->completeAuthorize($parameters);
    }

    /**
     * Shared methods (identical for Direct and Server).
     */

    /**
     * Capture an authorization.
     */
    public function capture(array $parameters = [])
    {
        return $this->createRequest(Message\SharedCaptureRequest::class, $parameters);
    }

    /**
     * Void a paid transaction.
     */
    public function void(array $parameters = [])
    {
        return $this->createRequest(Message\SharedVoidRequest::class, $parameters);
    }

    /**
     * Abort an authorization.
     */
    public function abort(array $parameters = [])
    {
        return $this->createRequest(Message\SharedAbortRequest::class, $parameters);
    }

    /**
     * Void a completed (captured) transation.
     */
    public function refund(array $parameters = [])
    {
        return $this->createRequest(Message\SharedRefundRequest::class, $parameters);
    }

    /**
     * Create a new authorization against a previous payment.
     */
    public function repeatAuthorize(array $parameters = [])
    {
        return $this->createRequest(Message\SharedRepeatAuthorizeRequest::class, $parameters);
    }

    /**
     * Create a new purchase against a previous payment.
     */
    public function repeatPurchase(array $parameters = [])
    {
        return $this->createRequest(Message\SharedRepeatPurchaseRequest::class, $parameters);
    }

    /**
     * Accept card details from a user and return a token, without any
     * authorization against that card.
     * i.e. standalone token creation.
     * Standard Omnipay function.
     */
    public function createCard(array $parameters = [])
    {
        return $this->registerToken($parameters);
    }

    /**
     * Accept card details from a user and return a token, without any
     * authorization against that card.
     * i.e. standalone token creation.
     */
    public function registerToken(array $parameters = [])
    {
        return $this->createRequest(Message\DirectTokenRegistrationRequest::class, $parameters);
    }

    /**
     * Remove a card token from the account.
     * Standard Omnipay function.
     */
    public function deleteCard(array $parameters = [])
    {
        return $this->removeToken($parameters);
    }

    /**
     * Remove a card token from the account.
     */
    public function removeToken(array $parameters = [])
    {
        return $this->createRequest(Message\SharedTokenRemovalRequest::class, $parameters);
    }

    /**
     * @deprecated use repeatAuthorize() or repeatPurchase()
     */
    public function repeatPayment(array $parameters = [])
    {
        return $this->createRequest(Message\SharedRepeatPurchaseRequest::class, $parameters);
    }
}
