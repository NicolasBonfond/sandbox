<?php

namespace App\Repository;

use App\Entity\Recipes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Recipes>
 *
 * @method Recipes|null find($id, $lockMode = null, $lockVersion = null)
 * @method Recipes|null findOneBy(array $criteria, array $orderBy = null)
 * @method Recipes[]    findAll()
 */


class RecipesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Recipes::class);
    }



    /** 
     * @return Recipes[] Returns an array of Recipes objects
     */

    public function findWithDurationLowerThan(int $duration): array {

        return $this->createQueryBuilder('r')
            ->andWhere('r.duration < :duration')
            ->setParameter('duration', $duration)
            ->orderBy('r.duration', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findTotalDuration(): int {
        return $this->createQueryBuilder('r')
            ->select('SUM(r.duration) as total_duration')
            ->getQuery()
            ->getSingleScalarResult()
        ;
    }

    //    /**
    //     * @return Recipes[] Returns an array of Recipes objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('r.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Recipes
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
