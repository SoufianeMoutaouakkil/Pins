<?php

namespace App\Controller;

use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends AbstractController
{
    #[Route('/login', name: 'app_sec_login')]
    public function login(): Response
    {
        return $this->render('security/login.html.twig');
    }
    
    #[Route('/logout', name: 'app_sec_logout')]
    public function logout(): Response
    {
        throw new Exception("There is an error ");
    }

    #[Route('/register', name: 'app_sec_register')]
    public function register(): Response
    {
        return $this->render('security/register.html.twig');
    }
}
