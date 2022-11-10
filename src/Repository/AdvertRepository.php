<?php

namespace App\Repository;

use App\Entity\Advert;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Advert>
 *
 * @method Advert|null find($id, $lockMode = null, $lockVersion = null)
 * @method Advert|null findOneBy(array $criteria, array $orderBy = null)
 * @method Advert[]    findAll()
 * @method Advert[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdvertRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Advert::class);
    }

    /**
     * @return Advert[] Returns an array of Advert objects
     */
    public function findBySearch($title = null, $priceMin = null, $priceMax = null): array
    {
        $qb = $this->createQueryBuilder('a');

        if ($title) {
            dump("in");
            $qb = $qb->andWhere("a.title LIKE :title")
                ->setParameter('title', "%" . $title . "%");
        }
        if ($priceMin) {
            $qb = $qb->andWhere('a.price <= :min')
                ->setParameter('min', $priceMin);
        }
        if ($priceMax) {
            $qb = $qb->andWhere('a.price >= :max')
                ->setParameter('max', $priceMax);
        }

        return $qb->getQuery()
            ->getResult()
        ;
    }

//    public function findOneBySomeField($value): ?Advert
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

    public function save(Advert $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Advert $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
