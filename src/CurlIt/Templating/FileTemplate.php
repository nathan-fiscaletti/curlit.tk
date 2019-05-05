<?php

namespace CurlIt\Templating;

use CurlIt\Templating\TemplateParser as Template;

abstract class FileTemplate extends Template
{
    /**
     * Construct the FileTemplate.
     * 
     * @param string $page
     */
    public function __construct($blockFile)
    {
        parent::__construct(file_get_contents($blockFile));
    }
}