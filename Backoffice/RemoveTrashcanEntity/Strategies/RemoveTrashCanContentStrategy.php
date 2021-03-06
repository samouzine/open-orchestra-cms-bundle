<?php

namespace OpenOrchestra\Backoffice\RemoveTrashcanEntity\Strategies;

use Doctrine\Common\Persistence\ObjectManager;
use OpenOrchestra\Backoffice\RemoveTrashcanEntity\RemoveTrashCanEntityInterface;
use OpenOrchestra\ModelInterface\Event\TrashcanEvent;
use OpenOrchestra\ModelInterface\Model\ContentInterface;
use OpenOrchestra\ModelInterface\Repository\ContentRepositoryInterface;
use OpenOrchestra\ModelInterface\TrashcanEvents;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class RemoveTrashCanContentStrategy
 */
class RemoveTrashCanContentStrategy implements RemoveTrashCanEntityInterface
{
    protected $eventDispatcher;
    protected $contentRepository;
    protected $objectManager;

    /**
     * @param ContentRepositoryInterface $contentRepository
     * @param EventDispatcherInterface   $eventDispatcher
     * @param ObjectManager              $objectManager
     */
    public function __construct(
        ContentRepositoryInterface $contentRepository,
        EventDispatcherInterface $eventDispatcher,
        ObjectManager $objectManager
    ){
        $this->eventDispatcher = $eventDispatcher;
        $this->contentRepository = $contentRepository;
        $this->objectManager = $objectManager;

    }

    /**
     * @param mixed $entity
     *
     * @return bool
     */
    public function support($entity)
    {
        return $entity instanceof ContentInterface;
    }

    /**
     * @param mixed $entity
     */
    public function remove($entity)
    {
        $contents = $this->contentRepository->findByContentId($entity->getContentId());
        foreach ($contents as $content) {
            $this->objectManager->remove($content);
            $this->eventDispatcher->dispatch(TrashcanEvents::TRASHCAN_REMOVE_ENTITY, new TrashcanEvent($content));
        }
        $this->objectManager->flush();
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'remove_trashcan_content';
    }
}
