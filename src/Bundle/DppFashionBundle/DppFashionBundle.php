<?php
/**
 * Pimcore DPP Fashion Bundle
 * Digital Product Passport for Fashion/Textiles
 */

namespace Pimcore\Bundle\DppFashionBundle;

use Pimcore\Bundle\AdminBundle\Support\PimcoreAdminBundle;
use Pimcore\Extension\Bundle\AbstractPimcoreBundle;

class DppFashionBundle extends AbstractPimcoreBundle
{
    public function getJsPaths(): array
    {
        return [
            '/bundles/dppfashion/js/pimcore/startup.js'
        ];
    }

    public function getCssPaths(): array
    {
        return [
            '/bundles/dppfashion/css/admin.css'
        ];
    }

    public function getPath(): string
    {
        return dirname(__DIR__);
    }

    public function getInstaller(): ?\Pimcore\Extension\Bundle\Installer\InstallerInterface
    {
        return new Installer();
    }
}
