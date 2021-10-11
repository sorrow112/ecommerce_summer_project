<?php

namespace App\Repository;

use App\Entity\PanierAchat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PanierAchat|null find($id, $lockMode = null, $lockVersion = null)
 * @method PanierAchat|null findOneBy(array $criteria, array $orderBy = null)
 * @method PanierAchat[]    findAll()
 * @method PanierAchat[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PanierAchatRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PanierAchat::class);
    }

        /**
        *  @return PanierAchat[]
        */
        public function findPanier(int $userID): array
        {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT p
            FROM App\Entity\panierAchat p
            WHERE p.user = :userID
            '
        )->setParameter('userID', $userID);

        // returns an array of commande objects
        return $query->getResult();
    
    }

    // /**
    //  * @return PanierAchat[] Returns an array of PanierAchat objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PanierAchat
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
