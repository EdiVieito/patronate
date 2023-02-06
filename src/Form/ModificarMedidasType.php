<?php

namespace App\Form;

use App\Entity\Medidas;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ModificarMedidasType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('ancho_espalda',NumberType::class,['attr' => ['maxlength' => 6]])
            ->add('contorno_busto',NumberType::class,['attr' => ['maxlength' => 6]])
            ->add('cintura',NumberType::class,['attr' => ['maxlength' => 6]])
            ->add('cadera',NumberType::class,['attr' => ['maxlength' => 6]])
            ->add('ancho_manga',NumberType::class,['attr' => ['maxlength' => 6]])
            ->add('largo_manga',NumberType::class,['attr' => ['maxlength' => 6]])
            ->add('contorno_punho',NumberType::class,['attr' => ['maxlength' => 6]])
            ->add('contorno_cuello',NumberType::class,['attr' => ['maxlength' => 6]])
            ->add('talle_delantero',NumberType::class,['attr' => ['maxlength' => 6]])
            ->add('talle_espalda',NumberType::class,['attr' => ['maxlength' => 6]])
            ->add('Introducir',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Medidas::class,
        ]);
    }
}
