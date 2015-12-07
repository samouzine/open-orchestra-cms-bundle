<?php

namespace OpenOrchestra\BackofficeBundle\Tests\Form\Type\Component;

use Phake;
use OpenOrchestra\BackofficeBundle\Form\Type\Component\ContentSearchType;

/**
 * Class ContentSearchTypeTest
 */
class ContentSearchTypeTest extends \PHPUnit_Framework_TestCase
{
    protected $form;

    /**
     * Set up the test
     */
    public function setUp()
    {
        $this->form = new ContentSearchType();
    }

    /**
     * Test instance
     */
    public function testInstance()
    {
        $this->assertInstanceOf('Symfony\Component\Form\AbstractType', $this->form);
    }

    /**
     * Test Name
     */
    public function testGetName()
    {
        $this->assertEquals('oo_content_search', $this->form->getName());
    }

    /**
     * Test buildForm
     */
    public function testBuildForm()
    {
        $builder = Phake::mock('Symfony\Component\Form\FormBuilderInterface');

        $this->form->buildForm($builder, array());

        Phake::verify($builder, Phake::times(3))->add(Phake::anyParameters());
    }

}