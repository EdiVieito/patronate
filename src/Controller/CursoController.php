<?php

namespace App\Controller;
use App\Form\ConsultasType;
use App\Entity\Curso;
use App\Entity\Consultas;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CursoController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
    $this->em = $em;
    }

    #[Route('curso/{id}', name: 'app_curso')]
    public function index($id,Request $request): Response
    {
        $datos = $this->em->getRepository(Curso::class)->find($id);
        $userLogueado = $this->getUser();
        //Formulario de preguntas y respuestas
        $userLogueado = $this->getUser();
        $consulta = new Consultas();
        $form = $this->createForm(ConsultasType::class,$consulta);
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){
            $consulta->setUser($userLogueado);
            $consulta->setCurso($datos);
            $consulta->setFecha(\DateTime::createFromFormat('Y-m-d H:i:s',(date("Y-m-d H:i:s"))));
            $this->em->persist($consulta);
            $this->em->flush();
            $this->addFlash('success', 'Pregunta enviada correctamente');
            return $this->redirectToRoute('app_curso',['id'=> $id]);
        }
        //Devolver las consultas del ususario a la plantilla
        $consultas_usuario = $this->em->getRepository(Consultas::class)->findByUserId($userLogueado->getId(),$datos);
        return $this->render('curso/index.html.twig', [
            'datos' => $datos,
            'formulario'=>$form->createView(),
            'consultas'=>$consultas_usuario
        ]);
    }
}
