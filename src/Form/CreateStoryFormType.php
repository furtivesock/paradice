<?php

namespace App\Form;

use App\Entity\Story;
use App\Entity\Visibility;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class CreateStoryFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('name', TextType::class, ['label' => 'Nom de l\'histoire'])
        ->add('description', TextareaType::class, ['label' => 'Description'])
        ->add('startDate', DateTimeType::class, ['label' => 'Date de lancement'])
        ->add('endRegistrationDate', DateTimeType::class, ['label' => 'Date de fin des inscriptions'])
        ->add('visibility', EntityType::class, [
            'class' => Visibility::class,
            'choice_label' => function (Visibility $visibility) {
                switch ($visibility->getName()) {
                    case 'ALL':
                        return 'Par tout le monde';
                    case 'UNIVERSE':
                        return 'Par les membres de cet universe';
                    case 'STORY':
                        return 'Par les joueurs de cette histoire';
                }
            },
            'label' => 'Visibilité'
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Story::class,
        ]);
    }
}
