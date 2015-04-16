<?php

namespace Murf\MatchBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class GameController extends Controller
{
    public function gameAction($gameId)
    {
        $session = $this->get("session");
        $progress = $session->get('progress');
        $em = $this->get('doctrine')->getManager();

        $game = $em->getRepository('MurfMatchBundle:Game')->findOneById($gameId);

        $form = $this->prepareForm($game);

        if ($this->getRequest()->isMethod('POST')) {
            //hacky but nevermind for the hackathon
            $vote = $this->getRequest()->request->get('game');
            if($vote['team'] == implode('|', $game->getWinners()))
            {
                $result= 'success';
                $session->set('goodGuesses', $session->get('goodGuesses')+1);
            }else {
                $result = 'danger';
                $session->set('wrongGuesses', $session->get('wrongGuesses')+1);
            }
            $winners = $this->formatLabel($game->getWinners());

            $nextGame = $this->getNextGameInSet($game);
            $nextGameForm = $nextGame ? $this->prepareForm($nextGame)->createView() : null;

            $losers = $this->formatLabel($game->getLosers());
            $session->set('progress',$progress+1);
            return $this->render('MurfMatchBundle:Game:result.html.twig', array(
                    'winners' => $winners,
                    'losers' => $losers,
                    'result' => $result,
                    'votedGame' => $game,
                    'form' => $nextGameForm
                )
            );
        }
        return $this->render('MurfMatchBundle:Game:first_vote.html.twig', array('form' => $form->createView()));
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
     * returns a form for the given game
     * @param $game
     *
     * @return form
     */
    protected function prepareForm($game)
    {
        if ($game == null) {
            $this->get("session")->getFlashBag()->add("danger", "murf.error.unknown_game");
            return $this->redirect($this->generateUrl('murf_website_homepage'));
        }
        return $this->createForm('game', $game, array(
            'action' => $this->generateUrl('murf_match_game', array('gameId' => $game->getId())),
            'method' => 'POST',
        ));
    }


    /**
     * returns the next game in a set, null otherwise
     * @param $game
     * @param $em
     *
     * @return Game
     */
    protected function getNextGameInSet($game)
    {
        $nextGame = null;
        $set = $game->getMurfSet();
        $games = $set->getGames();
        $currentIndex = $games->indexOf($game);
        $numberOfGamesInSet = $games->count();
        if ($currentIndex + 1 < $numberOfGamesInSet) {
            $nextGame = $games->get($currentIndex + 1);
        }
        return $nextGame;
    }
}
