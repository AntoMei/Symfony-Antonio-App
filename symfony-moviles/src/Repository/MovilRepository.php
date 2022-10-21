<?php

namespace App\Repository;

use App\Entity\Movil;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Movil>
 *
 * @method Movil|null find($id, $lockMode = null, $lockVersion = null)
 * @method Movil|null findOneBy(array $criteria, array $orderBy = null)
 * @method Movil[]    findAll()
 * @method Movil[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MovilRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Movil::class);
    }

    public function findByName($text): array
    {
        $qb = $this->createQueryBuilder('c')
        ->andWhere('c.nombre LIKE :text')
        ->setParameter('text', '%' .$text . '%')
        ->getQuery();
        return $qb->execute();
    }

    public function save(Movil $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Movil $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Movil[] Returns an array of Movil objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Movil
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
