<?php

namespace App\Repository;

use App\Entity\Franchise;
use App\Entity\Genre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Franchise>
 */
class FranchiseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Franchise::class);
    }

    public function findByFilters(?Genre $genre, ?string $name): array
    {
        $qb = $this->createQueryBuilder('f');

        if ($genre) {
            $qb->andWhere('f.genre = :genre')
            ->setParameter('genre', $genre);
        }

        if ($name) {
            $qb->andWhere('f.name LIKE :name')
            ->setParameter('name', '%' . $name . '%');
        }

        return $qb->getQuery()->getResult();
    }

//    /**
//     * @return Franchise[] Returns an array of Franchise objects
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

//    public function findOneBySomeField($value): ?Franchise
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
