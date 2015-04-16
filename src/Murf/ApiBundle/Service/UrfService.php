<?php

namespace Murf\ApiBundle\Service;

use Dowdow\LeagueOfLegendsAPIBundle\Caller\Caller;
use Symfony\Component\DependencyInjection\Container;

class UrfService
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
     * Retrieves Urfs games
     *
     * @param $region string
     * @param $beginDate long
     * @throws \Symfony\Component\CssSelector\Exception\InternalErrorException
     * @return array
     */
    public function getUrfs($region, $beginDate = null)
    {
        $request = $this->container->getParameter('roots')['urf']['urfs'];
        //default is current time -24 hours (yesterday)
        //rounded for 5 minutes
        if ($beginDate == null) {
            $beginDate = round((time() - 24 * 60 * 60) / 300) * 300;
        }
        $gameIds = $this->caller->send($request, $region, array('beginDate' => $beginDate));

        return $gameIds;
    }

}