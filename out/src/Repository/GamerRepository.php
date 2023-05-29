<?php

namespace App\Repository;

use App\Entity\Gamer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Gamer>
 *
 * @method Gamer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Gamer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Gamer[]    findAll()
 * @method Gamer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GamerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Gamer::class);
    }

    public function save(Gamer $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Gamer $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
 /**
     * @return Gamer[] Returns an array of Coach objects
     */
    public function findByban($value): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.bannir = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult()
        ;
    }


//    /**
//     * @return Gamer[] Returns an array of Gamer objects
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

//    public function findOneBySomeField($value): ?Gamer
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
