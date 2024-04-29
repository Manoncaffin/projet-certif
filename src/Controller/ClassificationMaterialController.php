<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ClassificationMaterialController extends AbstractController
{
    #[Route('/classification/material', name: 'app_classification_material')]
    public function index(): Response
    {
        return $this->render('classification_material/index.html.twig', [
            'controller_name' => 'ClassificationMaterialController',
        ]);
    }
}
