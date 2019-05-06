<?php

namespace CurlIt\Content\Pages;

use CurlIt\Templating\PageTemplate as Page;
use CurlIt\Utility\Base;
use CurlIt\Utility\Url;
use CurlIt\Data\SavedCurl as Curl;

class Main extends Page
{
    /**
     * Local curl instance used for sharing curls.
     * 
     * @var \CurlIt\Data\SavedCurl
     */
    protected $localCurl;

    /**
     * If set to true, the URL for the loaded CURL
     * will not be used for new saves.
     * 
     * @var bool
     */
    private $duplicate = false;

    /**
     * Construct the page.
     * 
     * @param string $page
     */
    public function __construct()
    {
        parent::__construct('main');
    }

    /**
     * Called immediately after creation in
     * order for the page to load any nessecary
     * data.
     * 
     * @param string $path
     */
    public function prepare($path)
    {
        if (! empty($path) && strpos($path, '/') === false) {
            $this->localCurl = Curl::load($path);

            if (isset($_GET['duplicate'])) {
                $this->duplicate = true;
            }
        }
    }

    /**
     * Retrieve the data for a parameter.
     * 
     * @param string $key The key for the parameter.
     * 
     * @return string
     */
    public function getParameter($key)
    {
        if ($key == 'curlit_url_value') {
            return (!is_null($this->localCurl)) ? $this->localCurl->address : '';
        } 
        
        else if ($key == 'curlit_payload_value') {
            return (!is_null($this->localCurl)) ? $this->localCurl->payload : '';
        } 
        
        else if ($key == 'curlit_payload_value_escaped') {
            return (!is_null($this->localCurl)) ? str_replace("\n", "\\n", str_replace("\r\n", '\\r\\n', $this->localCurl->payload)) : '';
        } 
        
        else if ($key == 'curlit_basic_http_user') {
            return (!is_null($this->localCurl)) ? $this->localCurl->http_user : '';
        } 
        
        else if ($key == 'curlit_basic_http_pass') {
            return (!is_null($this->localCurl)) ? $this->localCurl->http_password : '';
        } 
        
        else if ($key == 'curlit_inseucre_checked') {
            return (!is_null($this->localCurl)) ? ($this->localCurl->insecure ? 'checked' : '') : '';
        } 
        
        else if ($key == 'curlit_session_id') {
            if ($this->duplicate || is_null($this->localCurl)) {
                return 'Click to generate URL!';
            }

            return Curl::curlIdToUrlId($this->localCurl->id);
        }

        else if ($key == 'call_set_url') {
            if ($this->duplicate || is_null($this->localCurl)) {
                return '';
            } else {
                return 'setGeneratedUrl("'.Url::generateUrl(Curl::curlIdToUrlId($this->localCurl->id)).'");';
            }
        }

        else if ($key == 'url_loaded') {
            if ($this->duplicate || is_null($this->localCurl)) {
                return 'false';
            } else {
                return 'true';
            }
        }
        
        else if ($key == 'curlit_session_id_js') {
            if ($this->duplicate || is_null($this->localCurl)) {
                return 'null';
            }

            return "'".Curl::curlIdToUrlId($this->localCurl->id)."'";
        } 
        
        else if ($key == 'curlit_current_parameters') {
            if (is_null($this->localCurl) || ($this->localCurl->parameters == null || $this->localCurl->parameters == 'null')) {
                return '[]';
            }

            return $this->localCurl->parameters;
        } 
        
        else if ($key == 'curlit_current_headers') {
            if (is_null($this->localCurl) || ($this->localCurl->headers == null || $this->localCurl->headers == 'null')) {
                return '[]';
            }

            return stripslashes($this->localCurl->headers);
        }

        else if ($key == 'in_dev') {
            $config = include '../config/web.php';
            return ($config['in_dev']) ? 'true' : 'false';
        }

        return null;
    }

    /**
     * Check if a string is valid JSON.
     * 
     * @param string $json
     * 
     * @return bool
     */
    private function isJson($json)
    {
        $parsed = json_decode($json);

        return $parsed && $json != $parsed;
    }

    /**
     * Format a JSON string.
     * 
     * @param string $json
     * 
     * @return string
     */
    private function formatJson($json)
    {
        return json_encode(json_decode($json, true), JSON_PRETTY_PRINT);
    }
}