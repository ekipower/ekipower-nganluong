<?php
/**
 * This file is part of the EkiNganluongSimulator package.
 *
 * (c) EkiPower <http://ekipower.github.com/>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */ 

namespace Eki\Nganluong\Simulator\Persistent;

use Doctrine\Common\Cache\Cache;

use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;

class CachePersistent implements PersistentInterface
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
	}

	/**
	* 
	* @var Doctrine\Common\Cache\Cache
	* 
	*/
	private $cache;
	
	public function setCache(Cache $cache)
	{
		$this->cache = $cache;
	}

	public function createToken($obj)
	{
		if ( !is_object( $obj ) )
		{
			throw new \LogicException('Token supported for object only');
		}

		return spl_object_hash( $obj );
	}

	public function get($token)
	{
		if ( false == ( $obj = $this->cache->fetch( $token ) ) )
			return null;
		return $obj;
	}
	
	public function delete($obj)
	{
		if ( $this->cache->contains( $obj->getToken() ) )
		{
			$this->cach->delete( $token );
//			unset($obj);
		}
	}
	
	public function save($obj)
	{
$this->logger->info(__CLASS__.'::'.__FUNCTION__.'===============================');		
		if ( !is_object( $obj ) )
		{
$this->logger->info(__CLASS__.'::'.__FUNCTION__.'eeeeeeeeeeeeeeeeeeeeeeeeeeeeeee');		
			throw new \LogicException('Persistent saving supported for object only');
		}
$this->logger->info(__CLASS__.'::'.__FUNCTION__.'1111111111111111111111111');		
		return $this->cache->save($obj->getToken(), $obj, 28800);  // TTL = 8h
	}
}
