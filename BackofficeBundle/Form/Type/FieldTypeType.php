<?php

namespace OpenOrchestra\BackofficeBundle\Form\Type;

use OpenOrchestra\BackofficeBundle\EventListener\TranslateValueInitializerListener;
use OpenOrchestra\BackofficeBundle\EventSubscriber\FieldTypeTypeSubscriber;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Translation\TranslatorInterface;
use OpenOrchestra\ModelBundle\Document\FieldType;

/**
 * Class FieldTypeType
 */
class FieldTypeType extends AbstractType
{
    protected $translateValueInitializer;
    protected $fieldOptionClass;
    protected $fieldTypeClass;
    protected $fieldOptions;
    protected $translator;

    /**
     * @param TranslatorInterface               $translator
     * @param TranslateValueInitializerListener $translateValueInitializer
     * @param array                             $fieldOptions
     * @param string                            $fieldOptionClass
     * @param string                            $fieldTypeClass
     * @param array                             $fieldTypeSearchable
     */
    public function __construct(
        TranslatorInterface $translator,
        TranslateValueInitializerListener $translateValueInitializer,
        array $fieldOptions,
        $fieldOptionClass,
        $fieldTypeClass,
        array $fieldTypeSearchable
    )
    {
        $this->translateValueInitializer = $translateValueInitializer;
        $this->translator = $translator;
        $this->fieldOptions = $fieldOptions;
        $this->fieldOptionClass = $fieldOptionClass;
        $this->fieldTypeClass = $fieldTypeClass;
        $this->fieldTypeSearchable = $fieldTypeSearchable;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventListener(FormEvents::PRE_SET_DATA, array($this->translateValueInitializer, 'preSetData'));
        $builder->addEventListener(FormEvents::PRE_SUBMIT, array($this->translateValueInitializer, 'preSubmitFieldType'));
        if (array_key_exists('property_path', $options) && is_null($options['property_path'])){
            $builder->setData($options['prototype_data']());
        }
        $builder
            ->add('fieldId', 'text', array(
                'label' => 'open_orchestra_backoffice.form.field_type.field_id'
            ))
            ->add('labels', 'oo_translated_value_collection', array(
                'label' => 'open_orchestra_backoffice.form.field_type.labels'
            ))
            ->add('searchable', 'checkbox', array(
                'label' => 'open_orchestra_backoffice.form.field_type.searchable',
                'required' => false,
            ))
            ->add('fieldTypeSearchable', 'choice', array(
                'choices' => $this->getChoicesViewSearchable(),
                'label' => 'open_orchestra_backoffice.form.field_type.type_searchable',
                'required' => false,
            ))
            ->add('translatable', 'checkbox', array(
                'label' => 'open_orchestra_backoffice.form.field_type.translatable',
                'required' => false,
            ))
            ->add('type', 'choice', array(
                'choices' => $this->getChoicesType(),
                'label' => 'open_orchestra_backoffice.form.field_type.type',
                'attr' => array(
                    'class' => 'content_type_change_type'
                )
            ))
            ->add('listable', 'checkbox', array(
                'label' => 'open_orchestra_backoffice.form.field_type.listable',
                'required' => false,
            ));
        $builder->addEventSubscriber(new FieldTypeTypeSubscriber($this->fieldOptions, $this->fieldOptionClass));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'oo_field_type';
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => $this->fieldTypeClass,
            'label' => $this->translator->trans('open_orchestra_backoffice.form.field_type.label'),
            'prototype_data' => function(){
                $default = each($this->fieldOptions);
                $fieldType = new FieldType();
                $fieldType->setType($default['key']);

                return $fieldType;
            }
        ));
    }

    /**
     * @return array
     */
    protected function getChoicesViewSearchable()
    {
        $choices = array();
        foreach ($this->fieldTypeSearchable as $option)
        {
            $choices[$option['view']] = $option['label'];
        }

        return $choices;
    }

    /**
     * @return array
     */
    protected function getChoicesType()
    {
        $choices = array();
        foreach ($this->fieldOptions as $key => $option) {
            $choices[$key] = $this->translator->trans($option['label']);
        }
        asort($choices);

        return $choices;
    }
}
