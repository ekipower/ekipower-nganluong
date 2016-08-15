<?php
/**
 * This file is part of the EkiNganluongSimulator package.
 *
 * (c) EkiPower <http://ekipower.github.com/>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */ 

namespace Eki\Nganluong\Simulator\Model;

interface AtmCardInterface
{
    /**
     * Get payment gateway token.
     *
     * @return string
     */
    public function getToken();

    /**
     * Set payment gateway token.
     *
     * @param string $token
     */
    public function setToken($token);

    /**
     * Get the type of credit card.
     * VISA, MasterCard...
     *
     * @return string
     */
    public function getType();

    /**
     * Set the type of cc.
     *
     * @param string $type
     */
    public function setType($type);

    /**
     * Get cardholder name.
     *
     * @return string
     */
    public function getCardholderName();

    /**
     * Set cardholder name.
     *
     * @param string $cardholderName
     */
    public function setCardholderName($cardholderName);

    /**
     * Get number.
     *
     * @return string
     */
    public function getNumber();

    /**
     * Set number.
     *
     * @param string $number
     */
    public function setNumber($number);

    /**
     * Get last 4 digits of number.
     *
     * @return string
     */
    public function getMaskedNumber();

    /**
     * Get security code.
     *
     * @return string
     */
    public function getSecurityCode();

    /**
     * Set security code.
     *
     * @param string $securityCode
     */
    public function setSecurityCode($securityCode);

    /**
     * Get expiry month.
     *
     * @return integer
     */
    public function getExpiryMonth();

    /**
     * Set expiry month.
     *
     * @param integer
     */
    public function setExpiryMonth($expiryMonth);

    /**
     * Get expiry year.
     *
     * @return integer
     */
    public function getExpiryYear();

    /**
     * Set expiry year.
     *
     * @param integer $expiryYear
     */
    public function setExpiryYear($expiryYear);
}
