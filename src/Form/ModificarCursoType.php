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
use Symfony\Component\Form\CallbackTransformer;

class ModificarCursoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('titulo',null,[
            'label' => 'Título',
            ])
        ->add('dificultad',ChoiceType::class,
        [
            'choices'  => [
                'Fácil' => 'Fácil',
                'Intermedio' => 'Intermedio',
                'Díficil' => 'Díficil',
            ]
            ])
            ->add('tipo_prenda',null,[
                'label' => 'Tipo de prenda',
                ])
            ->add('descripcion',CKEditorType::class,[
                'label' => 'Descripción del curso',
                ])
            ->add('imagen',Filetype::class,
            [
                'label'=>'Miniatura',
                'required'=>false,
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
            ->add('Modificar',SubmitType::class)
            ->get('imagen')->addModelTransformer(new CallBackTransformer(
                function($imagen) {
                    return null;
                },
                function($imagen) {
                    return $imagen;
                }
            ));
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Curso::class,
        ]);
    }
}
