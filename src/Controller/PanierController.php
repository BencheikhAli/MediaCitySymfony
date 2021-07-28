<?php
//https://sharemycode.fr/vax
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\LignePanier;
use App\Entity\Panier;
use App\Entity\Product;

class PanierController extends AbstractController
{
    #[Route('/panier', name: 'panier', methods: ['GET'])]
    public function index(SessionInterface $session): Response
    {
        $panier = $session->get("panier", new Panier());
        return $this->render('panier/index.html.twig', [
            'panier' => $panier,
        ]);
    }
    #[Route('/panier/add', name: 'panier_add', methods: 'POST')]
    public function add(SessionInterface $session, Request $request): Response
    {
        //get id produit
        $idProduit = $request->get("id");
        //get produit
        $repo = $this->getDoctrine()->getRepository(Product::class);
        $produit = $repo->find($idProduit);

        //get quantite
        $quantite = $request->get("quantite");

        // créer lignepanier
        $lignePanier = new LignePanier();
        $lignePanier->setProduit($produit);
        $lignePanier->setQuantite($quantite);
        //get panier
        $panier = $session->get("panier", new Panier());
        $panier->addLignePanier($lignePanier);
        $session->set("panier", $panier);
        //http://localhost:8000/panier/add?id=1&quantite=5
        // return $this->redirectToRoute("panier");
        return $this->json(["res"=>"OK"]);
    }
    #[Route('/panier/edit', name: 'panier_edit', methods:'POST')]
    public function edit(SessionInterface $session, Request $request): Response
    {
        $id = $request->get("id");
        $quantite = $request->get("quantite");
        $panier = $session->get("panier", new Panier());
        $err = "";
        if($quantite == 0){
            try {
                $panier->removeLignePanier($id);
            } catch (\Throwable $th) {
                $err = $th->getMessage();
            }
            
        }
        else{
            $panier->updateLignePanier($id, $quantite);
        }
        $session->set("panier", $panier);
        return $this->json(["res"=>"OK", "err"=>$err]);
    }
}
