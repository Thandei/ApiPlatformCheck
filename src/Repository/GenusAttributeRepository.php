<?php

namespace App\Repository;

use App\Entity\GenusAttribute;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<GenusAttribute>
 *
 * @method GenusAttribute|null find($id, $lockMode = null, $lockVersion = null)
 * @method GenusAttribute|null findOneBy(array $criteria, array $orderBy = null)
 * @method GenusAttribute[]    findAll()
 * @method GenusAttribute[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GenusAttributeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GenusAttribute::class);
    }

    public function save(GenusAttribute $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(GenusAttribute $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return GenusAttribute[] Returns an array of GenusAttribute objects
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

//    public function findOneBySomeField($value): ?GenusAttribute
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
