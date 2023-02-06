<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Curso;
use App\Form\CursoType;
use Doctrine\ORM\EntityManagerInterface;

class IndexController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
    $this->em = $em;
    }

    #[Route('/', name: 'app_index')]
    public function index(): Response
    {
        $cursos = $this->em->getRepository(Curso::class)->findAllCursos();
        return $this->render('index/index.html.twig', [
            'cursos'=>$cursos,
        ]);
    }
}
