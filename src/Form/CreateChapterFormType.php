<?php

namespace App\Form;

use App\Entity\Chapter;
use App\Entity\Location;
use App\Repository\LocationRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class CreateChapterFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, ['label' => 'Nom du chapitre'])
            ->add('location', EntityType::class, [
                'class' => Location::class,
                'query_builder' => function (LocationRepository $er) use ($options) {
                    return $er->findLocationsByUniverseId($options['id']);
                },
                'choice_label' => 'name',
                'label' => 'Lieu'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Chapter::class,
            'id' => null,
        ]);
    }
}
