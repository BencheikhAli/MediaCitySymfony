<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Personne;
use App\Form\PersonneType;
use App\Form\PersonneTypeV2;
use App\Service\FullnameService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
/**
    *@IsGranted("ROLE_ADMIN")
 */
class PersonneController extends AbstractController
{
    #[Route('/personne', name: 'personne')]
    public function index(FullnameService $fullnameService): Response
    {
        $repo =$this->getDoctrine()->getRepository(Personne::class);
        $personnes = $repo->findAll();
        // $fullnameService = new FullnameService();
        foreach ($personnes as $p) {
            $p->nomComplet = $fullnameService->getFullname($p->getPrenom(), $p->getNom());
        }
        return $this->render('personne/index.html.twig', [
            'personnes' => $personnes,
        ]);
    }
    #[Route('/personne/add', name: 'personne_add', methods: ['GET', 'POST'])]
    public function add(Request $request): Response
    {
        $personne = new Personne();
        $form = $this->createForm(PersonneType::class, $personne);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $personne = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($personne);
            $em->flush();
            return $this->redirectToRoute("personne"); 
        }
        return $this->render('personne/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #[Route('/personne/add2', name: 'personne_add2', methods: ['GET', 'POST'])]
    public function add2(Request $request): Response
    {
        $personne = new Personne();
        $form = $this->createForm(PersonneTypeV2::class, $personne);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $personne = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($personne);
            $em->flush();
            return $this->redirectToRoute("personne"); 
        }
        return $this->render('personne/addV2.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #[Route('/personne/delete/{id}', name: 'personne_delete', methods: ['DELETE'])]
    public function delete(Personne $personne): Response
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($personne);
        $em->flush();
        return $this->redirectToRoute('personne');
    }



}

