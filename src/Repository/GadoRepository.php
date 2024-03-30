<?php

namespace App\Repository;

use App\Entity\Gado;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Gado>
 *
 * @method Gado|null find($id, $lockMode = null, $lockVersion = null)
 * @method Gado|null findOneBy(array $criteria, array $orderBy = null)
 * @method Gado[]    findAll()
 * @method Gado[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GadoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Gado::class);
    }

    //    /**
    //     * @return Gado[] Returns an array of Gado objects
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

    public function findOneByCode($codigo): ?Gado
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.codigo = :codigo')
            ->setParameter('codigo', $codigo)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findAllAbate()
    {
        return $this->createQueryBuilder('g')
            ->select('count(g)')
            ->andWhere('g.abate = true')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function findAllLeite()
    {
        return $this->createQueryBuilder('g')
            ->select('sum(g.leite)')
            ->andWhere('g.abate = false')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function findAllRacao()
    {
        return $this->createQueryBuilder('g')
            ->select('sum(g.racao)')
            ->andWhere('g.abate = false')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function findAllAnimaisRacao($dataMenos1Ano)
    {
        return $this->createQueryBuilder('g')
            ->select('count(g)')
            ->andWhere('g.abate = false')
            ->andWhere('g.racao > 500')
            ->andWhere('g.nascimento > :dataMenos1Ano')
            ->setParameter('dataMenos1Ano', $dataMenos1Ano)
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function findAllAnimaisFazenda($idFazenda)
    {
        return $this->createQueryBuilder('g')
            ->select('count(g)')
            ->andWhere('g.fazenda = :idFazenda')
            ->setParameter('idFazenda', $idFazenda)
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function findAllAnimaisAbate($ano) 
    {
        return $this->createQueryBuilder('g')
            ->orWhere('g.nascimento <= :ano')
            ->setParameter('ano', $ano)
            ->orWhere('g.leite < 40')
            ->orWhere('g.leite < 70 and g.racao/7 > 50')
            ->orWhere('g.peso/15 > 18')
            ->andWhere('g.abate = false')
            ->getQuery()
            ->getResult();
    }
}
