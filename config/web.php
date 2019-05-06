<?php

return [
    /**
     * The protocol your site uses.
     * 
     * This is used by the templating system
     * to generate URL's to resources and pages.
     */
    'proto' => 'http',

    /**
     * The address to your site.
     * 
     * This is used by the templating system
     * to generate URL's to resources and pages.
     */
    'site' => '192.168.0.126',

    /**
     * Development / Production Toggle
     * 
     * When set to Development, URLs will not
     * use the same paths as they would in
     * production. The .htaccess file is 
     * ignored and instead the GET parameter 
     * is used for creating URLs
     */
    'in_dev' => false,

    /**
     * Database configuration.
     * 
     * Each database as per the specs of
     * MySqliWrapper found below:
     * http://tiny.cc/mysqliconndoc
     */
    'databases' => [
        [
            // The name of the connection. This will be
            // used later within your Models and QueryBuilders 
            // to determine which Connection to use.
            'name' => 'curlit', 

            // The rest of the configuration options.
            // All of these are required.
            'host' => '127.0.0.1',
            'username' => 'root',
            'password' => 'password',
            'database' => 'curlit',
            'port' => 3306,
            'charset' => 'utf8'
        ],
    ]
];