<?php

namespace CurlIt\Content;

use CurlIt\Utility\Url;
use Curlit\Templating\PageTemplate as Page;

class PageController
{
    /**
     * List of loaded pages.
     * 
     * @var array[\CurlIt\Templating\TemplatParser]
     */
    private $pages = [];

    /**
     * URLs that should be ignored.
     * 
     * @var array[string]
     */
    private $ignorable = [];

    /**
     * URLs that should be forced.
     * 
     * @var array[string]
     */
    private $forced = [];

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
        if (substr($this->route, strlen($this->route) - 3) == 'css') {
            header('Content-Type: text/css');
        } else if (substr($this->route, strlen($this->route) - 2) == 'js') {
            header('Content-Type: application/json');
        }

        $forced = false;
        foreach ($this->forced as $forcable) {
            if (strpos($this->route, $forcable) !== false) {
                $forced = true;
                break;
            }
        }
        
        if (! $forced) {
            foreach ($this->ignorable as $ignorable) {
                if (strpos($this->route, $ignorable) !== false) {
                    return file_get_contents('./'.$this->route);
                }
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

        if ($page instanceof Page) {
            $page->prepare($this->route);
        }

        return $page->parse();
    }

    /**
     * Set a route that will always be loaded
     * via templating, even if it's in the
     * ignorable group.
     * 
     * @param string $route
     * 
     * @return \CurlIt\Content\PageController
     */
    public function setForced($route)
    {
        $this->forced[] = $route;

        return $this;
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