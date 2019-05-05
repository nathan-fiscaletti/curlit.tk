<?php

namespace CurlIt\Data;

use \MySqliWrapper\Model;
use \CurlIt\Utility\Base;

class SavedCurl extends Model
{
    /**
     * The connection for the Model.
     * 
     * @var string
     */
    protected $connection = 'main';

    /**
     * The table for the Model.
     * 
     * @var string
     */
    protected $table = 'curls';

    /**
     * The name of the ID column.
     *
     * @var mixed
     */
    public $id_column = 'id';

    /**
     * Retrieve the URL ID for this SavedCurl.
     * 
     * @return string
     */
    public function urlId()
    {
        return self::curlIdToUrlId($this->id);
    }

    /**
     * Retrieve the URL for this saved curl.
     * 
     * @return string
     */
    public function url()
    {
        $config = include '../config/web.php';
        return $config['proto'].'://'.str_replace('/', '', $config['site']).'/'.$this->urlId();
    }

    /**
     * Load a new SavedCurl based on a URL ID (base-19)
     * 
     * @param strsing $urlId
     * 
     * @return \CurlIt|Data\SavedCurl
     */
    public static function load($urlId)
    {
        $id = self::urlIdToCurlId($urlId);

        return self::select()->where('id', '=', $id)->get();
    }

    /**
     * Convert a CURL ID to a URL ID.
     * 
     * @param int $curlId
     * 
     * @return string
     */
    public static function curlIdToUrlId($curlId)
    {
        return strtolower((new Base(19))->parse($curlId));
    }

    /**
     * Convert a URL ID to a CURL ID.
     * 
     * @param string $urlId
     * 
     * @return int
     */
    public static function urlIdtoCurlId($urlId)
    {
        return (new Base(19))->toBase10($urlId);
    }
}