<?php
namespace handler\json;

use \handler\IHander;
use http\HttpContext;

/**
 *
 * @author eaboxt
 */
class JsonHandler implements IHander
{
    /*
     * (non-PHPdoc) 
     * @see \handler\IHander::accept()
     */
    public function accept($object)
    {
        return $object instanceof Json;
    }
    
    /*
     * (non-PHPdoc) 
     * @see \handler\IHander::handle()
     */
    public function handle($object)
    {
        /* @var $object \handler\json\Json */
        $result = null;
        
        $response = HttpContext::get()->getResponse();
        $response->setContentType(JsonUtils::CONTENT_TYPE);
        
        $object = $object->getObject();
        if (is_object($object)) {
            if ($object instanceof \IteratorAggregate) {
                /* @var $object \IteratorAggregate */
                $result = JsonUtils::encodeIterator($object->getIterator());
            } elseif ($object instanceof \Iterator) {
                $result = JsonUtils::encodeIterator($object);
            } else {
                $result = JsonUtils::encode($object);
            }
        } else {
            if (is_array($object)) {
                $result = JsonUtils::encode($object);
            } else {
                throw new \Exception('JSon encoding of a non-object is not supported');
            }
        }
        
        if ($result !== null) {
            $response->getWriter()->write($result);
            $responce->flush();
        }
        
        return $result;
    }
}
