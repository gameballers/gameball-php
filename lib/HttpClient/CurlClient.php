<?php

namespace Gameball\HttpClient;


use Gameball\Exception;
use Gameball\Util;



// The class handles All Http requests (GET,POST,DELETE) uses cURL in PHP

class CurlClient implements ClientInterface{
    private static $instance; // instance of CurlClient

    public static function instance(){
        if (!self::$instance)
        {
            self::$instance = new self();
        }

        return self::$instance;
    }


    /**
    *@var $userAgentInfo: array that carries info about curl version and ssl version
    */
    private $userAgentInfo;

    /** @var $enablePersistentConnections: specify whether the opened session is persistent or not**/
    private $enablePersistentConnections = true;

    /** @var $enableHttp2: specify whether http2 is enabled**/
    private $enableHttp2;

    /** @var $curlHandle: the curl handle for doing the request**/
    private $curlHandle;

    /** @var callback function that returns the content of the response**/
    private $requestStatusCallback;



    public function __construct()
    {
        $this->initUserAgentInfo();

        $this->enableHttp2 = $this->canSafelyUseHttp2();
    }


    public function initUserAgentInfo()
    {
        $curlVersion = \curl_version();
        $this->userAgentInfo = [
            'httplib' => 'curl ' . $curlVersion['version'],
            'ssllib' => $curlVersion['ssl_version'],
        ];
    }

    /**
     * Indicates whether it is safe to use HTTP/2 or not.
     *
     * @return bool
     */
    private function canSafelyUseHttp2()
    {
        // Versions of curl older than 7.60.0 don't respect GOAWAY frames
        // (cf. https://github.com/curl/curl/issues/2416)
        $curlVersion = \curl_version()['version'];

        return \version_compare($curlVersion, '7.60.0') >= 0;
    }


    public function getUserAgentInfo()
    {
        return $this->userAgentInfo;
    }



    /**
     * @return bool
     */
    public function getEnablePersistentConnections()
    {
        return $this->enablePersistentConnections;
    }

    /**
     * @param bool $enable
     */
    public function setEnablePersistentConnections($enable)
    {
        $this->enablePersistentConnections = $enable;
    }


    /**
     * @return bool
     */
    public function getEnableHttp2()
    {
        return $this->enableHttp2;
    }

    /**
     * @param bool $enable
     */
    public function setEnableHttp2($enable)
    {
        $this->enableHttp2 = $enable;
    }

    /**
     * @return null|callable: the function that is called after each request
     */
    public function getRequestStatusCallback()
    {
        return $this->requestStatusCallback;
    }

    /**
     * Sets a callback that is called after each request. The callback will
     * receive the following parameters:
     * <ol>
     *   <li>string $rbody The response body</li>
     *   <li>integer $rcode The response status code</li>
     *   <li>\Gameball\Util\CaseInsensitiveArray $rheaders The response headers</li>
     *   <li>integer $errno The curl error number</li>
     *   <li>string|null $message The curl error message</li>
     * </ol>.
     *
     * @param null|callable $requestStatusCallback
     */
    public function setRequestStatusCallback($requestStatusCallback)
    {
        $this->requestStatusCallback = $requestStatusCallback;
    }

    // USER DEFINED TIMEOUTS

    const DEFAULT_TIMEOUT = 80;
    const DEFAULT_CONNECT_TIMEOUT = 30;

    private $timeout = self::DEFAULT_TIMEOUT;
    private $connectTimeout = self::DEFAULT_CONNECT_TIMEOUT;


    /**
    * @return CurlClient object associated with the method call
    */
    public function setTimeout($seconds)
    {
        $this->timeout = (int) \max($seconds, 0); // cannot be negative

        return $this;
    }

    public function setConnectTimeout($seconds)
    {
        $this->connectTimeout = (int) \max($seconds, 0);

        return $this;
    }

    public function getTimeout()
    {
        return $this->timeout;
    }

    public function getConnectTimeout()
    {
        return $this->connectTimeout;
    }

