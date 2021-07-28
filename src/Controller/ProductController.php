<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Product;

class ProductController extends AbstractController
{
    #[Route('/product', name: 'product')]
    public function index(): Response
    {
        $repo =$this->getDoctrine()->getRepository(Product::class);
        $produits = $repo->findAll();
        return $this->render('product/index.html.twig', [
            'produits' => $produits,
        ]);
    }
}
