<?php

namespace App\Repository;

use App\Entity\JoggingRoute;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method JoggingRoute|null find($id, $lockMode = null, $lockVersion = null)
 * @method JoggingRoute|null findOneBy(array $criteria, array $orderBy = null)
 * @method JoggingRoute[]    findAll()
 * @method JoggingRoute[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JoggingRouteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, JoggingRoute::class);
    }

    // /**
    //  * @return JoggingRoute[] Returns an array of JoggingRoute objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('j')
            ->andWhere('j.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('j.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?JoggingRoute
    {
        return $this->createQueryBuilder('j')
            ->andWhere('j.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
