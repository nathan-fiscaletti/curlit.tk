<?php

namespace CurlIt\Content\Pages;

use CurlIt\Templating\BlockTemplate as Block;
use CurlIt\Data\SavedCurl as Curl;
use CurlIt\Utility\Url;

class GenerateURL extends Block
{
    /**
     * Construct the block with data.
     */
    public function __construct()
    {
        parent::__construct($_POST);
    }

    /**
     * Handle the incoming data from the URL AJAX request.
     * 
     * @param array $data
     * 
     * @return string
     */
    public function getContent($data)
    {
        $curl = new Curl;

        $curl->address = $data['address'];
        $curl->method = $data['method'];
        $curl->payload = $data['payload'];
        $curl->http_user = $data['http_auth']['user'];
        $curl->http_password = $data['http_auth']['pass'];
        $curl->insecure = $data['insecure'] == "true" ? 1 : 0;
        $curl->parameters = json_encode($data['parameters']);
        $curl->headers = json_encode($data['headers']);

        header('Content-Type: application/json');
        try {
            if ($curl->save()) {
                return json_encode(["url" => Url::generateUrl(Curl::curlIdToUrlId($curl->id))]);
            } else {
                return json_encode(["error" => 'Failed to create a custom URL. Maybe some required fields are missing?']);
            }
        } catch (\Exception $e) {
            return json_encode(["error" => 'Failed to create a custom URL. Maybe some required fields are missing?']);
        }
    }
}