<?php

namespace OpenOrchestra\GroupBundle\Tests\EventListener;

use OpenOrchestra\Backoffice\Model\ModelGroupRoleInterface;
use OpenOrchestra\BaseBundle\Tests\AbstractTest\AbstractBaseTestCase;
use OpenOrchestra\GroupBundle\EventListener\UpdateNodeGroupRoleListener;
use OpenOrchestra\ModelInterface\Model\NodeInterface;
use Phake;

/**
 * Class UpdateNodeGroupRoleListenerTest
 */
class UpdateNodeGroupRoleListenerTest extends AbstractBaseTestCase
{
    protected $listener;
    protected $lifecycleEventArgs;
    protected $documentManager;
    protected $uow;
    protected $group;
    protected $nodeGroupRoleChild;
    protected $nodeClass = 'OpenOrchestra\ModelBundle\Document\Node';

    /**
     * setUp
     */
    public function setUp()
    {
        $this->lifecycleEventArgs = Phake::mock('Doctrine\ODM\MongoDB\Event\PreUpdateEventArgs');
        $this->documentManager = Phake::mock('Doctrine\ODM\MongoDB\DocumentManager');
        $this->uow = Phake::mock('Doctrine\ODM\MongoDB\UnitOfWork');

        Phake::when($this->lifecycleEventArgs)->getDocumentManager()->thenReturn($this->documentManager);
        Phake::when($this->documentManager)->getUnitOfWork()->thenReturn($this->uow);
        $nodeGroupRole = Phake::mock('OpenOrchestra\Backoffice\Model\ModelGroupRoleInterface');
        $childNode = Phake::mock('OpenOrchestra\ModelInterface\Model\NodeInterface');
        $childNode2 = Phake::mock('OpenOrchestra\ModelInterface\Model\NodeInterface');
        $this->group = Phake::mock('OpenOrchestra\Backoffice\Model\GroupInterface');
        $site = Phake::mock('OpenOrchestra\ModelInterface\Model\SiteInterface');
        $nodeRepository = Phake::mock('OpenOrchestra\ModelInterface\Repository\NodeRepositoryInterface');
        $this->nodeGroupRoleChild = Phake::mock('OpenOrchestra\Backoffice\Model\ModelGroupRoleInterface');

        Phake::when($nodeGroupRole)->getType()->thenReturn(NodeInterface::GROUP_ROLE_TYPE);
        Phake::when($this->lifecycleEventArgs)->getDocument()->thenReturn($nodeGroupRole);
        Phake::when($this->uow)->getParentAssociation($nodeGroupRole)->thenReturn(array(array(), $this->group));
        Phake::when($this->group)->getSite()->thenReturn($site);
        Phake::when($this->documentManager)->getRepository(Phake::anyParameters())->thenReturn($nodeRepository);
        $metadata = Phake::mock('Doctrine\ODM\MongoDB\Mapping\ClassMetadata');
        Phake::when($this->documentManager)->getClassMetadata(Phake::anyParameters())->thenReturn($metadata);
        Phake::when($nodeRepository)->findByParent(Phake::anyParameters())->thenReturn(array($childNode, $childNode2));
        Phake::when($childNode)->getNodeType()->thenReturn('page');
        Phake::when($childNode2)->getNodeType()->thenReturn('error');
        Phake::when($this->lifecycleEventArgs)->hasChangedField(Phake::anyParameters())->thenReturn(true);

        $this->listener = new UpdateNodeGroupRoleListener($this->nodeClass);
    }

    /**
     * @param string  $childAccessType
     * @param integer $countUpdateChildGroupRole
     *
     * @dataProvider provideNodeGroupRoleAccess
     */
    public function testPreUpdate($childAccessType, $countUpdateChildGroupRole)
    {
        Phake::when($this->nodeGroupRoleChild)->getAccessType()->thenReturn($childAccessType);
        Phake::when($this->group)->getModelGroupRoleByTypeAndIdAndRole(Phake::anyParameters())->thenReturn($this->nodeGroupRoleChild);

        $this->listener->preUpdate($this->lifecycleEventArgs);

        Phake::verify($this->nodeGroupRoleChild, Phake::times($countUpdateChildGroupRole))->setGranted(Phake::anyParameters());
    }

    /**
     * @return array
     */
    public function provideNodeGroupRoleAccess()
    {
        return array(
            array(ModelGroupRoleInterface::ACCESS_DENIED, 0),
            array(ModelGroupRoleInterface::ACCESS_GRANTED, 0),
            array(ModelGroupRoleInterface::ACCESS_INHERIT, 1),
        );
    }

    /**
     * Test Pre Update Exception
     */
    public function testPreUpdateException()
    {
        Phake::when($this->group)->getModelGroupRoleByTypeAndIdAndRole(Phake::anyParameters())->thenReturn(null);
        $this->setExpectedException('OpenOrchestra\GroupBundle\Exception\NodeGroupRoleNotFoundException');

        $this->listener->preUpdate($this->lifecycleEventArgs);

    }

    /**
     * test if the method is callable
     */
    public function testMethodPrePersistCallable()
    {
        $this->assertTrue(method_exists($this->listener, 'preUpdate'));
    }
}
