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

class NLWallet implements NLWalletInterface
{
    /**
     * Identifier.
     *
     * @var mixed
     */
    protected $id;

    /**
     * Special token for payment gateway.
     *
     * @var string
     */
    protected $token;

	/**
	* Email
	* 
	* @var string
	* 
	*/
	protected $email;
	
	/**
	* Password
	*  
	* @var string
	* 
	*/
	protected $password;	
	
    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }
	
    /**
     * Get payment gateway token.
     *
     * @return string
     */
    public function getToken()
	{
		return $this->token;
	}

    /**
     * Set payment gateway token.
     *
     * @param string $token
     */
    public function setToken($token)
	{
		$this->token = $token;
		
		return $this;
	}

    /**
     * Get email.
     *
     * @return string
     */
    public function getEmail()
	{
		return $this->email;
	}

    /**
     * Set email.
     *
     * @param string $email
     */
    public function setEmail($email)
	{
		$this->email = $email;
		
		return $this;
	}

    /**
     * Get password.
     *
     * @return string
     */
    public function getPassword()
	{
		return $this->password;
	}

    /**
     * Set password.
     *
     * @param string $password
     */
    public function setPassword($password)
	{
		$this->password;
		
		return $this;
	}
}
