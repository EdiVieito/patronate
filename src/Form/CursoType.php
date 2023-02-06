<?php

namespace App\Form;

use App\Entity\Curso;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CursoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titulo',null,[
            'label' => 'Título',
            'row_attr' => ['class' => 'col-lg-4 col-sm-12  mb-3'],
            ])
            ->add('dificultad',ChoiceType::class,
        [
            'choices'  => [
                'Fácil' => 'Fácil',
                'Intermedio' => 'Intermedio',
                'Díficil' => 'Díficil',
            ],
            'row_attr' => ['class' => 'col-lg-4 col-sm-12 mb-3']
            ])
            ->add('tipo_prenda',null,[
                'label' => 'Tipo de prenda',
                'row_attr' => ['class' => 'col-lg-4 col-sm-12  mb-3']
                ])
            ->add('descripcion',CKEditorType::class,[
                'label' => 'Descripción del curso',
                ])
            ->add('imagen',Filetype::class,
            [
                'label'=>'Miniatura',
                'data_class' => null
            ])
            ->add('ud1',CKEditorType::class,[
                'label' => 'Unidad 1',
                ])
            ->add('video1')
            ->add('ud2',CKEditorType::class,[
                'label' => 'Unidad 2',
                ])
            ->add('video2')
            ->add('ud3',CKEditorType::class,[
                'label' => 'Unidad 3',
                ])
            ->add('video3')
            ->add('ud4',CKEditorType::class,[
                'label' => 'Unidad 4',
                ])
            ->add('video4')
            ->add('ud5',CKEditorType::class,[
                'label' => 'Unidad 5',
                ])
            ->add('video5')
            ->add('Anhadir_curso',SubmitType::class,[
                'label' => 'Añadir curso',
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Curso::class,
        ]);
    }
}
