<?php

namespace App\Repository;

use App\Entity\Announce;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

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
    public function findByClassificationMaterialAndMaterialAndGeographicalArea($material, $geographicalArea, $currentUser)
    {
        return $this->createQueryBuilder('a')
            ->where('a.material = :material')
            ->andWhere('a.geographicalArea = :geographicalArea')
            ->andWhere('a.user != :currentUser')
            ->setParameter('material', $material)
            ->setParameter('geographicalArea', $geographicalArea)
            ->setParameter('currentUser', $currentUser)
            ->getQuery()
            ->getResult();
    }
    public function findByOtherUsers($currentUser)
    {
        return $this->createQueryBuilder('a')
            ->where('a.user != :user')
            ->setParameter('user', $currentUser)
            ->getQuery()
            ->getResult();
    }
}
