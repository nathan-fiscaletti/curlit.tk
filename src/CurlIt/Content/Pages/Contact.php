<?php

namespace CurlIt\Content\Pages;

use CurlIt\Content\Page;

class Contact extends Page
{
    public function __construct() {
        parent::__construct('contact');
    }

    public function prepare($path)
    {
        
    }

    public function getParameter($key)
    {
        return null;
    }
}