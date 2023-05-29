<?php

namespace App\Form;

use App\Entity\Program;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProgramType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, ['label' => 'Titre'])
            ->add('synopsis', TextType::class, ['label' => 'Synopsis'])
            ->add('poster', TextType::class, ['label' => 'Image'])
            ->add('country', CountryType::class, ['label' => 'Pays'])
            ->add('year', IntegerType::class, ['label' => 'Année'])
            ->add('category', null, ['choice_label' => 'name', 'label' => 'Catégorie']);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Program::class,
        ]);
    }
}