    // END OF USER DEFINED TIMEOUTS


    // // To use the your customized time outs illustration:
    // // set up your tweaked Curl client
    // $curl = new \Gameball\HttpClient\CurlClient();
    // $curl->setTimeout(10); // default is \Gameball\HttpClient\CurlClient::DEFAULT_TIMEOUT
    // $curl->setConnectTimeout(5); // default is \Gameball\HttpClient\CurlClient::DEFAULT_CONNECT_TIMEOUT
    //
    // echo $curl->getTimeout(); // 10
    // echo $curl->getConnectTimeout(); // 5
    //
    // // tell Gameball to use the tweaked client
    // \Gameball\ApiRequestor::setHttpClient($curl);
    //
    // // use the Gameball API client as you normally would


  /**
  * @param string $method: method name (get, post, delete): Case Insensitive
  * @param string $absURL: the full url of the API, including domain and protocol
  * @param array $header: the header of the HTTP request
  * @param array $parameters:(optional) the parameters to be send in the HTTP request if needed
  */
  public function request($method, $absUrl, $headers, $params=null){
        $method = \strtolower($method);

        $opts = [];



        if ('get' === $method)
        {
            $opts[\CURLOPT_HTTPGET] = 1;
            // if it is get with passed parameters

            if (\count($params) > 0) {
                $encoded = http_build_query($params);
                $absUrl = "{$absUrl}?{$encoded}";
            }
        }
        elseif ('post' === $method)
        {
            $opts[\CURLOPT_POST] = 1;
            $json_encoded = json_encode($params);
            $json_encoded = \str_replace("[]","{}",$json_encoded);
            $opts[\CURLOPT_POSTFIELDS] = $json_encoded;
        }
        elseif ('put' === $method)
        {
            $opts[\CURLOPT_CUSTOMREQUEST] = "PUT";
            $opts[\CURLOPT_RETURNTRANSFER] = 1;
            $json_encoded = json_encode($params);
            $json_encoded = \str_replace("[]","{}",$json_encoded);
            $opts[\CURLOPT_POSTFIELDS] = $json_encoded;
        }
        elseif ('delete' === $method)
        {
            $opts[\CURLOPT_CUSTOMREQUEST] = 'DELETE';
            // if delete with passed parameters

            if (\count($params) > 0) {
                $json_encoded = json_encode($params);
                $json_encoded = \str_replace("[]","{}",$json_encoded);
                $opts[\CURLOPT_POSTFIELDS] = $json_encoded;
            }
        }
        else
        {
            throw new Exception\GameballException($message="Unrecognized method {$method}");
        }


        // By default for large request body sizes (> 1024 bytes), cURL will
        // send a request without a body and with a `Expect: 100-continue`
        // header and then try to send the body in a second post request
        // (dual phase post), This way of doing the post request gives the
        // server a chance to respond with an error status code in cases where
        // one can be determined right away (say on an authentication problem for example),
        // and saves the "large" request body from being ever sent.
        //
        // Assuming that, the bindings don't currently correctly handle the
        // success case of doing this dual phase post request(in which the server
        // sends back a 100 CONTINUE), so we'll error under that condition.
        // To compensate for that problem for the time being,
        // override cURL's behavior by simply always
        // sending an empty `Expect:` header.

        \array_push($headers, 'Expect: ');


        $opts[\CURLOPT_URL] = $absUrl;
        $opts[\CURLOPT_RETURNTRANSFER] = true;
        $opts[\CURLOPT_CONNECTTIMEOUT] = $this->connectTimeout;
        $opts[\CURLOPT_TIMEOUT] = $this->timeout;
        $opts[\CURLOPT_HTTPHEADER] = $headers;
        $opts[\CURLOPT_HEADER] = true;

        // disabling the ssl verification
        $opts[\CURLOPT_SSL_VERIFYPEER] = false;
        $opts[\CURLOPT_SSL_VERIFYHOST] = false;
        //end of disabling the ssl verification


        // left as an option to switch to putting ca certificates and verify ssllib

        // $opts[\CURLOPT_CAINFO] = \Gameball\Gameball::getDefaultCABundlePath();
        // if (!\Gameball\Gameball::getVerifySslCerts()) {
        //     $opts[\CURLOPT_SSL_VERIFYPEER] = false;
        // }


        // if you want a detailed response
        // $opts[\CURLOPT_VERBOSE] = true;


        $rheaders = new Util\CaseInsensitiveArray();
        // Create a callback to capture HTTP headers for the response

        $headerCallback = function ($curl, $header_line) use (&$rheaders) {
                // Ignore (HTTP/1.1 200 OK)
                if (false === \strpos($header_line, ':')) {
                    return \strlen($header_line);
                }
                list($key, $value) = \explode(':', \trim($header_line), 2);
                $rheaders[\trim($key)] = \trim($value);

                return \strlen($header_line);
        };
        $opts[\CURLOPT_HEADERFUNCTION] = $headerCallback;


        $this->resetCurlHandle();
        \curl_setopt_array($this->curlHandle, $opts);
        $rbody = \curl_exec($this->curlHandle);


        // Leaving option for creating a callback function after each request

        // if (\is_callable($this->getRequestStatusCallback())) {
        //         \call_user_func_array(
        //             $this->getRequestStatusCallback(),
        //             [$rbody, $rcode, $rheaders, $errno, $message]
        //         );
        // }


        if (false === $rbody)
        {
            $errno = \curl_errno($this->curlHandle);
            $message = \curl_error($this->curlHandle);
            $this->handleCurlError($absUrl, $errno, $message);
        }
        else
        {
            $rcode = \curl_getinfo($this->curlHandle, \CURLINFO_HTTP_CODE);
        }



        return [$rbody, $rcode, $rheaders];
        //[response body, response code ,response headers]
    }


