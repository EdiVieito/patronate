<?php

namespace App\Controller;

use App\Entity\User;

use App\Entity\Curso;
use App\Entity\Solicitudes;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserController extends AbstractController
{

    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/registro', name: 'user_registration')]
    public function index(Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = new User();
        $registration_form = $this->createForm(UserType::class ,$user);
        $registration_form -> handleRequest($request);
        if($registration_form->isSubmitted() && $registration_form->isValid()){
            $plaintextPassword = $registration_form->get('password')->getData();

            // hash the password (based on the security.yaml config for the $user class)
            $hashedPassword = $passwordHasher->hashPassword($user,$plaintextPassword);
            $user->setPassword($hashedPassword);
            $user->setRoles(['ROLE_USER']);
            $this->em->persist($user);
            $this->em->flush();
            //$this->addFlash('exito',User::REGISTRO_EXITOSO);
            return $this->redirectToRoute('app_login');
        }
        return $this->render('user/index.html.twig', [
            'registration_form' => $registration_form->createView()
        ]);
    }

    //Aqui es donde el usuario puede ver sus datos y sus cursos
    #[Route('/user', name: 'user_datos')]
    public function user(Request $request): Response
    {
        //Solo puedes acceder si estas logueado
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $userLogueado = $this->getUser();
        $cursos = $this->em->getRepository(Curso::class)->findAllCursos();
        
        return $this->render('user/user.html.twig', [
            'cursos' => $cursos,
            'usuario'=>$userLogueado,
            'idTabla'=>$medidas = $userLogueado->getMedidas()->getId(),
        ]);
    }

    #[Route('anotarse/{id}/{user}', name: 'app_anotarse')]
    public function anotarse($id,$user): Response
    {
        $solicitado= false;
        $solicitudes = $this->em->getRepository(Solicitudes::class)->findAllSolicitudes();
        foreach ($solicitudes as $solicitud) {
            if(($solicitud->getUser() == $user) && ($solicitud->getCurso() == $id)){
                $solicitado =true;
            }
        }
        if(!$solicitado){
            $solicitud = new Solicitudes();
            $solicitud->setCurso($id);
            $solicitud->setUser($user);
            $solicitud->setFecha(\DateTime::createFromFormat('Y-m-d H:i:s',(date("Y-m-d H:i:s"))));
            $this->em->persist($solicitud);
            $this->em->flush();
            $this->addFlash('success', 'En breve te daremos acceso al curso');
            return $this->redirectToRoute('user_datos');
        }else{
            $this->addFlash('error', 'Estamos tramitando tu solicitud');
            return $this->redirectToRoute('user_datos');
        }
            
    }
}
