<?php

namespace Murf\MatchBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Murf\MatchBundle\Entity\MurfChampion;
use Dowdow\LeagueOfLegendsAPIBundle\Constant\Region;

class StaticChampionInitCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('murf:static-champion-init')
            ->setDescription('updates the database with new static champion data');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $data = $this->getContainer()
            ->get('dowdow_league_of_legends_api.service_staticchampion')
            ->getStaticChampions(Region::EUW);
        $output->writeln('start');
        $em = $this->getContainer()->get('doctrine')->getManager();
        foreach ($data->data as $key => $staticChampion) {
            $old = $em->getRepository('MurfMatchBundle:MurfChampion')->findOneByChampionKey($staticChampion->key);
            if ($old) {
                $em->remove($old);
            }
            $champ = new MurfChampion();
            $champ->setChampionId($staticChampion->id);
            $champ->setChampionKey($staticChampion->key);
            $champ->setChampionName($staticChampion->name);
            $champ->setChampionTitle($staticChampion->title);
            $champ->setRegion(Region::EUW);
            $em->persist($champ);
            $em->flush();
            $output->writeln($staticChampion->name . ' persisted');
        }
        $output->writeln('end');
    }
}