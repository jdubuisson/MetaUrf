<?php
namespace Murf\MatchBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\EntityManager;

class GameType extends AbstractType
{
    private $em;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if (rand(0, 1)) {
            $team1 = $options['data']->getWinners();
            $team2 = $options['data']->getLosers();
        } else {
            $team1 = $options['data']->getLosers();
            $team2 = $options['data']->getWinners();
        }

        $builder->add('team', 'choice', array(
            'choices' => array(
                implode('|', $team1) => $this->formatLabel($team1),
                implode('|', $team2) => $this->formatLabel($team2)
            ),
            'multiple' => false,
            'expanded' => true,
            'mapped' => false,
            'label_attr' => array('class' => 'team-label')
        ));
    }

    public function getName()
    {
        return 'game';
    }

    /**
     * Formats a championId array into a string to be used as a label
     * @param $array
     */
    protected function formatLabel($array)
    {
        array_walk($array, function (&$a) {
            $a = $this->em->getRepository('MurfMatchBundle:MurfChampion')->findOneByChampionId($a)->getChampionKey();
        });
        return implode('|', $array);
    }

}