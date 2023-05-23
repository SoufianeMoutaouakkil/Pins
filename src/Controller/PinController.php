<?php

namespace App\Controller;

use App\Entity\Pin;
use App\Form\PinType;
use Psr\Log\LoggerInterface;
use App\Repository\PinRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[IsGranted("ROLE_USER")]
class PinController extends AbstractController
{
    #[Route('/pin', name: 'pin_index')]
    public function index(PinRepository $pinRepo): Response
    {
        return $this->render('pin/index.html.twig', [
            'pins' => $pinRepo->findAll(),
        ]);
    }

    #[Route('/pin/{id}', name: 'pin_show', requirements: ['id' => '\d+'])]
    public function show(Pin $pin): Response
    {
        return $this->render(
            'pin/show.html.twig',
            compact('pin')    
        );
    }

    #[Route('/pin/create', name: 'pin_create')]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $pin = new Pin();
        $form = $this->createForm(PinType::class, $pin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($pin);
            $em->flush();

            return $this->redirectToRoute('pin_show', ['id' => $pin->getId()]);
        }

        return $this->render('pin/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/pin/update/{id}', name: 'pin_update', requirements: ['id' => '\d+'])]
    public function update(LoggerInterface $logger, Pin $pin, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(PinType::class, $pin);
        $form->handleRequest($request);

        $logger->debug("########");
        $logger->debug($pin->getImageName());
        $logger->debug($pin->getDescription());

        if ($form->isSubmitted()) {
            $logger->debug($form->isValid()?"Valid":"Not valid");
            // dd($form->getErrors(true));
            if ($form->isValid()) {
                $em->persist($pin);
                $em->flush();

                return $this->redirectToRoute('pin_show', ['id' => $pin->getId()]);
            }
        }

        return $this->render('pin/update.html.twig', [
            'form' => $form->createView(),
            'pin' => $pin
        ]);
    }
}
