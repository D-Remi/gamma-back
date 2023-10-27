<?php

namespace App\Form;

use App\Entity\GroupeMusicaux;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GroupMusicauxType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('origine')
            ->add('ville')
            ->add('annee_debut')
            ->add('anne_separation')
            ->add('fondateurs')
            ->add('membres')
            ->add('courant_musical')
            ->add('presentation')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => GroupeMusicaux::class,
        ]);
    }
}
