<?php

namespace App\Form;

use App\Entity\Location;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Repository\LocationRepository;
use Symfony\Component\Validator\Constraints\File;

class CreateLocationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setAction($options['action'])
            ->add('name', TextType::class, [
                'label' => 'Nom du lieu',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le nom du lieu est obligatoire'
                    ])
                ]
            ])
            ->add('description', TextType::class, [
                'label' => 'Description'
            ])
            ->add('imageURL', FileType::class, [
                'label' => 'Image descriptive du lieu',
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/png'
                        ],
                        'mimeTypesMessage' => 'Format accepté : PNG',
                    ])
                ]
            ])
            ->add('parentLocation', EntityType::class, [
                'class' => Location::class,
                'query_builder' => function (LocationRepository $er) use ($options) {
                    return $er->findLocationsByUniverseId($options['universe_id']);
                },
                'choice_label' => 'name',
                'label' => 'Sous-lieu de...'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Location::class,
            'universe_id' => null
        ]);
    }
}
