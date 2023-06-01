<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ReclamationRepository;
use phpseclib\Crypt\RSA;
#[Route('/Client')]
class ClientController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function home(): Response
    {
        return $this->render('client/home.html.twig', [
            'controller_name' => 'ClientController',
        ]);
    }
    #[Route('/header', name: 'app_header')]
    public function header(): Response
    {
        return $this->render('client/header.html.twig', [
            'controller_name' => 'ClientController',
        ]);
    }

    #[Route('/Contactus', name: 'app_Contactus')]
    public function contactus(): Response
    {
        return $this->render('client/Contactus.html.twig', [
            'controller_name' => 'ClientController',
        ]);
    }


    #[Route('/Aboutus', name: 'app_Aboutus')]
    public function Aboutus(): Response
    {
        return $this->render('client/Aboutus.html.twig', [
            'controller_name' => 'ClientController',
        ]);
    }

    #[Route('/E404', name: 'app_E404')]
    public function E404(): Response
    {
        return $this->render('client/E404.html.twig', [
            'controller_name' => 'ClientController',
        ]);
    }
    #[Route('/Actualites', name: 'app_Actualites')]
    public function Actualites(): Response
    {
        return $this->render('client/Actualites.html.twig', [
            'controller_name' => 'ClientController',
        ]);
    }


    #[Route('/ActualiteInfo', name: 'app_ActualiteInfo')]
    public function ActualiteInfo(): Response
    {
        return $this->render('client/ActualiteInfo.html.twig', [
            'controller_name' => 'ClientController',
        ]);
    }


    #[Route('/EspaceClient', name: 'app_EspaceClient')]
    public function EspaceClient(): Response
    {
        return $this->render('client/EspaceClient.html.twig', [
            'controller_name' => 'ClientController',
        ]);
    }


    #[Route('/EspaceVeterinaire', name: 'app_EspaceVeterinaire')]
    public function EspaceVeterinaire(): Response
    {
        return $this->render('client/EspaceVeterinaire.html.twig', [
            'controller_name' => 'ClientController',
        ]);
    }


    #[Route('/BilansDesoin', name: 'app_BilansDesoin')]
    public function BilansDesoin(): Response
    {
        return $this->render('client/BilansDesoin.html.twig', [
            'controller_name' => 'ClientController',
        ]);
    }

    #[Route('/BilanDesoin', name: 'app_BilanDesoin')]
    public function BilanDesoin(): Response
    {
        return $this->render('client/BilanDesoin.html.twig', [
            'controller_name' => 'ClientController',
        ]);
    }
     #[Route('/afficher', name: 'app_afficher', methods: ['GET'])]
    public function afficher(ReclamationRepository $repository): Response
    {
       $reclamation = $repository->findByidreclamation('2');
    



        return $this->render('Client/afficher.html.twig', [
            'reclamations' => $reclamation,
        ]);
        
    }
    

}
