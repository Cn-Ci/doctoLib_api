<?php

namespace App\Repository;

use App\Entity\Usersymprod;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Usersymprod|null find($id, $lockMode = null, $lockVersion = null)
 * @method Usersymprod|null findOneBy(array $criteria, array $orderBy = null)
 * @method Usersymprod[]    findAll()
 * @method Usersymprod[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UsersymprodRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Usersymprod::class);
    }

    // /**
    //  * @return Usersymprod[] Returns an array of Usersymprod objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Usersymprod
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
