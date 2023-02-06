<?php

namespace App\Controller;

use App\Entity\Medidas;
use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class RegistroController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }


    //Función para insertar
    #[Route('insert/registro/', name: 'insert_medidas')]
    public function insert()
    {
        $medidas = new Medidas(4,4,4,4,4,4,4,4,4,4);
        $user = $this->em->getRepository(User::class)->find(3);
        $medidas ->setUser($user);
        $this->em->persist($medidas);
        $this->em->flush();
        return new JsonResponse(['successs'=> true]);
    }
}
