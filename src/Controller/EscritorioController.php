<?php

namespace App\Controller;

use App\Entity\Medidas;
use App\Entity\User;
use App\Entity\Curso;
use App\Entity\Consultas;
use App\Entity\Solicitudes;
use App\Form\CursoType;
use App\Form\ModificarCursoType;
use App\Form\ModificarPreguntaType;
use App\Form\ModificarUserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class EscritorioController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
    $this->em = $em;
    }

    #[Route('/escritorio', name: 'app_escritorio')]
    public function index(Request $request): Response
    {
        //Solo puedes acceder si estas logueado
        //TODO que solo accedas si eres ADMIN
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $cursos = $this->em->getRepository(Curso::class)->findAllCursos();
        return $this->render('escritorio/index.html.twig', [
            'cursos'=>$cursos
        ]);
    }

    #[Route('/escritorio/usuarios', name: 'lista_usuarios')]
    public function usuarios(): Response
    {
        //Solo puedes acceder si estas logueado
        //TODO que solo accedas si eres ADMIN

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $users = $this->em->getRepository(User::class)->findAllUsers();
        $solicitudes = $this->em->getRepository(Solicitudes::class)->findAllSolicitudes();
        return $this->render('escritorio/users.html.twig', [
            'users'=>$users,
            'solicitudes'=>$solicitudes,
        ]);
    }

    //Función para añadir curso
    #[Route('/escritorio/anadir', name: 'anadir_curso')]
    public function anadir(Request $request,SluggerInterface $slugger): Response
    {
        //Solo puedes acceder si estas logueado
        //TODO que solo accedas si eres ADMIN
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $curso = new Curso();
        $form = $this->createForm(CursoType::class,$curso);
        $form->handleRequest($request);

        if($form->isSubmitted()&& $form->isValid()){
            $imagen = $form->get('imagen')->getData();
            if ($imagen) {
                $originalFilename = pathinfo($imagen->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imagen->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $imagen->move(
                        $this->getParameter('miniaturas_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    throw new \Exception('Ups, el archivo no es válido');
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $curso->setImagen($newFilename);
            }
            $this->em->persist($curso);
            $this->addFlash('success', 'Has añadido un nuevo curso');
            $this->em->flush();
            return $this->redirectToRoute('app_escritorio');
        }

        return $this->render('escritorio/anadir.html.twig', [
            'formAnadir'=>$form->createView(),
        ]);
    }

    //Función para eliminar
    #[Route('eliminar/curso/{id}', name: 'eliminarCurso')]
    public function eliminarCurso($id):Response
    {
        $curso = $this->em->getRepository(Curso::class)->find($id);
        $this->em->remove($curso);
        $solicitudes = $this->em->getRepository(Solicitudes::class)->findByCurso($id);
        if($solicitudes!=null){
            foreach ($solicitudes as $solicitud) {
                $this->em->remove($solicitud);
            }
        }
        $this->em->flush();
        $this->addFlash('success', 'Curso eliminado correctamente');
        return $this->redirectToRoute('app_escritorio');
    }

    //Función para actualizar
    #[Route('/actualizar/curso/{id}', name: 'actualizarCurso')]
    public function actualizarCurso($id, Request $request,SluggerInterface $slugger): Response
    {
        //Primero recuparemos el curso
        $curso = $this->em->getRepository(Curso::class)->find($id);
        $imagenOriginal = $curso->getImagen();
        $form = $this->createForm(ModificarCursoType::class,$curso);
        $form->handleRequest($request);

        if($form->isSubmitted()&& $form->isValid()){
            $imagen = $form->get('imagen')->getData();
            //Si no está vacio coges el nuevo
            if (empty($form->get('imagen')->getData())) {
                    $curso->setImagen($imagenOriginal);
                }else{
                if ($imagen) {
                    $originalFilename = pathinfo($imagen->getClientOriginalName(), PATHINFO_FILENAME);
                    // this is needed to safely include the file name as part of the URL
                    $safeFilename = $slugger->slug($originalFilename);
                    $newFilename = $safeFilename.'-'.uniqid().'.'.$imagen->guessExtension();

                    // Move the file to the directory where brochures are stored
                    try {
                        $imagen->move(
                            $this->getParameter('miniaturas_directory'),
                            $newFilename
                        );
                    } catch (FileException $e) {
                        throw new \Exception('Ups, el archivo no es válido');
                    }
                    $curso->setImagen($newFilename);
                }
            }
            $this->em->flush();
            return $this->redirectToRoute('app_escritorio');
        }
        //return $this->redirectToRoute('app_escritorio');
        return $this->render('escritorio/actualizar.html.twig', [
            'formActualizar'=>$form->createView()
        ]);
    }

    //Modificar ususario
    #[Route('/actualizar/user/{id}', name: 'modificar_usuario')]
    public function modificar($id,Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
       //Primero recuparemos el user
       $user= $this->em->getRepository(User::class)->find($id);
       $form = $this->createForm(ModificarUserType::class,$user);
       $form->handleRequest($request);

       if($form->isSubmitted()&& $form->isValid()){
           $this->em->flush();
           return $this->redirectToRoute('lista_usuarios');
       }

       return $this->render('escritorio/actualizarUser.html.twig', [
           'formActualizarUser'=>$form->createView()
       ]);
    }

    //Eliminar ususario
    //TODO ESTO SOLO EL ADMINISTRADOR
    #[Route('/eliminar/user/{id}', name: 'eliminar_usuario')]
    public function eliminar($id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $user = $this->em->getRepository(User::class)->find($id);
        $medidas = $user->getMedidas();
        $this->em->remove($medidas);
        $solicitudes = $this->em->getRepository(Solicitudes::class)->findByUser($id);
        if($solicitudes!=null){
            foreach ($solicitudes as $solicitud) {
                $this->em->remove($solicitud);
            }
        }
        $this->em->remove($user);
        $this->em->flush();
        $this->addFlash('success', 'Usuario eliminado correctamente');
        return $this->redirectToRoute('lista_usuarios');
    }

    //Eliminar ususario
    //TODO ESTO SOLO EL ADMINISTRADOR
    #[Route('/escritorio/preguntas/eliminar/{id}', name: 'eliminar_preguntas')]
    public function eliminarPreguntas($id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $consulta = $this->em->getRepository(Consultas::class)->find($id);
        $this->em->remove($consulta);
        $this->em->flush();
        $this->addFlash('success', 'Pregunta eliminada correctamente');
        return $this->redirectToRoute('lista_preguntas');
    }
    
    //Modificar ususario
    #[Route('/escritorio/preguntas/actualizar/{id}', name: 'modificar_pregunta')]
    public function actualizarPregunta($id,Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
       //Primero recuparemos el user
       $consulta= $this->em->getRepository(Consultas::class)->find($id);
       $form = $this->createForm(ModificarPreguntaType::class,$consulta);
       $form->handleRequest($request);

       if($form->isSubmitted()&& $form->isValid()){
           $this->em->flush();
           return $this->redirectToRoute('lista_preguntas');
       }

       return $this->render('escritorio/actualizarPregunta.html.twig', [
           'formActualizarPregunta'=>$form->createView()
       ]);
    }

    #[Route('/escritorio/preguntas', name: 'lista_preguntas')]
    public function preguntas(): Response
    {
        //Solo puedes acceder si estas logueado
        //TODO que solo accedas si eres ADMIN

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $consultas = $this->em->getRepository(Consultas::class)->findAll();
        $consultasSinResponder = $this->em->getRepository(Consultas::class)->findAllSinResponder();
        return $this->render('escritorio/preguntas.html.twig', [
            'preguntas'=>$consultas,
            'SinResponder'=>$consultasSinResponder,
        ]);
    }

}
