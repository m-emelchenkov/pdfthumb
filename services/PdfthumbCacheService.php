<?php
namespace Craft;

class PdfthumbCacheServiceStructure
{
    public $url;
    public $type;
    public $path;
    public $extra;
}

/**
 * Algorithm:
 * 1. Calculate MD5 of concatenated paths of all files and its modification dates.
 * 2. Put or get the cached content's file if exists.
 */
class PdfthumbCacheService extends BaseApplicationComponent
{
    private $_path, $_url_path;

    /**
     * Set cache path
     */
    function __construct($path)
    {
        $this->_path = rtrim($path, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR; // Add trailing slash if not present
        $this->_url_path = str_replace($_SERVER['DOCUMENT_ROOT'], '', $this->_path);
    }

    public function put($content, $element)
    {
        // All elements have the same type
        $filename = 'pdfthumb_' . $this->_calcHash($element) . '.' . $element->type;
        $path = $this->_path . $filename;
        $url = $this->_url_path . $filename;
        
        // Save cached content to file
        file_put_contents($path, $content);
        
        return $url;
    }
    
    public function get($element)
    {
        $filename = 'pdfthumb_' . $this->_calcHash($element) . '.' . $element->type;
        $path = $this->_path . $filename;
        $url = $this->_url_path . $filename;

        return file_exists($path) ? $url : FALSE;
    }
    
    /**
     * Calculate hashsums of source files by algorithm.
     */
    private function _calcHash($element)
    {
        // Calculate MD5
        $cache_id = "";
        $mod_time = filemtime($element->path);
        $cache_id .= $element->path . $mod_time . $element->extra;
        //$hash = md5($cache_id);
        $hash = rtrim($this->_base64_safe(base64_encode(hash('md5', $cache_id, true))), '=');
        
        return $hash;
    }
    
    /**
     * URL-safe variant of base64 encoding
     */
    private function _base64_safe($base64) {
        return strtr($base64, '+/', '-_');
    }
}
