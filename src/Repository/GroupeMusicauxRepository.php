<?php

namespace App\Repository;

use App\Entity\GroupeMusicaux;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<GroupeMusicaux>
 *
 * @method GroupeMusicaux|null find($id, $lockMode = null, $lockVersion = null)
 * @method GroupeMusicaux|null findOneBy(array $criteria, array $orderBy = null)
 * @method GroupeMusicaux[]    findAll()
 * @method GroupeMusicaux[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GroupeMusicauxRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GroupeMusicaux::class);
    }

//    /**
//     * @return GroupeMusicaux[] Returns an array of GroupeMusicaux objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('g.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?GroupeMusicaux
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
