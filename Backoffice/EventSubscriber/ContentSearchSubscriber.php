<?php

namespace OpenOrchestra\Backoffice\EventSubscriber;

use OpenOrchestra\ModelInterface\Repository\ContentRepositoryInterface;
use OpenOrchestra\BaseBundle\Context\CurrentSiteIdInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use OpenOrchestra\Transformer\ConditionFromBooleanToBddTransformerInterface;

/**
 * Class ContentSearchSubscriber
 */
class ContentSearchSubscriber implements EventSubscriberInterface
{
    protected $contentRepository;
    protected $contextManager;
    protected $transformer;
    protected $attributes;

    /**
     * @param ContentRepositoryInterface                    $contentRepository
     * @param CurrentSiteIdInterface                        $contextManager
     * @param ConditionFromBooleanToBddTransformerInterface $transformer
     * @param array                                         $attributes
     */
    public function __construct(
        ContentRepositoryInterface $contentRepository,
        CurrentSiteIdInterface $contextManager,
        ConditionFromBooleanToBddTransformerInterface $transformer,
        array $attributes
    ) {
        $this->contentRepository = $contentRepository;
        $this->contextManager = $contextManager;
        $this->transformer = $transformer;
        $this->attributes = $attributes;
    }

    /**
     * @param FormEvent $event
     */
    public function preSubmit(FormEvent $event)
    {
        $form = $event->getForm();
        $data = $event->getData();
        if (!is_null($data) && ($data['contentType'] != '' || $data['keywords'] != '')) {
            $condition = null;
            if ($data['keywords'] != '') {
                $condition = json_decode($this->transformer->reverseTransform($data['keywords']), true);
            }
            $form->add('contentId', 'choice', array(
                'label' => false,
                'required' => false,
                'choices' => $this->getChoices($data['contentType'], $data['choiceType'], $condition),
                'attr' => $this->attributes,
            ));
        }
    }

    /**
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents()
    {
        return array(
            FormEvents::PRE_SUBMIT => 'preSubmit',
        );
    }

    /**
     * @param string $contentType
     * @param string $operator
     * @param string $keywords
     */
    protected function getChoices($contentType, $choiceType, $condition)
    {
        $choices = array();
        $language = $this->contextManager->getCurrentSiteDefaultLanguage();
        $contents = $this->contentRepository->findByContentTypeAndCondition($language, $contentType, $choiceType, $condition);

        foreach ($contents as $content) {
            $choices[$content->getId()] = $content->getName();
        }

        return $choices;
    }

}