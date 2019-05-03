<?php

namespace CurlIt\Content\Pages;

use CurlIt\Content\Page;
use \CurlIt\Utility\Base;

class Main extends Page
{
    public function __construct() {
        parent::__construct('main');
    }

    public function prepare($path)
    {

    }

    public function getParameter($key)
    {
        if ($key == 'curlit_session_id') {
            return strtolower((new Base(19))->parse(rand(999999, 99999999)));
        }

        return null;
    }
}