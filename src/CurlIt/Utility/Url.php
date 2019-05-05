<?php

namespace CurlIt\Utility;

class Url
{
    /**
     * Generate a URL based on the configuration.
     * 
     * @param string $part  The URL part to append.
     * @param bool   $loacl If set to true, the domain
     *                      name and protocol will be excluded.
     * 
     * @return string
     */
    public static function generateUrl($part, $local = false)
    {
        $config = include '../config/web.php';
        $start = '/';
        if ($config['in_dev']) {
            $start = '/?_routed_ep_=';
        }

        return ((! $local) ? $config['proto'].'://'.$config['site'] : '') . $start . $part;
    }
}