<?php

namespace App\Repository;

use App\Entity\Fazenda;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Fazenda>
 *
 * @method Fazenda|null find($id, $lockMode = null, $lockVersion = null)
 * @method Fazenda|null findOneBy(array $criteria, array $orderBy = null)
 * @method Fazenda[]    findAll()
 * @method Fazenda[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FazendaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Fazenda::class);
    }

    //    /**
    //     * @return Fazenda[] Returns an array of Fazenda objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('f.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Fazenda
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
