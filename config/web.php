<?php

return [
    /**
     * The protocol your site uses.
     * 
     * This is used by the templating system
     * to generate URL's to resources and pages.
     */
    'proto' => 'https',

    /**
     * The address to your site.
     * 
     * This is used by the templating system
     * to generate URL's to resources and pages.
     */
    'site' => 'curlit.tk',

    /**
     * Development / Production Toggle
     * 
     * When set to Development, URLs will not
     * use the same paths as they would in
     * production. The .htaccess file is 
     * ignored and instead the GET parameter 
     * is used for creating URLs
     */
    'in_dev' => true,
];