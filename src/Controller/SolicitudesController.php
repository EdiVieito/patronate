<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Solicitudes;
use App\Entity\User;
use App\Entity\Curso;


class SolicitudesController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    //Ruta para aceptar peticiones
    #[Route('/escritorio/solicitudes/aceptar/{id}', name: 'app_solicitudes_aceptar')]
    public function aceptar($id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $Solicitud = $this->em->getRepository(Solicitudes::class)->find($id);
        $id_user = $Solicitud->getUser();
        $id_curso = $Solicitud->getCurso();
        $user = $this->em->getRepository(User::class)->find($id_user);
        $curso = $this->em->getRepository(Curso::class)->find($id_curso);
        //Añadir el curso
        $user->addCursosCostura($curso);
        //Eliminar la petición
        $this->em->remove($Solicitud);
        $this->em->flush();
        $this->addFlash('success', 'Añadido el curso correctamente');
        return $this->redirectToRoute('lista_usuarios');
        
    }

    //Ruta para eliminar peticiones
    #[Route('/escritorio/solicitudes/eliminar/{id}', name: 'app_solicitudes_denegar')]
    public function denegar($id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $solicitud = $this->em->getRepository(Solicitudes::class)->find($id);
        $this->em->remove($solicitud);
        $this->em->flush();
        $this->addFlash('success', 'Solicitud eliminada correctamente');
        return $this->redirectToRoute('lista_usuarios');
    }

    #[Route('/notificaciones', name: 'notificaciones')]
    public function mostrarNotificaciones(): Response
    {
        $solicitudes = $this->em->getRepository(Solicitudes::class)->findAll();
        return $this->render('notificaciones.html.twig', [
            'notificaciones' => $solicitudes
        ]);
    }
}