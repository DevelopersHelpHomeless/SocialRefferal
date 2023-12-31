<?php

namespace App\Repository;

use App\Entity\Assoc;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Assoc|null find($id, $lockMode = null, $lockVersion = null)
 * @method Assoc|null findOneBy(array $criteria, array $orderBy = null)
 * @method Assoc[]    findAll()
 * @method Assoc[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AssocRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Assoc::class);
    }

    // /**
    //  * @return Assoc[] Returns an array of Assoc objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Assoc
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function findRandomAssoc(): ?Assoc
    {
        $all = $this->findAll();

        return $all[array_rand($all)];
    }

    public function findCustom($villeId, $animauxAuthorises, $accesPmr)
    {
        $qb = $this->createQueryBuilder('a');
        if ($villeId !== null) {
            $qb->andWhere('a.ville = :villeId')->setParameter('villeId', $villeId);
        }
        if ($animauxAuthorises !== null) {
            $qb->andWhere('a.animauxAuthorises = :animauxAuthorises')->setParameter('animauxAuthorises',
                $animauxAuthorises);
        }
        if ($accesPmr !== null) {
            $qb->andWhere('a.accesPmr = :accesPmr')->setParameter('accesPmr', $accesPmr);
        }

        return $qb->getQuery()
            ->getResult();
    }
}
