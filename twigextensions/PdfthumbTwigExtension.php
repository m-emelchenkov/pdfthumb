<?php
namespace Craft;

use Twig_Extension;
use Twig_Filter_Method;

class PdfthumbTwigExtension extends Twig_Extension
{
	public function getName()
	{
		return 'pdfthumb';
	}
	
	public function getGlobals()
	{
		return array(
			'pdfthumb' => craft()->pdfthumb
		);
	}
}
?>
