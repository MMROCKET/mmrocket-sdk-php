<?php
namespace Mmrocket\MmrocketSdkPhp\Http;


class ApiResponse
{    
    private $headers;
    
    public $content;
    
    public  $statusCode;

    protected $requestData;

    /**
     * Construct object
     *
     * @param int $statusCode
     * @param string $content
     * @param array $headers
     */
    public function __construct($statusCode, $content, $headers = array(), $requestData = null)
    {
        $this->statusCode   = $statusCode;
        $this->headers      = $headers;
        $this->content      = $content;
        $this->requestData  = $requestData;
    }

    /**
     * Get array format of api response
     * @return array
     */
    public function toArray()
    {
        return \json_decode($this->content, true);
    }

    /**
     * Get json format of api response
     * @return string
     */
    public function toJson() : string
    {
        return $this->content;
    }

    /**
     * Get the status code of the response
     * @return numeric
     */
    public function getStatusCode() : int
    {
        return $this->statusCode;
    }

    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * Checks if api call was successful ie 200, 201 etc
     * return bool
     */
    public function isSuccess() : bool
    {
        return $this->getStatusCode() < 400;
    }
 

    public function __toString()
    {
        return '[Response] HTTP ' . $this->getStatusCode() . ' ' . $this->content;
    }
}