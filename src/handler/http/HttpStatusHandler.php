<?php
namespace handler\http;

use \handler\IHander;
use http\HttpContext;
use handler\Handlers;

/**
 * Handle HTTP status codes: 200, 301, 302, 400, 500, etc
 * 
 * @author eaboxt
 *        
 */
class HttpStatusHandler implements IHander
{
    /*
     * (non-PHPdoc) @see \handler\IHander::accept()
     */
    public function accept($object)
    {
        return $object instanceof HttpStatus;
    }
    
    /*
     * (non-PHPdoc) @see \handler\IHander::handle()
     */
    public function handle($object)
    {
        /* @var $object \handler\http\HttpStatus */
        $response = HttpContext::get()->getResponse();
        
        $response->setStatusCode($object->getHttpCode());
        
        // add extra headers
        $extraHeaders = $object->getExtraHeaders();
        if ($extraHeaders) {
            foreach ($extraHeaders as $header => $value) {
                $response->addHeader($header, $value);
            }
        }
        
        switch ($object->getHttpCode()) {
            case 301:
            case 302:
                return $this->handleRedirect($object);
            default:
                return $this->handleDefault($object);
        }
    }

    /**
     * Handle the default.
     * Just try to look for a template and return it
     *
     * @param HttpStatus $object            
     * @return \compact\handler\impl\http\HttpStatus
     */
    private function handleDefault(HttpStatus $object)
    {
        if ($object->getContent()) {
            $handler = Handlers::get()->getHandler($object->getContent());
            if ($handler) { /* @var $handler \handler\IHander */
                return $handler->handle($object->getContent());
            }
        }
        
        return $object;
    }

    private function handleRedirect(HttpStatus $object)
    {
        HttpContext::get()
            ->getResponse()
            ->redirect($object->getContent());
        
        return $object;
    }
}