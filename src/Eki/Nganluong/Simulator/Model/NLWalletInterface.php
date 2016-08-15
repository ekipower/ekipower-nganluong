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

interface NLWalletInterface
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
     * Get email.
     *
     * @return string
     */
    public function getEmail();

    /**
     * Set email.
     *
     * @param string $email
     */
    public function setEmail($email);

    /**
     * Get password.
     *
     * @return string
     */
    public function getPassword();

    /**
     * Set password.
     *
     * @param string $password
     */
    public function setPassword($password);
}
