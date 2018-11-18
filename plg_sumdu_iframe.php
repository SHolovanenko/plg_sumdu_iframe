<?php
defined( '_JEXEC' ) or die;

class plgContentPlg_sumdu_iframe extends JPlugin
{
	/**
	 * Load the language file on instantiation. Note this is only available in Joomla 3.1 and higher.
	 * If you want to support 3.0 series you must override the constructor
	 *
	 * @var    boolean
	 * @since  3.1
	 */
    protected $autoloadLanguage = true;

	function onContentPrepare($context, &$article, &$params, $limitstart = 0) {
        $pregIframe = '/(\{iframe\s?src\=\"(.+?)\"\s?(width\=\"(.+?)\")?\s?(height\=\"(.+?)\")?\})(\{\/iframe\})/s';
        $iframeWindow = [];
        while (preg_match($pregIframe, $article->text, $segments)) {
            $url = $segments[2];
            $width = $segments[4];
            $height = $segments[6];

            if (!isset($width) || empty($width)) {
                $width = $this->params->get('width');
            }
            
            if (!isset($height) || empty($height)) {
                $height = $this->params->get('height');
            } 

            $additionalParams = $this->params->get('additional_params');
            if (empty($additionalParams)) {
                $additionalParams = '';
            }

            $preparedText = '<iframe width="'. $width .'" height="'. $height .'" src="'. $url .'" frameborder="0" '. $additionalParams .' allowfullscreen></iframe>';
            $article->text = str_replace($segments[0], $preparedText, $article->text);
        }
        
		return true;
    }
}
?>
