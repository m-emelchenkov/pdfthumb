<?php
namespace Craft;
use Imagick;

require_once __DIR__ . '/PdfthumbCacheService.php';

class PdfthumbService extends BaseApplicationComponent
{
	public function get($url, $params = [])
	{
        // Configure cache
        $settings = craft()->plugins->getPlugin('pdfthumb')->getSettings();
        $cache = new PdfthumbCacheService($_SERVER['DOCUMENT_ROOT'] . $settings['cachePath']);
        
        $element = new PdfthumbCacheServiceStructure();
        $element->url = $url;
        $element->type = 'jpg';
        $element->extra = print_r($params, true);
        $this->_populateFSPath($element);

        // Ask for cached version
        $cacheUrl = $cache->get($element);
        if (!$cacheUrl) {
            $thumb = new Imagick();
            $thumb->setResolution(300, 300);
            $thumb->readImage($element->path . '[0]');  // Read only first page
            $thumb = $thumb->mergeImageLayers(Imagick::LAYERMETHOD_FLATTEN);
            $thumb->setImageFormat('jpg');  // Output format
            $thumb->setImageCompression(Imagick::COMPRESSION_JPEG);
            $thumb->setImageCompressionQuality(isset($params['quality']) ? $params['quality'] : 60);
            if (isset($params['width']) || isset($params['height'])) {
                $thumb->resizeImage(isset($params['width']) ? $params['width'] : 0, 
                                    isset($params['height']) ? $params['height'] : 0,
                                    Imagick::FILTER_UNDEFINED,
                                    1
                );
            }
            // Put result in the cache, get cache filename as a result
            $cacheUrl = $cache->put($thumb, $element);
        }
        
        return $cacheUrl;
	}
    
    /**
	 * Get absolute file path by its URL.
	 *
	 * Root of these files is DOCUMENT_ROOT directory.
	 */
    private function _populateFSPath($element) {
        $element->path = join(DIRECTORY_SEPARATOR, array($_SERVER['DOCUMENT_ROOT'], $element->url));
    }
}
?>