    /**
     * @param string $url
     * @param int $errno: cURL error code
     * @param string $message: cURL error message
     *
     * @throws Exception\GameballException
     */
    private function handleCurlError($url, $errno, $message)
    {
        switch ($errno)
        {
            case \CURLE_COULDNT_CONNECT:
            case \CURLE_COULDNT_RESOLVE_HOST:
            case \CURLE_OPERATION_TIMEOUTED:
                $msg = "Could not connect to Gameball ({$url}).  Please check your "
                 . 'internet connection and try again.  If this problem persists, ';
                break;

            case \CURLE_SSL_CACERT:
            case \CURLE_SSL_PEER_CERTIFICATE:
                $msg = "Could not verify Gameball's SSL certificate.  Please make sure "
                 . 'that your network is not intercepting certificates.  '
                 . 'If this problem persists, ';

                break;
            default:
                $msg = 'Unexpected error communicating with Gameball.  '
                 . 'If this problem persists, ';
        }
        $msg .= 'let us know at support@gameball.co';

        $msg .= "\n\n(Network error [errno {$errno}]: {$message})";



        throw new Exception\GameballException($message=$msg);
    }

    /**
     * Initializes the curl handle. If already initialized, the handle is closed first.
     */
    private function initCurlHandle()
    {
        $this->closeCurlHandle();
        $this->curlHandle = \curl_init();
    }

    public function __destruct()
    {
        $this->closeCurlHandle();
    }
    /**
     * Closes the curl handle if initialized. Do nothing if already closed.
     */
    private function closeCurlHandle()
    {
        if (null !== $this->curlHandle) {
            \curl_close($this->curlHandle);
            $this->curlHandle = null;
        }
    }

    /**
     * Resets the curl handle. If the handle is not already initialized, or if persistent
     * connections are disabled, the handle is reinitialized instead.
     */
    private function resetCurlHandle()
    {
        if (null !== $this->curlHandle && $this->getEnablePersistentConnections())
        {
            \curl_reset($this->curlHandle);
        }
        else
        {
            $this->initCurlHandle();
        }
    }

}
?>
