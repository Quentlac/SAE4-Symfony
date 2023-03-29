<?php

namespace App\Controller;

use App\Entity\Etudiant;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'app_default')]
    public function index(): Response
    {
        if ($this->isGranted("ROLE_ADMIN")){
            return $this->redirectToRoute("app_admin_tableau_de_bord_index");
        } else if ($this->isGranted("ROLE_ETUDIANT")){
            return $this->redirectToRoute("app_etudiant_tableau_de_bord_index");
        } else{
            return $this->redirectToRoute("app_login");
        }
    }
}
