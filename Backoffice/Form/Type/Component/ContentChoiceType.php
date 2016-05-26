<?php

namespace OpenOrchestra\Backoffice\Form\Type\Component;

use OpenOrchestra\ModelInterface\Repository\ContentRepositoryInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilderInterface;
use OpenOrchestra\BaseBundle\Context\CurrentSiteIdInterface;
use OpenOrchestra\Backoffice\Form\DataTransformer\ReferenceToEmbedTransformer;
use OpenOrchestra\ModelInterface\Repository\ReadContentRepositoryInterface;

/**
 * Class ContentChoiceType
 */
class ContentChoiceType extends AbstractType
{
    protected $contentRepository;
    protected $contextManager;
    protected $referenceToEmbedTransformer;
    protected $formTypeName;

    /**
     * @param ContentRepositoryInterface  $contentRepository
     * @param CurrentSiteIdInterface      $contextManager
     * @param ReferenceToEmbedTransformer $referenceToEmbedTransformer
     * @param string                      $formTypeName
     */
    public function __construct(ContentRepositoryInterface $contentRepository, CurrentSiteIdInterface $contextManager, ReferenceToEmbedTransformer $referenceToEmbedTransformer, $formTypeName)
    {
        $this->contentRepository = $contentRepository;
        $this->contextManager = $contextManager;
        $this->referenceToEmbedTransformer = $referenceToEmbedTransformer;
        $this->formTypeName = $formTypeName;

        $this->referenceToEmbedTransformer->setFormTypeName($this->formTypeName);
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addModelTransformer($this->referenceToEmbedTransformer);
        $builder->add($this->formTypeName, 'choice', array(
            'label' => false,
            'choices' => $this->getChoices($options['content_search']['contentType'], $options['content_search']['choiceType'], $options['content_search']['keywords']
        )));
    }

    /**
     * @param string $contentType
     * @param string $operator
     * @param string $keywords
     */
    protected function getChoices($contentType, $operator, $keywords)
    {
        $choices = array();

        $language = $this->contextManager->getCurrentSiteDefaultLanguage();
        $contents = $this->contentRepository->findByContentTypeAndCondition($language, $contentType, $operator, $keywords);

        foreach ($contents as $content) {
            $choices[$content->getId()] = $content->getName();
        }

        return $choices;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'content_search' => array(
                    'contentType' => '',
                    'choiceType' => ReadContentRepositoryInterface::CHOICE_AND,
                    'keywords' => null,
                )
            )
        );
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'oo_content_choice';
    }
}
