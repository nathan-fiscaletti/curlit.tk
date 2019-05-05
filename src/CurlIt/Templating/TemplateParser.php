<?php

namespace CurlIt\Templating;

use CurlIt\Utility\Url;

abstract class TemplateParser
{
    /**
     * Constant used to tell the parser that the template
     * code that was just parsed was a template command
     * block and not a regular eval block.
     * 
     * @var int 
     */
    private $current_block_return;

    /**
     * The current parser being parsed.
     * 
     * @var \CurlIt\Utility\TemplateParser
     */
    public static $current_parser;

    /**
     * The content to be parsed
     * 
     * @var string
     */
    private $content;

    /**
     * Load the content to construct the parser.
     * 
     * @param string $content
     */
    public function __construct($content)
    {
        $this->content = $content;
    }

    /**
     * Retrieve the data for a parameter.
     * 
     * @param string $key The key for the parameter.
     * 
     * @return string
     */
    public abstract function getParameter($key);

    /**
     * Add output to the current block return.
     * 
     * @param string $output
     */
    public function addOutputForCurrentBlock($output)
    {
        $this->current_block_return .= $output;
    }

    /**
     * Parse the template.
     * 
     * @return string
     */
    public function parse()
    {
        self::$current_parser = $this;
        $output = $this->content;
        $matches = [];
        preg_match_all('/(?<={{)(.*)(?=}})/Us', $output, $matches);

        foreach ($matches[0] as $parameter) {
            $this->current_block_return = '';

            // We check here in case the parameter was 
            // already replaced by a previous iteration.
            if (strpos($output, '{{'.$parameter.'}}') !== false) {
                $output = str_replace(
                    '{{'.$parameter.'}}',
                    $this->getParameterInternal($parameter),
                    $output
                );
            }
        }

        return $output;
    }

    /**
     * Retrieve a parameter.
     * 
     * @param string $parameter
     * 
     * @return mixed
     */
    private function getParameterInternal($parameter)
    {
        if (strpos($parameter, '>') === 0 && strpos($parameter, '>url ') === false) {
            $block = substr($parameter, 1, strlen($parameter) - 1);
            $result = @eval($block);
            
            if (is_null($result)) {
                $result = $this->current_block_return;
            }

            return $result;
        } else if (strpos($parameter, '>url ') === 0) {
            $url = substr($parameter, 5, strlen($parameter) - 5);
            $local = false;
            if (strpos($url, '(L) ') === 0) {
                $url = substr($url, 4, strlen($url) - 4);
                $local = true;
            }

            return Url::generateUrl($url, $local);
        }

        return $this->getParameter($parameter);
    }
}