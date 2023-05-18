<?php

namespace App\Controller;

use App\Form\UserType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
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
    public function register(Request $req, UserPasswordHasherInterface $passHasher, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(UserType::class);

        $form->handleRequest($req);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $password = $form->get("plain_password")->getData();
            $hashedPassword = $passHasher->hashPassword($user, $password);
            $user->setPassword($hashedPassword);

            $em->persist($user);
            $em->flush();

            $this->addFlash('success', "User created successfully!");
        }

        return $this->render('security/register.html.twig', ['form'=> $form->createView()]);
    }
}
