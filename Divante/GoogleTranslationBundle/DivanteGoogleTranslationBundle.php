<?php

namespace Divante\GoogleTranslationBundle;

use Pimcore\Extension\Bundle\AbstractPimcoreBundle;

/**
 * Class DivanteGoogleTranslationBundle
 * @package Divante\GoogleTranslationBundle
 *
 */
class DivanteGoogleTranslationBundle extends AbstractPimcoreBundle
{
    /**
     * @return array|\Pimcore\Routing\RouteReferenceInterface[]|string[]
     */
    public function getJsPaths()
    {
        return [
            '/bundles/divantegoogletranslation/js/pimcore/startup.js',
            '/bundles/divantegoogletranslation/js/pimcore/object/tags/input.js',
            '/bundles/divantegoogletranslation/js/pimcore/object/tags/wysiwyg.js',
            '/bundles/divantegoogletranslation/js/pimcore/object/elementservice.js',
            '/bundles/divantegoogletranslation/js/pimcore/provider/xmlproducts.js',
        ];
    }
}
