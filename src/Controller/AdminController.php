<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/Admin')]
class AdminController extends AbstractController
{
    
    #[Route('/homeAdmin', name: 'display_home')]
    public function indexhome(): Response
    {
        return $this->render('admin/home.html.twig' , [
            'controller_name' => 'AdminController',
        ]);
    }



    #[Route('/profile', name: 'display_profile')]
    public function indexProfile(): Response
    {
        return $this->render('admin/profile.html.twig' , [
            'controller_name' => 'AdminController',
        ]);
    }



    #[Route('/dashboard', name: 'display_dashboard')]
    public function indexdashboard(): Response
    {
        return $this->render('admin/dashboard.html.twig' , [
            'controller_name' => 'AdminController',
        ]);
    }



    // #[Route('/tables', name: 'display_tables')]
    // public function indextables(): Response
    // {
    //     return $this->render('admin/tables.html.twig' , [
    //         'controller_name' => 'AdminController',
    //     ]);
    // }



    // #[Route('/billing.', name: 'display_billing')]
    // public function indexbilling(): Response
    // {
    //     return $this->render('admin/billing.html.twig' , [
    //         'controller_name' => 'AdminController',
    //     ]);
    // }



    // #[Route('/notifications', name: 'display_notifications')]
    // public function indexnotifications(): Response
    // {
    //     return $this->render('admin/notifications.html.twig' , [
    //         'controller_name' => 'AdminController',
    //     ]);
    // }



    #[Route('/signin', name: 'display_sign-in')]
    public function indexsignin(): Response
    {
        return $this->render('admin/sign-in.html.twig' , [
            'controller_name' => 'AdminController',
        ]);
    }



    #[Route('/signup', name: 'display_sign-up')]
    public function indexsignup(): Response
    {
        return $this->render('admin/sign-up.html.twig' , [
            'controller_name' => 'AdminController',
        ]);
    
    }
    


    
    // #[Route('/Bilans', name: 'display_Bilans')]
    // public function indexBilan(): Response
    // {
    //     return $this->render('admin/Bilans.html.twig' , [
    //         'controller_name' => 'AdminController',
    //     ]);
    
    // }
}

