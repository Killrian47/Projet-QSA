<?php

namespace App\Repository;

use App\Entity\Order;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Order>
 *
 * @method Order|null find($id, $lockMode = null, $lockVersion = null)
 * @method Order|null findOneBy(array $criteria, array $orderBy = null)
 * @method Order[]    findAll()
 * @method Order[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Order::class);
    }

    public function save(Order $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Order $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findByTwoDate(\DateTime $date1, \DateTime $date2, )
    {
        return $this->createQueryBuilder('o')
            ->where('o.createdAt > :date1')
            ->andWhere('o.createdAt < :date2')
            ->orderBy('o.createdAt', 'ASC')
            ->setParameters([
                'date1' => $date1,
                'date2' => $date2
            ])
            ->getQuery()
            ->getResult();
    }

    public function findByEntrepriseAndDate(int $id, \DateTime $date1, \DateTime $date2)
    {
        return $this->createQueryBuilder('o')
            ->where('o.entreprise = :id')
            ->andWhere('o.createdAt > :date1')
            ->andWhere('o.createdAt < :date2')
            ->orderBy('o.createdAt', 'ASC')
            ->setParameters([
                'id' => $id,
                'date1' => $date1,
                'date2' => $date2
            ])
            ->getQuery()
            ->getResult();
    }

//    /**
//     * @return Order[] Returns an array of Order objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('o.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Order
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
