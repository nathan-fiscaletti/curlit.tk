<?php

namespace CurlIt\Content;

class PageController
{
    /**
     * List of loaded pages.
     * 
     * @var array[\CurlIt\Content\Page]
     */
    private $pages = [];

    /**
     * URLs that should be ignored.
     * 
     * @var array[string]
     */
    private $ignorable = [];

    /**
     * The route found at run time.
     * 
     * @var string
     */
    private $route = null;

    /**
     * Construct the page controller with a route
     * determined at run time.
     * 
     * @param string $route
     */
    public function __construct($route)
    {
        $this->route = $route;
    }

    /**
     * Parse the proper page content based on the
     * route provided at run time.
     * 
     * @return string
     */
    public function output()
    {
        foreach ($this->ignorable as $ignorable) {
            if (strpos($this->route, $ignorable) !== false) {
                return file_get_contents('./'.$this->route);
            }
        }

        if (! array_key_exists($this->route, $this->pages)) {
            if (! array_key_exists('default', $this->pages)) {
                throw new Exception('No default route set.');
            }

            $page = $this->pages['default'];
        } else {
            $page = $this->pages[$this->route];
        }

        $page->prepare($this->route);
        return $page->output();
    }

    /**
     * Ignore a route and instead serve it's direct content.
     * 
     * @param $route
     * 
     * @return \CurlIt\Content\PageController
     */
    public function setIgnorable($route)
    {
        $this->ignorable[] = $route;

        return $this;
    }

    /**
     * Set the default page when no page is found
     * at the corresponding route.
     * 
     * @param \CurlIt\Content\Page
     * 
     * @return \CurlIt\Content\PageController
     */
    public function setDefaultPage($page)
    {
        $this->pages['default'] = $page;

        return $this;
    }

    /**
     * Add a page at a specified route.
     * 
     * @param string               $route
     * @param \CurlIt\Content\Page $page
     * 
     * @return \CurlIt\Content\PageController
     */
    public function addPage($route, $page)
    {
        $this->pages[$route] = $page;

        return $this;
    }
}