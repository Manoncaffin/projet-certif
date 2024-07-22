<?php

namespace App\Controller\Admin;

use App\Entity\Announce;
use App\Entity\ClassificationMaterial;
use App\Entity\Material;
use App\Entity\SectorActivity;
use App\Entity\Volume;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Projet Certif');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Classification', 'fa-solid fa-recycle', ClassificationMaterial::class);
        yield MenuItem::linkToCrud('Material', 'fa-solid fa-feather', Material::class);
        yield MenuItem::linkToCrud('Announce', 'fa-regular fa-envelope', Announce::class);
        yield MenuItem::linkToCrud('User','fa-regular fa-address-book', SectorActivity::class);
        yield MenuItem::linkToCrud('Volume','fa-solid fa-cube', Volume::class);
    }
}
