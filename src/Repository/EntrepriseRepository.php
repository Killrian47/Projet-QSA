<?php

namespace App\Repository;

use App\Entity\Entreprise;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @extends ServiceEntityRepository<Entreprise>
 *
 * @method Entreprise|null find($id, $lockMode = null, $lockVersion = null)
 * @method Entreprise|null findOneBy(array $criteria, array $orderBy = null)
 * @method Entreprise[]    findAll()
 * @method Entreprise[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EntrepriseRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Entreprise::class);
    }

    public function save(Entreprise $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Entreprise $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof Entreprise) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newHashedPassword);

        $this->save($user, true);
    }

    public function findByEntrepriseName(string $name)
    {
        return $this->createQueryBuilder('e')
            ->where('e.name LIKE :name')
            ->setParameter('name', '%' . $name . '%')
            ->orderBy('e.name', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function entrepriseStartedByA()
    {
        return $this->createQueryBuilder('e')
            ->where('e.name LIKE :name1')
            ->setParameters([
                'name1' => 'A%',
            ])
            ->orderBy('e.name', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function entrepriseStartedByB()
    {
        return $this->createQueryBuilder('e')
            ->where('e.name LIKE :name')
            ->setParameter('name', 'B%')
            ->orderBy('e.name', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function entrepriseStartedByC()
    {
        return $this->createQueryBuilder('e')
            ->where('e.name LIKE :name')
            ->setParameter('name', 'C%')
            ->orderBy('e.name', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function entrepriseStartedByD()
    {
        return $this->createQueryBuilder('e')
            ->where('e.name LIKE :name')
            ->setParameter('name', 'D%')
            ->orderBy('e.name', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function entrepriseStartedByE()
    {
        return $this->createQueryBuilder('e')
            ->where('e.name LIKE :name')
            ->setParameter('name', 'E%')
            ->orderBy('e.name', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function entrepriseStartedByF()
    {
        return $this->createQueryBuilder('e')
            ->where('e.name LIKE :name')
            ->setParameter('name', 'F%')
            ->orderBy('e.name', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function entrepriseStartedByG()
    {
        return $this->createQueryBuilder('e')
            ->where('e.name LIKE :name')
            ->setParameter('name', 'G%')
            ->orderBy('e.name', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function entrepriseStartedByH()
    {
        return $this->createQueryBuilder('e')
            ->where('e.name LIKE :name')
            ->setParameter('name', 'H%')
            ->orderBy('e.name', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function entrepriseStartedByI()
    {
        return $this->createQueryBuilder('e')
            ->where('e.name LIKE :name')
            ->setParameter('name', 'I%')
            ->orderBy('e.name', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function entrepriseStartedByJ()
    {
        return $this->createQueryBuilder('e')
            ->where('e.name LIKE :name')
            ->setParameter('name', 'J%')
            ->orderBy('e.name', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function entrepriseStartedByK()
    {
        return $this->createQueryBuilder('e')
            ->where('e.name LIKE :name')
            ->setParameter('name', 'K%')
            ->orderBy('e.name', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function entrepriseStartedByL()
    {
        return $this->createQueryBuilder('e')
            ->where('e.name LIKE :name')
            ->setParameter('name', 'L%')
            ->orderBy('e.name', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function entrepriseStartedByM()
    {
        return $this->createQueryBuilder('e')
            ->where('e.name LIKE :name')
            ->setParameter('name', 'M%')
            ->orderBy('e.name', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function entrepriseStartedByN()
    {
        return $this->createQueryBuilder('e')
            ->where('e.name LIKE :name')
            ->setParameter('name', 'N%')
            ->orderBy('e.name', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function entrepriseStartedByO()
    {
        return $this->createQueryBuilder('e')
            ->where('e.name LIKE :name')
            ->setParameter('name', 'O%')
            ->orderBy('e.name', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function entrepriseStartedByP()
    {
        return $this->createQueryBuilder('e')
            ->where('e.name LIKE :name')
            ->setParameter('name', 'P%')
            ->orderBy('e.name', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function entrepriseStartedByQ()
    {
        return $this->createQueryBuilder('e')
            ->where('e.name LIKE :name')
            ->setParameter('name', 'Q%')
            ->orderBy('e.name', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function entrepriseStartedByR()
    {
        return $this->createQueryBuilder('e')
            ->where('e.name LIKE :name')
            ->setParameter('name', 'R%')
            ->orderBy('e.name', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function entrepriseStartedByS()
    {
        return $this->createQueryBuilder('e')
            ->where('e.name LIKE :name')
            ->setParameter('name', 'S%')
            ->orderBy('e.name', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function entrepriseStartedByT()
    {
        return $this->createQueryBuilder('e')
            ->where('e.name LIKE :name')
            ->setParameter('name', 'T%')
            ->orderBy('e.name', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function entrepriseStartedByU()
    {
        return $this->createQueryBuilder('e')
            ->where('e.name LIKE :name')
            ->setParameter('name', 'U%')
            ->orderBy('e.name', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function entrepriseStartedByV()
    {
        return $this->createQueryBuilder('e')
            ->where('e.name LIKE :name')
            ->setParameter('name', 'V%')
            ->orderBy('e.name', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function entrepriseStartedByW()
    {
        return $this->createQueryBuilder('e')
            ->where('e.name LIKE :name')
            ->setParameter('name', 'W%')
            ->orderBy('e.name', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function entrepriseStartedByX()
    {
        return $this->createQueryBuilder('e')
            ->where('e.name LIKE :name')
            ->setParameter('name', 'X%')
            ->orderBy('e.name', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function entrepriseStartedByY()
    {
        return $this->createQueryBuilder('e')
            ->where('e.name LIKE :name')
            ->setParameter('name', 'Y%')
            ->orderBy('e.name', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function entrepriseStartedByZ()
    {
        return $this->createQueryBuilder('e')
            ->where('e.name LIKE :name')
            ->setParameter('name', 'Z%')
            ->orderBy('e.name', 'ASC')
            ->getQuery()
            ->getResult();
    }

//    /**
//     * @return Entreprise[] Returns an array of Entreprise objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Entreprise
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
