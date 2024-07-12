<?php

namespace App\Repository;

use App\Entity\Announce;
use App\Entity\ClassificationMaterial;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Material;

/**
 * @extends ServiceEntityRepository<Announce>
 */
class AnnounceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Announce::class);
    }

    public function findByUser(User $user): array
    {
        return $this->createQueryBuilder('a')
            ->where('a.user = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();
    }
    public function findByClassificationMaterialAndMaterialAndGeographicalArea($material, $geographicalArea)
{
    return $this->createQueryBuilder('a')
        ->where('a.material = :material')
        ->andWhere('a.geographicalArea = :geographicalArea')
        ->setParameter('material', $material)
        ->setParameter('geographicalArea', $geographicalArea)
        ->getQuery()
        ->getResult();
}
}
