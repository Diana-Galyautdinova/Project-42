<?php

namespace App\Repository;

use App\Entity\Students;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Students|null find($id, $lockMode = null, $lockVersion = null)
 * @method Students|null findOneBy(array $criteria, array $orderBy = null)
 * @method Students[]    findAll()
 * @method Students[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StudentsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Students::class);
    }

    // /**
    //  * @return Students[] Returns an array of Students objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Students
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
