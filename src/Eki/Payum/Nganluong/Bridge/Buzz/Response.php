<?php

namespace Eki\Payum\Nganluong\Bridge\Buzz;

use Buzz\Message\Response as BaseResponse;
use Payum\Core\Exception\LogicException;

use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;

use \DOMDocument;
use \DOMNode;

class Response extends BaseResponse
{
	private $logger;
	
	public function __construct(LoggerInterface $logger)
	{
		$this->logger = $logger;
	}
	
    /**
     * @throws \Payum\Core\Exception\LogicException
     * 
     * @return array
     */
    public function toArray()
    {
		$content = $this->getContent();
        if (count($content) < 1) {
            throw new LogicException("Response content is not valid response: \n\n{$this->getContent()}");
        }


$this->logger->debug('Response::toArray content='.$this->getContent());

		$response = array();

		$xml_result = str_replace('&','&amp;',(string)$this->getContent());
		
$this->logger->debug('Response::toArray content result='.$xml_result);
		
		$xmlElement  = simplexml_load_string($xml_result);
		foreach($xmlElement->children() as $child)
		{
			$response[$child->getName()] = $this->elementToArray($child);
		}
		
		return $response;
	}
	
	private function elementToArray($element)
	{
		if ( count($element->children()) > 0 )
		{
			$retArray = array();
			foreach($element->children() as $child)
			{
				$retArray[$child->getName()] = $this->elementToArray($child);	
			}
			
			return $retArray;		
		}
		else
		{
			return $element->__toString();	
		}
	}		
}
