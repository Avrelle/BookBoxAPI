<?php

namespace App\Controller\Admin;

use App\Entity\Borrow;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;

class BorrowCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Borrow::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IntegerField::new('id')->hideOnForm(),
            DateField::new('dateBorrow'),
            DateField::new('returnDate'),
            AssociationField::new('user'),
            AssociationField::new('book'),
        ];
    }
    
}