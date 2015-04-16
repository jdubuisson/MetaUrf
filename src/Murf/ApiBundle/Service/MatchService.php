<?php

namespace Murf\ApiBundle\Service;

use Dowdow\LeagueOfLegendsAPIBundle\Caller\Caller;
use Symfony\Component\DependencyInjection\Container;

class MatchService
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
     * Retrieves a match by region and matchId
     *
     * @param $region string
     * @param $matchId int
     * @param $includeTimeline boolean
     * @throws \Symfony\Component\CssSelector\Exception\InternalErrorException
     * @return array
     */
    public function getMatch($region, $matchId, $includeTimeline = false)
    {
        $request = $this->container->getParameter('roots')['match'];
        $request = str_replace('{matchId}', $matchId, $request);
        $matchData = $this->caller->send($request, $region, array('includeTimeline' => $includeTimeline));

        return $matchData;
    }

}