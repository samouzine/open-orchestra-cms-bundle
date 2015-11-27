<?php

namespace OpenOrchestra\BackofficeBundle\Form\Type\Component;

use OpenOrchestra\ModelInterface\Repository\ContentRepositoryInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilderInterface;
use OpenOrchestra\BaseBundle\Context\CurrentSiteIdInterface;
use OpenOrchestra\BackofficeBundle\Form\DataTransformer\ReferenceToEmbedTransformer;

/**
 * Class ContentChoiceType
 */
class ContentChoiceType extends AbstractType
{
    protected $contentRepository;
    protected $contextManager;
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
            'choices' => $this->getChoices($options['content_type'], $options['operator'], $options['keyword']),
        ));
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
        $contents = $this->contentRepository->findByContentTypeAndKeywords($language, $contentType, $operator, $keywords);

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
                'content_type' => '',
                'operator' => '',
                'keyword' => '',
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
