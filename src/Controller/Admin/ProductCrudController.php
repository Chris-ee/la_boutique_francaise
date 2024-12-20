<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Produit')
            ->setEntityLabelInPlural('Produits')
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        $required = true;

        if($pageName == 'edit'){
            $required = false;
        }

        return [
            TextField::new('name')->setLabel('Titre')->setHelp('Nom de votre produit'),
            SlugField::new('slug')->setLabel('URL')->setTargetFieldName('name')->setLabel('URL')->setHelp('URL de votre produit généré automatiquement'),
            TextEditorField::new('description')->setLabel('Description')->setHelp('Description de votre produit'),
            ImageField::new('illustration')
            ->setLabel('Image')
            ->setHelp('Image du produit en 600x600px')
            ->setUploadedFileNamePattern('[year]-[month]-[day]-[contenthash].[extension]')
            ->setUploadDir('public/uploads')
            ->setBasePath('/uploads')
            ->setRequired($required),
            NumberField::new('price')->setLabel('Prix H.T')->setHelp('Le prix H.T du produit sans le sigle euros'),
            ChoiceField::new('tva')->setLabel('Taux de TVA')->setChoices([
                '5,5%' => '5.5',
                '10%' => '10',
                '20%' => '20'
            ]),
            AssociationField::new('category', 'Catégorie associée')
        ];
    }
}
