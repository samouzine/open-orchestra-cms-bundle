<?php

namespace OpenOrchestra\Backoffice\NavigationPanel\Strategies;

use OpenOrchestra\BaseBundle\Context\CurrentSiteIdInterface;
use OpenOrchestra\ModelInterface\Model\NodeInterface;
use OpenOrchestra\ModelInterface\Repository\NodeRepositoryInterface;

/**
 * Class GeneralNodesPanel
 */
class GeneralNodesPanelStrategy extends AbstractNavigationPanelStrategy
{
    /**
     *  @deprecated use the ROLE_ACCESS_TREE_GENERAL_NODE instead, will be removed in 1.2.0
     */
    const ROLE_ACCESS_GENERAL_NODE = 'ROLE_ACCESS_GENERAL_NODE';
    const ROLE_ACCESS_TREE_GENERAL_NODE = 'ROLE_ACCESS_TREE_GENERAL_NODE';
    const ROLE_ACCESS_UPDATE_GENERAL_NODE = 'ROLE_ACCESS_UPDATE_GENERAL_NODE';

    /**
     * @var NodeRepositoryInterface
     */
    protected $nodeRepository;

    /**
     * @var CurrentSiteIdInterface
     */
    protected $currentSiteManager;

    /**
     * @param NodeRepositoryInterface $nodeRepository
     * @param CurrentSiteIdInterface  $currentSiteManager
     * @param string                  $parent
     * @param int                     $weight
     */
    public function __construct(NodeRepositoryInterface $nodeRepository, CurrentSiteIdInterface $currentSiteManager, $parent, $weight)
    {
        parent::__construct('generale_node', self::ROLE_ACCESS_TREE_GENERAL_NODE, $weight, $parent);
        $this->nodeRepository = $nodeRepository;
        $this->currentSiteManager = $currentSiteManager;
    }

    /**
     * @return string
     */
    public function show()
    {
        $siteId = $this->currentSiteManager->getCurrentSiteId();
        $nodes = $this->nodeRepository->findLastVersionByType($siteId, NodeInterface::TYPE_TRANSVERSE);

        return $this->render(
            '/open-orchestra/backoffice-bundle/BackOffice/Include/NavigationPanel/Menu/Editorial/generalNodes.html.twig',
            array(
                'nodes' => $nodes
            )
        );
    }
}
