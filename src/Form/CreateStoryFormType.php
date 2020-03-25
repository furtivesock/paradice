<?php

namespace App\Form;

use App\Entity\Story;
use App\Entity\Visibility;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\NotBlank;

class CreateStoryFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setAction($options['action'])
            ->add('name', TextType::class, [
                'label'       => 'Nom de l\'histoire',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Un nom doit être donné à votre histoire !',
                    ]),
                ],
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
            ])
            ->add('startDate', DateTimeType::class, [
                'label'       => 'Date de lancement',
                'constraints' => [
                    new GreaterThan([
                        'propertyPath' => 'endRegistrationDate',
                        'message'      => 'Cette date doit être supérieure à la date de fin des inscriptions',
                    ]),
                ],
            ])
            ->add('endRegistrationDate', DateTimeType::class, [
                'label'       => 'Date de fin des inscriptions',
                'constraints' => [
                    new GreaterThan([
                        'value'   => 'now',
                        'message' => 'Cette date doit être supérieure ou égale à la date d\'aujourdhui',
                    ]),
                ],

            ])
            ->add('visibility', EntityType::class, [
                'label'        => 'Visibilité',
                'class'        => Visibility::class,
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
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Story::class,
        ]);
    }
}
