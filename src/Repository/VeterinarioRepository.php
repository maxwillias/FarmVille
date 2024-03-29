<?php

namespace App\Repository;

use App\Entity\Veterinario;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Veterinario>
 *
 * @method Veterinario|null find($id, $lockMode = null, $lockVersion = null)
 * @method Veterinario|null findOneBy(array $criteria, array $orderBy = null)
 * @method Veterinario[]    findAll()
 * @method Veterinario[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VeterinarioRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Veterinario::class);
    }

    //    /**
    //     * @return Veterinario[] Returns an array of Veterinario objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('v')
    //            ->andWhere('v.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('v.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    public function findOneByCRMV($crmv): ?Veterinario
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.crmv = :crmv')
            ->setParameter('crmv', $crmv)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
