<?php

namespace Murf\MatchBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * MurfSetRepository
 *
 */
class MurfSetRepository extends EntityRepository
{
    public function findOneAtRandom()
    {
$count = $this->createQueryBuilder('s')->select('count(s.id)')->getQuery()->getSingleScalarResult();
        return $this->createQueryBuilder('s')
            ->setFirstResult(rand(0, $count - 1))
            ->setMaxResults(1)
            ->getQuery()
            ->getSingleResult();
    }
}
