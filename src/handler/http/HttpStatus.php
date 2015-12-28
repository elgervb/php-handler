<?php
namespace handler\http;

/**
 * @author eaboxt
 */
class HttpStatus
{

    const STATUS_200_OK = 200;

    const STATUS_201_CREATED = 201;

    const STATUS_204_NO_CONTENT = 204;
    
    const STATUS_301_MOVED_PERMANENTLY = 301;
    
    const STATUS_302_FOUND= 302;

    const STATUS_401_UNAUTHORIZED = 401;

    const STATUS_404_NOT_FOUND = 404;
    
    const STATUS_409_CONFLICT_ON_DOUBLE_ENTRY = 409;
    
    const STATUS_422_UNPROCESSABLE_ENTITY = 422;

    const STATUS_500_INTERNAL_SERVER_ERROR = 500;

    const STATUS_501_NOT_IMPLEMENTED = 501;

    private $httpCode;

    private $content;

    private $extraHeaders;

    /**
     * Create a new HttpError
     *
     * @param $httpCode int
     *            The HTTP status code
     * @param $content mixed
     *            the content to be used to process by a handler. In case you want to register a view, then return a <code>IView</code>. When you want to display a 404 (or other) error page, just return the http error number. Make sure you've added a route with the error code in this case.
     *            
     * @param $extraHeaders array extra http headers to add to the response
     */
    public function __construct($httpCode, $content = null, array $extraHeaders = null)
    {
        $this->httpCode = $httpCode;
        $this->content = $content;
        $this->extraHeaders = $extraHeaders;
    }

    /**
     * Returns the content object
     *
     * @return mixed or null when not set
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Returns the extra http headers to add to the response
     * 
     * @return array
     */
    public function getExtraHeaders()
    {
        return $this->extraHeaders;
    }

    /**
     * Returns the HTTP status code
     *
     * @return int the HTTP status code, NEVER null
     */
    public function getHttpCode()
    {
        return $this->httpCode;
    }
}