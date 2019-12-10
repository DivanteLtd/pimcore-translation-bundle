<?php

namespace GoogleTranslateBundle;

use Pimcore\Extension\Bundle\AbstractPimcoreBundle;

/**
 * Class GoogleTranslateBundle
 * @package GoogleTranslateBundle
 *
 */
class GoogleTranslateBundle extends AbstractPimcoreBundle
{
    /**
     * @return array|\Pimcore\Routing\RouteReferenceInterface[]|string[]
     */
    public function getJsPaths()
    {
        return [
            '/bundles/googletranslate/js/pimcore/startup.js',
            '/bundles/googletranslate/js/pimcore/object/tags/input.js',
            '/bundles/googletranslate/js/pimcore/object/tags/wysiwyg.js',
            '/bundles/googletranslate/js/pimcore/object/elementservice.js',
            '/bundles/googletranslate/js/pimcore/provider/xmlproducts.js',
        ];
    }
}
