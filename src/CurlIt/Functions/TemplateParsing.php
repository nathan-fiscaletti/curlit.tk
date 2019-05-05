<?php

if (! function_exists('tl_out')) {
    function tl_out($output)
    {
        if (\CurlIt\Templating\TemplateParser::$current_parser != null) {
            \CurlIt\Templating\TemplateParser::$current_parser->addOutputForCurrentBlock($output);
        }
    }
}