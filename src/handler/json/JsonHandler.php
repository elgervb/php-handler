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
        return $object instanceof Json || is_array($object);
    }
    
    /*
     * (non-PHPdoc) 
     * @see \handler\IHander::handle()
     */
    public function handle($object)
    {
        /* @var $object \handler\json\Json */
        $result = null;
        if ($object instanceof Json) {
        	$result = $this->handleJson($object);
        } else {
            if (is_array($object)) {
                $result = JsonUtils::encode($object);
            } else {
                throw new \Exception('JSon encoding of a non-object is not supported');
            }
        }
        
        if ($result !== null) {
            $response = HttpContext::get()->getResponse();
            $response->setContentType(JsonUtils::CONTENT_TYPE);
            $response->write($result);
            $response->flush();
        }
        
        return $result;
    }
    
    private function handleJson(Json $object) {
        // check if the json has an internal object, else serialize itself
        if ($object->getObject()) {
            $object = $object->getObject();
        }
    	$result = null;
    	
    	if (is_object($object)) {
    		if ($object instanceof \IteratorAggregate) {
    			/* @var $object \IteratorAggregate */
    			$result = JsonUtils::encodeIterator($object->getIterator());
    		} elseif ($object instanceof \Iterator) {
    			$result = JsonUtils::encodeIterator($object);
    		} else {
    			$result = JsonUtils::encode($object);
    		}
    	} else if (is_array($object)) {
    	    $result = JsonUtils::encode($object);
    	}
    	
    	return $result;
    }
}
