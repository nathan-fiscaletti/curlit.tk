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
        header('Content-Type: application/json');
        return json_encode(["url" => Url::generateUrl(Curl::curlIdToUrlId(998123))]);

        //$curl = new Curl();
        //foreach ($data as $paramater => $data_item) {
        //    $curl->{$parameter} = $data_item;
        //}
    }
}