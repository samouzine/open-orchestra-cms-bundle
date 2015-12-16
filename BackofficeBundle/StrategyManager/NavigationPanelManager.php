<?php

namespace OpenOrchestra\BackofficeBundle\StrategyManager;

use OpenOrchestra\Backoffice\NavigationPanel\NavigationPanelInterface;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;

/**
 * Class NavigationPanelManager
 */
class NavigationPanelManager
{
    protected $strategies = array();
    protected $templateEngine;

    /**
     * @param EngineInterface $templateEngine
     */
    public function __construct(EngineInterface $templateEngine)
    {
        $this->templateEngine = $templateEngine;
    }

    /**
     * @param NavigationPanelInterface $strategy
     */
    public function addStrategy(NavigationPanelInterface $strategy)
    {
        $this->strategies[$strategy->getParent()][$strategy->getWeight()][$strategy->getName()] = $strategy;
        $strategy->setTemplating($this->templateEngine);
    }

    /**
     * @return string
     */
    public function show()
    {
        foreach ($this->strategies as $parent => $weightedStrategies) {
            ksort($weightedStrategies);
            $this->strategies[$parent] = $weightedStrategies;
        }

        return $this->templateEngine->render('/open-orchestra/backoffice-bundle/BackOffice/Include/NavigationPanel/show.html.twig', array(
            'strategies' => $this->strategies
        ));
    }
}
