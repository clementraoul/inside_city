<?php

namespace AppBundle\Form;

use AppBundle\Entity\City;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class CircuitType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('title', ChoiceType::class, [
            'label' => 'Type de circuit', 
            'choices' => 
            [
                'Circuit culturel' => 'Circuit culturel',
                'Circuit gastronomique' => 'Circuit gastronomique',
                'Circuit sportif' => 'Circuit sportif'
            ]])
        ->add('description', TextType::class, ['label' => 'Description'])
        ->add('act1', TextType::class, ['label' => 'Activité 1'])
        ->add('act2', TextType::class, ['label' => 'Activité 2'])
        ->add('act3', TextType::class, ['label' => 'Activité 3'])
        ->add('act4', TextType::class, ['label' => 'Activité 4'])
        ->add('act5', TextType::class, ['label' => 'Activité 5'])
        ->add('duration', ChoiceType::class, [
            'label' => 'Durée', 
            'choices' => 
            [
                '1 jour' => '1 jour',
                '1 week-end' => '1 week-end',
                '3 jours et +' => '3 jours et +'
            ]])
        ->add('distance', TextType::class, ['label' => 'Distance'])
        ->add('price', ChoiceType::class, [
            'label' => 'Prix', 
            'choices' => 
            [
                '1' => 1,
                '2' => 2,
                '3' => 3,
                '4' => 4,
                '5' => 5
            ]])
        ->add('cities', EntityType::class, ['label' => 'Ville', 'class' => City::class, 'choice_label' => 'name'])
        ->add('document', FileType::class, ['label' => 'Feuille de route'])
        ->add('submit', SubmitType::class, ['label' => 'Valider']);

    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Circuit'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_circuit';
    }


}
