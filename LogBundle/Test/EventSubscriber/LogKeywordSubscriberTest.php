<?php

namespace PHPOrchestra\LogBundle\Test\EventSubscriber;

use Phake;
use PHPOrchestra\LogBundle\EventSubscriber\LogKeywordSubscriber;
use PHPOrchestra\ModelInterface\KeywordEvents;

/**
 * Class LogKeywordSubscriberTest
 */
class LogKeywordSubscriberTest extends LogAbstractSubscriberTest
{
    protected $keyword;
    protected $keywordEvent;

    /**
     * Set up the test
     */
    public function setUp()
    {
        parent::setUp();
        $this->keyword = Phake::mock('PHPOrchestra\ModelBundle\Document\Keyword');
        $this->keywordEvent = Phake::mock('PHPOrchestra\ModelInterface\Event\KeywordEvent');
        Phake::when($this->keywordEvent)->getKeyword()->thenReturn($this->keyword);

        $this->subscriber = new LogKeywordSubscriber($this->logger);
    }

    /**
     * @return array
     */
    public function provideSubscribedEvent()
    {
        return array(
            array(KeywordEvents::KEYWORD_CREATE),
            array(KeywordEvents::KEYWORD_DELETE),
        );
    }

    /**
     * Test keywordCreate
     */
    public function testKeywordCreate()
    {
        $this->subscriber->keywordCreate($this->keywordEvent);
        $this->assertEventLogged('php_orchestra_log.keyword.create', array(
            'keyword_label' => $this->keyword->getLabel()
        ));
    }

    /**
     * Test keywordDelete
     */
    public function testKeywordDelete()
    {
        $this->subscriber->keywordDelete($this->keywordEvent);
        $this->assertEventLogged('php_orchestra_log.keyword.delete', array(
            'keyword_label' => $this->keyword->getLabel()
        ));
    }
}