<?php

namespace Murf\MatchBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Dowdow\LeagueOfLegendsAPIBundle\Constant\Region;
use Murf\MatchBundle\Entity\Game;
use Murf\MatchBundle\Entity\MurfSet;
use GuzzleHttp\Exception\RequestException;


class SetController extends Controller
{
    /**
     * initiates a set based in id
     *
     * @param $setId
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function setAction($setId)
    {
        $em = $this->get('doctrine')->getManager();

        $session = $this->get("session");
        $session->set('goodGuesses', 0);
        $session->set('wrongGuesses', 0);
        $session->set('progress', 0);
        $set = $em->getRepository('MurfMatchBundle:MurfSet')->findOneById($setId);
        $session->set('numberOfGames', $set->getGames()->count());
        if ($set == null) {
            $session->getFlashBag()->add("danger", "murf.error.unknown_set");
            return $this->redirect($this->generateUrl('murf_website_homepage'));
        }
        return $this->redirect($this->generateUrl('murf_match_game', array('gameId' => $set->getGames()->first()->getId())));
    }

    /**
     * initiates a random set from DB
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function randomSetAction()
    {
        $em = $this->get('doctrine')->getManager();

        $set = $em->getRepository('MurfMatchBundle:MurfSet')->findOneAtRandom();

        return $this->redirect($this->generateUrl('murf_match_set', array('setId' => $set->getId())));
    }

    /**
     * initiates a set from the API
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function apiSetAction()
    {
        $em = $this->get('doctrine')->getManager();

        $matchService = $this->get('dowdow_league_of_legends_api.service_match');

        $set = new MurfSet();
        try {
            //values are first and last bucket
            $timestamp = rand(1427865900, 1428918000);
            $urfs = $this
                ->get('dowdow_league_of_legends_api.service_urf')
                ->getUrfs(Region::EUW, round($timestamp / 300) * 300);

            foreach ($urfs as $urf) {
                $data = $matchService->getMatch(Region::EUW, $urf);
                $game = new Game();
                $game->setRegion($data->region);
                $game->setMatchId($data->matchId);
                $date = new \DateTime();
                $date->setTimestamp(round($data->matchCreation / 1000));
                $game->setMatchCreation($date);

                $winnerTeamId = $data->teams[0]->winner ? $data->teams[0]->teamId : $data->teams[1]->teamId;
                foreach ($data->participants as $participant) {
                    if ($participant->teamId == $winnerTeamId) {
                        $game->addWinner($participant->championId);
                    } else {
                        $game->addLoser($participant->championId);
                    }
                }
                $game->setMurfSet($set);
                $set->addGame($game);
                $em->persist($game);
            }
            $em->persist($set);
            $em->flush();
        } catch (RequestException $e) {
            //very simple, but hacky :
            //delete the set to avoid issues
            $this->deleteSet($set, $em);
            //redirect the user to a random game since we likely had an API request issue
            //TODO : dowdow doesn't seem to send the proper exception, we get a guzzle RequestException
            return $this->redirect($this->generateUrl('murf_match_randomset'));
        }
        //empty set : we delete it and forward the user to a random set
        if($set->getGames()->count() == 0)
        {
            $this->deleteSet($set, $em);
            return $this->redirect($this->generateUrl('murf_match_randomset'));
        }

        return $this->redirect($this->generateUrl('murf_match_set', array('setId' => $set->getId())));
    }


    /**
     * Formats a championId array into a string to be used as a label
     * @param $array
     */
    protected function formatLabel($array)
    {
        array_walk($array, function (&$a) {
            $a = $this->get('doctrine')->getManager()->getRepository('MurfMatchBundle:MurfChampion')->findOneByChampionId($a)->getChampionKey();
        });
        return $array;
    }

    /**
     * cleanly deletes a set
     * @param $set
     */
    protected function deleteSet($set, $em)
    {
        foreach ($set->getGames() as $game) {
            $em->remove($game);
        }
        $em->flush();
        $em->remove($set);
        $em->flush();
    }
}
