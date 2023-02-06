<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LegalController extends AbstractController
{
    #[Route('/legal/politica-de-privacidad', name: 'app_politica')]
    public function politica(): Response
    {
        return $this->render('legal/politica.html.twig', [
        ]);
    }

    #[Route('/legal/aviso-legal', name: 'app_legal')]
    public function aviso(): Response
    {
        return $this->render('legal/aviso.html.twig', [
        ]);
    }
}
