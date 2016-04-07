<?php

namespace OpenOrchestra\BackofficeBundle\DependencyInjection\Compiler;

use OpenOrchestra\BaseBundle\DependencyInjection\Compiler\AbstractTaggedCompiler;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class RemoveTrashcanEntityCompilerPass
 */
class RemoveTrashcanEntityCompilerPass extends AbstractTaggedCompiler implements CompilerPassInterface
{
    /**
     * You can modify the container here before it is dumped to PHP code.
     *
     * @param ContainerBuilder $container
     *
     * @api
     */
    public function process(ContainerBuilder $container)
    {
        $managerName = 'open_orchestra_backoffice.remove_trashcan_entity.manager';
        $tagName = 'open_orchestra_backoffice.remove_trashcan_entity.strategy';

        $this->addStrategyToManager($container, $managerName, $tagName);
    }
}