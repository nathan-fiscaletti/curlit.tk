<?php

namespace CurlIt\Content;

abstract class Page
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

    public function __construct($page)
    {
        $this->page = $page;
    }

    /**
     * Parse the template for any parameters.
     *
     * Parameters are added to a template using {{parametername}}.
     * 
     * @return string
     */
    public function output()
    {
        if (! file_Exists('../resources/Templates/'.$this->page.'.html')) {
            throw new \Exception('Missing template file: '.$this->page.'.html');
        }

        $output = file_get_contents('../resources/Templates/'.$this->page.'.html');
        $matches = [];
        preg_match_all('/(?<={{)(.*)(?=}})/U', $output, $matches);

        foreach ($matches[0] as $parameter) {
            $output = str_replace(
                '{{'.$parameter.'}}',
                $this->getParameter($parameter),
                $output
            );
        }

        return $output;
    }

    /**
     * Called immediately after creation in
     * order for the page to load any nessecary
     * data.
     * 
     * @param string $path
     */
    public abstract function prepare($path);

    /**
     * Retrieve the data for a parameter.
     * 
     * @param string $key The key for the parameter.
     * 
     * @return string
     */
    public abstract function getParameter($key);
}