<?php

namespace App\Repository;

use App\Entity\Produit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Produit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Produit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Produit[]    findAll()
 * @method Produit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProduitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Produit::class);
    }
    /**
     * @return Produit[]
     */
    public function findProducts(int $souscatID): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT p
            FROM App\Entity\Produit p
            WHERE p.sous_categorie = :souscatID
            ORDER BY p.nom'
        )->setParameter('souscatID', $souscatID);

        // returns an array of Product objects
        return $query->getResult();
    }
    public function findProduct(int $prodID): Produit
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT p
            FROM App\Entity\Produit p
            WHERE p.id = :prodID'

        )->setParameter('prodID', $prodID);
        return $query->getResult()[0];
    }

    public function findProductByName(int $prodName): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT p
            FROM App\Entity\Produit p
            WHERE p.nom like :prodName'

        )->setParameter('prodName', $prodName);
        return $query->getResult();
    }
    

    
}
