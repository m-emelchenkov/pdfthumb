<?php
namespace Craft;

class PdfthumbPlugin extends BasePlugin
{
    function getName()
    {
         return Craft::t('PDFThumb');
    }

    function getVersion()
    {
        return '1.1';
    }

    function getDeveloper()
    {
        return 'Mikhail Emelchenkov';
    }

    function getDeveloperUrl()
    {
        return 'https://www.Emelchenkov.pro';
    }

	/**
	 * Register Twig extension
	 */
	public function addTwigExtension()
	{
		Craft::import('plugins.pdfthumb.twigextensions.PdfthumbTwigExtension');

		return new PdfthumbTwigExtension();
	}

    /**
     * Register cache path
     */
    public function registerCachePaths()
    {
        return array(
            $_SERVER['DOCUMENT_ROOT'] . $this->getSettings()['cachePath'] => Craft::t('PDFThumb images')
        );
    }

    /**
     * Register settings
     */
    protected function defineSettings()
    {
        return array(
            'cachePath' => array(AttributeType::String, 'default' => join(DIRECTORY_SEPARATOR, array('', 'resources', 'cache')))
        );
    }
    public function getSettingsHtml()
    {
        return craft()->templates->render('pdfthumb/settings', array(
            'settings' => $this->getSettings()
        ));
    }
}


