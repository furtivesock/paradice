<?php

namespace App\Form;

use App\Entity\UniverseApplication;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class UniverseApplicationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setAction($options['action'])
            ->add('motivation', TextareaType::class, [
                'label'       => 'Votre lettre de motivation',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Votre demande devrait être motivée !',
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UniverseApplication::class,
        ]);
    }
}
