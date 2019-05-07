<?php

namespace CurlIt\Templating;

use CurlIt\Templating\FileTemplate;

abstract class PageTemplate extends FileTemplate
{
    /**
     * The page name.
     * 
     * This corresponds to the file name
     * in ./resouces/Templates/{page}.html
     * 
     * @var string
     */
    private $page;

    /**
     * Construct the page.
     * 
     * @param string $page
     */
    public function __construct($page)
    {
        $this->page = $page;

        if (! file_Exists('../resources/templates/'.$this->page.'.html')) {
            throw new \Exception('Missing template file: '.$this->page.'.html');
        }

        parent::__construct('../resources/templates/'.$this->page.'.html');
    }

    /**
     * Called immediately after creation in
     * order for the page to load any nessecary
     * data.
     * 
     * @param string $path
     */
    public abstract function prepare($path);
}