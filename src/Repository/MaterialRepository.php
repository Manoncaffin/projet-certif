<?php

namespace App\Repository;

use App\Entity\Material;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Material>
 */
class MaterialRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Material::class);
    }

    public function materialAllWords($name) {
        return $this->createQueryBuilder('m')
        ->where('m.material = :name')
        ->andWhere('m.material LIKE :name')
        ->setParameter('name', $name)
        ->setParameter('material', ':name%')
        ->getQuery()
        ->getResult();
}
}
