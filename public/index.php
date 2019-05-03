<?php

chdir('../');
include './vendor/autoload.php';

use \CurlIt\Content\Page;
use \CurlIt\Content\PageController;

// Create the PageController using the
// route property from the .htaccess file.
$pageController = new PageController(
    $_GET['_routed_ep_']
);

// Load the Default Page and add any additional pages.
$pageController
->setDefaultPage(
    new \CurlIt\Content\Pages\Main()
)
->addPage(
    'contact',
    new \CurlIt\Content\Pages\Contact()
);

// Display the current page.
echo $pageController->output();

?>
