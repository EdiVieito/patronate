<?php

namespace App\Controller;

use App\Entity\Medidas;
use App\Entity\User;
use App\Form\MedidasType;
use App\Form\ModificarMedidasType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MedidasController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
    $this->em = $em;
    }

    #[Route('/medidas', name: 'app_medidas')]
    public function index(Request $request): Response
    {
        //Solo puedes acceder si estas logueado
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $userLogueado = $this->getUser();
        $medidas = $this->getUser()->getMedidas();
        $form = $this->createForm(ModificarMedidasType::class,$medidas);
        $form->handleRequest($request);
        $medidas->setUser($userLogueado);

        if($form->isSubmitted()&& $form->isValid()){
            $medidas->setUser($userLogueado);
            $this->em->persist($medidas);
            $this->em->flush();
            $this->addFlash('success', 'Medidas modificadas correctamente');
            return $this->redirectToRoute('user_datos');
        }

        return $this->render('medidas/index.html.twig', [
           'form'=>$form->createView(),
           'usuario'=>$userLogueado,
           'medidas'=>$medidas
        ]);
    }

    //Función para actualizar
    #[Route('/actualizar/medidas', name: 'actualizarMedidas')]
    public function actualizarMedidas(): Response
    {
        //Primero recuparemos la tabla del usuario logueado
        $idTabla = $this->getUser()->getMedidas()->getId();
        $medidas = $this->em->getRepository(Medidas::class)->find($idTabla);

        //Estas medidas recuperarlas del formulario
        $medidas ->setAnchoEspalda(121);
        $this->em->flush();
        return $this->redirectToRoute('app_medidas');
    }


}
