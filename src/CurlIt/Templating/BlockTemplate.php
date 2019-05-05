<?php

namespace CurlIt\Templating;

use CurlIt\Templating\PageTemplate as Page;

abstract class BlockTemplate extends Page
{
    /**
     * The data to hand manage.
     * 
     * @var array
     */
    private $data;

    /**
     * Construct the BlockTemplate.
     * 
     * @param string $page
     */
    public function __construct($data)
    {
        parent::__construct('block');
        $this->data = $data;
    }

    /**
     * Retrieve the content for the block.
     * 
     * @param array $data
     * 
     * @return string
     */
    public abstract function getContent($data);

    /**
     * Retrieve the data for a parameter.
     * 
     * @param string $key The key for the parameter.
     * 
     * @return string
     */
    public function getParameter($key)
    {
        if ($key == 'block') {
            return $this->getContent($this->data);
        }
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
}