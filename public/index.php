<?php

include '../vendor/autoload.php';

use \CurlIt\Content\Page;
use \CurlIt\Content\PageController;

use MySqliWrapper\DataBase;

// Load Databases
$config = include '../config/web.php';
foreach ($config['databases'] as $database) {
    Database::register($database);
}


// Create the PageController using the
// route property from the .htaccess file.
$pageController = new PageController(
    $_GET['_routed_ep_']
);

$pageController

// Load the default page
->setDefaultPage(
    new \CurlIt\Content\Pages\Main()
)

// Load any other pages.
->addPage(
    'contact',
    new \CurlIt\Content\Pages\Contact()
)

// AJAX Handler for Generating URLs
->addPage(
    'ajax/generateurl',
    new \CurlIt\Content\Pages\GenerateURL()
)

// AJAX Handler for Submitting Requests using PHP
->AddPage(
    'ajax/submitrequest',
    new \CurlIt\Content\Pages\SubmitRequest()
)

// Override the script.js route so that it
// is parsed as a template.
->addPage(
    'assets/js/script.js',
    new class extends \CurlIt\Templating\FileTemplate {
        public function __construct()
        {
            parent::__construct('assets/js/script.js');
        }   

        public function getParameter($key)
        {
            /* Not Implemented */
        }
    }
)

// Specifically force this route to
// go through the template parsing
// even though it is within the
// ignored routes.
->setForced('assets/js/script.js')

// Ignore specific routes so that
// they aren't blocked by the page
// routing. (js, css, etc)
->setIgnorable('assets/');

// Display the current page.
echo $pageController->output();