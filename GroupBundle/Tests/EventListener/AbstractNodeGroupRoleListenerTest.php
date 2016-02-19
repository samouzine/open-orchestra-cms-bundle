<?php

namespace OpenOrchestra\GroupBundle\Tests\EventListener;

use OpenOrchestra\Backoffice\Model\GroupInterface;
use OpenOrchestra\BaseBundle\Tests\AbstractTest\AbstractBaseTestCase;
use Phake;

/**
 * Class AbstractNodeGroupRoleListenerTest
 */
abstract class AbstractNodeGroupRoleListenerTest extends AbstractBaseTestCase
{
    protected $lifecycleEventArgs;
    protected $container;
    protected $nodesRoles = array("access_node", "access_update_node");
    protected $nodeGroupRoleClass = 'OpenOrchestra\GroupBundle\Document\ModelGroupRole';

    /**
     * setUp
     */
    public function setUp()
    {
        $this->lifecycleEventArgs = Phake::mock('Doctrine\ODM\MongoDB\Event\LifecycleEventArgs');
        $this->container = Phake::mock('Symfony\Component\DependencyInjection\Container');
        $roleCollector = Phake::mock('OpenOrchestra\Backoffice\Collector\BackofficeRoleCollector');
        Phake::when($this->container)->get('open_orchestra_backoffice.collector.backoffice_role')->thenReturn($roleCollector);
        Phake::when($roleCollector)->getRolesByType(Phake::anyParameters())->thenReturn($this->nodesRoles);
    }

    /**
     * @return GroupInterface
     */
    protected function createMockGroup(){
        $group = Phake::mock('OpenOrchestra\Backoffice\Model\GroupInterface');
        $parentNodeGroupRole = Phake::mock('OpenOrchestra\Backoffice\Model\ModelGroupRoleInterface');
        phake::when($parentNodeGroupRole)->isGranted()->thenReturn(true);
        phake::when($group)->getModelGroupRoleByTypeAndIdAndRole(Phake::anyParameters())->thenReturn($parentNodeGroupRole);
        phake::when($group)->hasModelGroupRoleByTypeAndIdAndRole(Phake::anyParameters())->thenReturn(false);

        $site = Phake::mock('OpenOrchestra\ModelInterface\Model\SiteInterface');
        Phake::when($group)->getSite()->thenReturn($site);

        return $group;
    }
}
