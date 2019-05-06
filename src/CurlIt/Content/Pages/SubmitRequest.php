<?php

namespace CurlIt\Content\Pages;

use CurlIt\Templating\BlockTemplate as Block;
use CurlIt\Data\SavedCurl as Curl;
use CurlIt\Utility\Url;

class SubmitRequest extends Block
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
        
    }
}