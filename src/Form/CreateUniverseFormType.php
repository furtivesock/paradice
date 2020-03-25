<?php

namespace App\Form;

use App\Entity\Universe;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class CreateUniverseFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setAction($options['action'])
            ->add('name', TextType::class, [
                'label'       => 'Nom de l\'univers',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Un nom doit être donné à votre univers !',
                    ]),
                ],
            ])
            ->add('description', TextareaType::class, ['label' => 'Description'])
            ->add('logoURL', TextType::class, ['label' => 'Logo'])
            ->add('bannerURL', TextType::class, ['label' => 'Banner']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Universe::class,
        ]);
    }
}
