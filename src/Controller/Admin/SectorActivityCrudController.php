<?php

namespace App\Controller\Admin;

use App\Entity\SectorActivity;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class SectorActivityCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return SectorActivity::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('activity'),
        ];
}
}