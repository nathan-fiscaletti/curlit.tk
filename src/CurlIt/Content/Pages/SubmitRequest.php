<?php

namespace CurlIt\Content\Pages;

use CurlIt\Templating\BlockTemplate as Block;
use CurlIt\Data\SavedCurl as Curl;
use CurlIt\Utility\Url;
use GuzzleHttp\Client;

class SubmitRequest extends Block
{
    /**
     * Construct the block with data.
     */
    public function __construct()
    {
        parent::__construct($_POST);
    }

    /*
        {
            "address": "https://api.vrazo.net/ip",
            "method": "GET",
            "headers": [
                {
                    "header": "Content-Type",
                    "value": "application/json"
                }
            ],
            "parameters": [
                {
                    "parameter": "name",
                    "value": "nathan"
                }
            ],
            "payload": "{\\n    \"conform\": true\\n}",
            "http_auth": {
                "user": "nathan",
                "pass": "password"
            },
            "http_version": "",
            "tls_version": ""
        }
    */

    /**
     * Handle the incoming data from the URL AJAX request.
     * 
     * @param array $data
     * 
     * @return string
     */
    public function getContent($data)
    {
        if (! isset($data['address']) || ! isset($data['method'])) {
            http_response_code(400);
            return json_encode(['error' => 'Curl It! Failed to send request to endpoint due to missing parameters. Please try again.']);
        }

        if (! isset($data['parameters'])) {
            $data['parameters'] = [];
        }

        $paramStr = $this->generateParamStr($data['address'], $data['parameters']);

        $headers = [];
        foreach ($data['headers'] as $header) {
            $headers[$header['header']] = $header['value'];
        }

        $httpAuth = null;
        if (isset($data['http_auth'])) {
            $httpAuth = [$data['http_auth']['user'], $data['http_auth']['pass']];
        }

        $verify = true;
        if (isset($data['insecure']) && $data['insecure']) {
            $verify = false;
        }

        $client = new Client([ 'verify' => false ]);
        $res = $client->request($data['method'], $data['address'].$paramStr, [
            'headers' => $headers,
            'body' => $data['payload'],
            'auth' => $httpAuth,
            'verify' => $verify,
        ]);

        $response  =  $res->getStatusCode() . ' ' . $res->getReasonPhrase() . "\r\n\r\n";
        foreach ($res->getHeaders() as $name => $values) {
            $response .= $name . ': '. implode(', ', $values) . "\r\n";
        }
        $response .= "\r\n";
        $response .= $this->formatBody($res->getBody());

        return $response;
    }

    /**
     * Formats a body.
     * 
     * @param string $body
     *
     * @return string
     */
    private function formatBody($body)
    {
        $data = json_decode($body, true);
        if ($data === null) {
            return $body;
        }

        return json_encode($data, JSON_PRETTY_PRINT);
    }

    /**
     * Generate the Parameter String based on an address
     * and the parameters.
     * 
     * @param string $address
     * @param array $params
     * 
     * @return string
     */
    private function generateParamStr($address, $params)
    {
        $paramStr = "";
        
        foreach ($params as $param) {
            if ($paramStr == '' && strpos($address, '?') === false) {
                $paramStr .= '?';
            } else {
                $paramStr .= '&';
            }
            $paramStr .= $param['parameter'];

            if (isset($param['value']) && ! is_null($param['value'])) {
                $paramStr .= '='.$param['value'];
            }
        }

        return $paramStr;
    }
}