<?php

namespace PHPOrchestra\BackofficeBundle\FunctionalTest\Controller;

use PHPOrchestra\ModelBundle\Model\NodeInterface;
use PHPOrchestra\ModelBundle\Repository\NodeRepository;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class SiteControllerTest
 */
class SiteControllerTest extends WebTestCase
{
    /**
     * @var NodeRepository
     */
    protected $nodeRepository;

    /**
     * @var Client
     */
    protected $client;

    protected $siteId;

    /**
     * Set up the test
     */
    public function setUp()
    {
        $this->siteId = (string) microtime(true);
        $this->client = static::createClient();
        $crawler = $this->client->request('GET', '/login');

        $form = $crawler->selectButton('Login')->form();
        $form['_username'] = 'nicolas';
        $form['_password'] = 'nicolas';

        $crawler = $this->client->submit($form);

        $this->nodeRepository = static::$kernel->getContainer()->get('php_orchestra_model.repository.node');
    }

    /**
     * Test when you create a site and update it
     */
    public function testCreateSite()
    {
        $this->assertNodeCount(0, 'fr');
        $this->assertNodeCount(0, 'en');

        $crawler = $this->client->request('GET', '/admin/site/new');

        $form = $crawler->selectButton('Save')->form();
        $form['site[siteId]'] = $this->siteId;
        $form['site[domain]'] = $this->siteId . 'domain';
        $form['site[languages]'] = array('fr');
        $this->client->submit($form);

        $this->assertNodeCount(1, 'fr');
        $this->assertNodeCount(0, 'en');

        $crawler = $this->client->request('GET', '/admin/site/form/' . $this->siteId);
        $form = $crawler->selectButton('Save')->form();
        $form['site[languages]'] = array('fr', 'en');
        $this->client->submit($form);

        $this->assertNodeCount(1, 'fr');
        $this->assertNodeCount(1, 'en');
    }

    /**
     * @param int    $count
     * @param string $language
     */
    protected function assertNodeCount($count, $language)
    {
        $nodes = $this->nodeRepository->findByNodeIdAndLanguageAndSiteId(NodeInterface::TRANSVERSE_NODE_ID, $language, $this->siteId);

        $this->assertCount($count, $nodes);
    }
}
