<?php

namespace App\Form;

use App\Entity\Car;
use Doctrine\DBAL\Types\FloatType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nbSeats', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Nombre',
                ],
            ])
            ->add('nbDoors', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Nombre',
                ],
            ])
            ->add('name', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Nom de la voiture',
                ],
            ])
            ->add('cost', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Prix',
                ],
            ])
            ->add('carCategory', null, [
                'attr' => [
                    'class' => 'form-select',
                ],
                'choice_label' => 'name'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Car::class,
        ]);
    }
}
