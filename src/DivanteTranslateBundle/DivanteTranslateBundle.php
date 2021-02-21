<?php
/**
 * @author Piotr Rugała <piotr@isedo.pl>
 * @copyright Copyright (c) 2021 Divante Ltd. (https://divante.co)
 */

declare(strict_types=1);

namespace DivanteTranslateBundle;

use Pimcore\Extension\Bundle\AbstractPimcoreBundle;

final class DivanteTranslateBundle extends AbstractPimcoreBundle
{
    public function getJsPaths(): array
    {
        return [
            '/bundles/googletranslate/js/pimcore/startup.js',
            '/bundles/googletranslate/js/pimcore/object/tags/input.js',
            '/bundles/googletranslate/js/pimcore/object/tags/wysiwyg.js',
            '/bundles/googletranslate/js/pimcore/object/elementservice.js',
        ];
    }
}
