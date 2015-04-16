<?php

namespace Murf\ApiBundle\Service;

use Dowdow\LeagueOfLegendsAPIBundle\Caller\Caller;
use Symfony\Component\DependencyInjection\Container;

class StaticChampionService
{

    /**
     * @var Caller
     */
    private $caller;

    /**
     * @var Container
     */
    private $container;

    /**
     * Constructor
     * @param Caller $caller
     * @param Container $container
     */
    public function __construct(Caller $caller, Container $container)
    {
        $this->caller = $caller;
        $this->container = $container;
    }

    /**
     * Retrieves the static champion data
     *
     * @param $region string
     * @param $matchId int
     * @param $includeTimeline boolean
     * @throws \Symfony\Component\CssSelector\Exception\InternalErrorException
     * @return array
     */
    public function getStaticChampions($region)
    {
        $request = $this->container->getParameter('roots')['lol-static-data']['championList'];
        $champData = $this->caller->send($request, 'global' . $region, array());

        return $champData;
    }

}