<?php

namespace App\Form;

use App\Entity\Personne;
use App\Entity\Sport;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;

class PersonneTypeV2 extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, ['label' => "Nom : "])
            ->add('prenom', TextType::class, ['label' => "Prenom : "])
            ->add('adresse', AdresseType::class, ['label' => "Adresse : "])
            ->add('sports', EntityType::class, ['class' => Sport::class,
             'choice_label' => 'nom',
             'query_builder' => function (EntityRepository $repo) {
                return $repo->createQueryBuilder('s');
            },
             'label' => 'Sports',
             'multiple' => true
            ])
            ->add('save', SubmitType::class, ['label' => 'Ajouter une personne'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Personne::class,
        ]);
    }
}
