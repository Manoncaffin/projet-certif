<?php 

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Material;

class MaterialSearchService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function findMaterialByPartialName($materialName)
    {
        $qb = $this->entityManager->createQueryBuilder();

        $escapedMaterialName = str_replace(['%'], ['\%'], $materialName);

        $qb->select('m')
            ->from(Material::class, 'm')
            ->where($qb->expr()->like('m.material', ':material'))
            ->setParameter('material', '%' . $escapedMaterialName . '%');

        $query = $qb->getQuery();

        return $query->getResult();
    }

    public function findAllMaterials()
    {
        return $this->entityManager->getRepository(Material::class)->findAll();
    }
}

?>