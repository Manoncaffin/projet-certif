<?php

namespace App\Controller\Admin;

use App\Entity\Volume;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class VolumeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Volume::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
        ];
    }

}
