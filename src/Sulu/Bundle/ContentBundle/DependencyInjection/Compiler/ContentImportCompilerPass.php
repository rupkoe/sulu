<?php
/*
 * This file is part of the Sulu.
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\ContentBundle\DependencyInjection\Compiler;

use Sulu\Bundle\CoreBundle\DependencyInjection\Compiler\RegisterContentTypesCompilerPass;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Collects all export able content types.
 */
class ContentExportCompilerPass implements CompilerPassInterface
{
    const CONTENT_IMPORT_SERVICE_ID = 'sulu_content.import.manager';
    const IMPORT_SERVICE_TAG = 'sulu.content.import.service';

    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition(self::CONTENT_IMPORT_SERVICE_ID)) {
            return;
        }

        $definition = $container->getDefinition(self::CONTENT_IMPORT_SERVICE_ID);
        $taggedServices = $container->findTaggedServiceIds(self::IMPORT_SERVICE_TAG);
        foreach ($taggedServices as $id => $tagAttributes) {
            $importServiceDefinition = $container->getDefinition($id);
            foreach ($tagAttributes as $attributes) {
                $format = $attributes['format'];
                $definition->addMethodCall('add', [$importServiceDefinition, $format]);
            }
        }
    }
}