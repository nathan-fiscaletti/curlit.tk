<?php

namespace CurlIt\Content\Pages;

use CurlIt\Templating\PageTemplate as Page;

class Contact extends Page
{
    /**
     * Construct the page.
     * 
     * @param string $page
     */
    public function __construct()
    {
        parent::__construct('contact');
    }

    /**
     * Called immediately after creation in
     * order for the page to load any nessecary
     * data.
     * 
     * @param string $path
     */
    public function prepare($path)
    {
       /* Not implemented */ 
    }

    /**
     * Retrieve the data for a parameter.
     * 
     * @param string $key The key for the parameter.
     * 
     * @return string
     */
    public function getParameter($key)
    {
       /* Not implemented */
    }
}