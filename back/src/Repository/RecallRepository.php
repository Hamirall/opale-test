<?php

namespace App\Repository;

use App\Entity\Recall;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Recall>
 */
class RecallRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Recall::class);
    }

    /**
     * Récupère tous les rappels ou filtre par nom si un filtre est fourni.
     *
     * @param string|null $name Le nom à filtrer (optionnel).
     * @return Recall[] Retourne un tableau d'objets Recall.
     */
    public function findAllOrByName(?string $name = null): array
    {
        $qb = $this->createQueryBuilder("r");

        if ($name !== null) {
            $qb->andWhere("r.productName LIKE :name")->setParameter(
                "name",
                "%" . $name . "%"
            );
        }

        return $qb->getQuery()->getResult();
    }
}
