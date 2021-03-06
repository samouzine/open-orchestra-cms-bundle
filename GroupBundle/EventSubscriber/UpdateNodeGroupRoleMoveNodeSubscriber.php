<?php

namespace OpenOrchestra\GroupBundle\EventSubscriber;

use Doctrine\Common\Persistence\ObjectManager;
use OpenOrchestra\Backoffice\Collector\BackofficeRoleCollector;
use OpenOrchestra\Backoffice\Model\ModelGroupRoleInterface;
use OpenOrchestra\Backoffice\Model\GroupInterface;
use OpenOrchestra\Backoffice\Repository\GroupRepositoryInterface;
use OpenOrchestra\GroupBundle\Exception\NodeGroupRoleNotFoundException;
use OpenOrchestra\ModelInterface\Event\NodeEvent;
use OpenOrchestra\ModelInterface\Model\NodeInterface;
use OpenOrchestra\ModelInterface\NodeEvents;
use OpenOrchestra\ModelInterface\Repository\NodeRepositoryInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class UpdateNodeGroupRoleMoveNodeSubscriber
 */
class UpdateNodeGroupRoleMoveNodeSubscriber implements EventSubscriberInterface
{
    protected $groupRepository;
    protected $nodeRepository;
    protected $roleCollector;
    protected $objectManager;

    /**
     * @param GroupRepositoryInterface $groupRepository
     * @param NodeRepositoryInterface  $nodeRepository
     * @param BackofficeRoleCollector  $roleCollector
     * @param ObjectManager            $objectManager
     */
    public function __construct(
        GroupRepositoryInterface $groupRepository,
        NodeRepositoryInterface $nodeRepository,
        BackofficeRoleCollector $roleCollector,
        ObjectManager $objectManager
    ) {
        $this->groupRepository = $groupRepository;
        $this->nodeRepository = $nodeRepository;
        $this->roleCollector = $roleCollector;
        $this->objectManager = $objectManager;
    }

    /**
     * @param NodeEvent $event
     */
    public function updateAccessNodeGroupRole(NodeEvent $event)
    {
        $groups = $this->groupRepository->findAllWithSite();
        $node = $event->getNode();
        $nodeRole = $this->roleCollector->getRolesByType('(?<!error_)node');
        $this->updateNodeGroupRoleTree($node, $nodeRole, $groups);
    }

    /**
     * @param NodeInterface $node
     * @param array         $nodeRole
     * @param array         $groups
     *
     * @throws NodeGroupRoleNotFoundException
     */
    protected function updateNodeGroupRoleTree(NodeInterface $node, array $nodeRole, array $groups)
    {
        /** @var GroupInterface $group */
        foreach ($groups as $group) {
            if ($node->getSiteId() === $group->getSite()->getSiteId()) {

                foreach ($nodeRole as $role => $translation) {
                    $nodeGroupRole = $group->getModelGroupRoleByTypeAndIdAndRole(
                        NodeInterface::GROUP_ROLE_TYPE,
                        $node->getNodeId(),
                        $role
                    );

                    if (null === $nodeGroupRole) {
                        throw new NodeGroupRoleNotFoundException($role, $node->getNodeId(), $group->getName());
                    }

                    if (ModelGroupRoleInterface::ACCESS_INHERIT === $nodeGroupRole->getAccessType()) {
                        $nodeGroupRoleParent = $group->getModelGroupRoleByTypeAndIdAndRole(
                            NodeInterface::GROUP_ROLE_TYPE,
                            $node->getParentId(),
                            $role
                        );

                        if (null === $nodeGroupRoleParent) {
                            throw new NodeGroupRoleNotFoundException($role, $node->getNodeId(), $group->getName());
                        }

                        $accessParent = $nodeGroupRoleParent->isGranted();

                        if ($accessParent !== $nodeGroupRole->isGranted()) {
                            $nodeGroupRole->setGranted($accessParent);
                            $this->objectManager->persist($group);
                            $this->objectManager->flush();
                        }
                    }
                }
            }
        }

        $children = $this->nodeRepository->findByParent($node->getNodeId(), $node->getSiteId());
        foreach ($children as $child) {
            $this->updateNodeGroupRoleTree($child, $nodeRole, $groups);
        }
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            NodeEvents::PATH_UPDATED => 'updateAccessNodeGroupRole',
        );
    }
}
