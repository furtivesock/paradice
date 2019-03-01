<?php

namespace App\Form;

use App\Entity\Universe;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class CreatePersonaFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setAction($options['action'])
            ->add('firstname', TextType::class, ['label' => 'Prénom du persona'])
            ->add('lastName', TextType::class, ['label' => 'Nom du persona'])
            ->add('physicalDescription', TextareaType::class, ['label' => 'Description physique'])
            ->add('personality', TextType::class, ['label' => 'Personalité'])
            ->add('background', TextaeraType::class, ['label' => 'Background'])
            ->add('avatarURL', TextType::class, ['label' => 'AvatarURL'])
            ->add('age', NumberType::class, ['label' => 'Age du persona'])
            ->add('universe', EntityType::class, [
                'label' => 'Univers du persona',
                'class' => Universe::class,
                'choice_label' => function (Universe $universe) {
                    switch ($universe->getName()) {
                        case 'ALL':
                            return 'Par tout le monde';
                        case 'UNIVERSE':
                            return 'Par les membres de cet universe';
                        case 'STORY':
                            return 'Par les joueurs de cette histoire';
                    }
                }
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Universe::class,
        ]);
        
    }
}
