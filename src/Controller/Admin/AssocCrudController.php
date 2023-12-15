<?php

namespace App\Controller\Admin;

use App\Entity\Assoc;
use App\Field\PlaceSearchField;
use App\Form\OuvertureType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Form\Type\FileUploadType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\HiddenField;

class AssocCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Assoc::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->showEntityActionsInlined();
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            PlaceSearchField::new('searchOnMaps', 'Rechercher une association')->onlyOnForms(),
            FormField::addPanel(' ')->onlyOnForms(),
            AssociationField::new('ville'),
            TextField::new('nom'),
            TextEditorField::new('description'),
            TelephoneField::new('telephone'),
            ImageField::new('logoFilename', 'Logo')
                ->setBasePath(Assoc::LOGO_PATH)
                ->setUploadDir('/public' . Assoc::LOGO_PATH)
                ->setFormType(FileUploadType::class)
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setRequired(false),

            FormField::addPanel('Adresse'),
            TextField::new('adresse')->setCssClass('toto')->addCssClass('map-input'),
            TextField::new('longitude')
                ->onlyOnForms(),
            TextField::new('latitude')
                ->onlyOnForms(),

            FormField::addPanel('Options'),
            AssociationField::new('categories')
                ->setRequired(true)
                ->setLabel('Catégories')
                ->setFormTypeOptions(['by_reference' => true]),
            AssociationField::new('sousCategories')
                ->setRequired(false)
                ->setLabel('Sous-catégories')
                ->setFormTypeOptions(['by_reference' => true]),
            BooleanField::new('animauxAuthorises', 'Animaux autorisés')
                ->onlyOnForms(),
            BooleanField::new('accesPmr', 'Accès PMR')
                ->onlyOnForms(),
            BooleanField::new('sourdMalentendant', 'Accessible Sourds ou malentendant')
                ->onlyOnForms(),
            BooleanField::new('malVoyant', 'Accessibles aux non ou mal voyant')
                ->onlyOnForms(),
            BooleanField::new('femmeUniquement', 'Accessible aux femmes uniquement')
                ->onlyOnForms(),

            FormField::addPanel('Horaires'),
            CollectionField::new('ouverture')
                ->renderExpanded()
                ->allowAdd()
                ->allowDelete()
                ->setEntryIsComplex(true)
                ->setEntryType(OuvertureType::class)
                ->setFormTypeOptions([
                    'by_reference' => 'false'
                ]),
            HiddenField::new('placeId'),
        ];
    }

    public function configureAssets(Assets $assets): Assets
    {
        return $assets->addJsFile('js/admin/assoc-crud.js');
    }
}
