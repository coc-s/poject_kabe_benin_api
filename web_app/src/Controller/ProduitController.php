<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Service\ProduitServiceRest;
use App\Service\GeoGouvServiceRest;
use App\Service\IProduitService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class ProduitController extends AbstractController
{
    private IProduitService $produitService;

    public function __construct(
        IProduitService $produitService
    ) {
        $this->ProduitService = $produitService;
    }
    /**
     * @Route("/Produits", name="liste_Produit")
     */
    public function index(Request $request): Response
    {
        $page = $request->get("page");
        $limit = $request->get("limit");

        if ($page == null)
            $page = 1;
        if ($limit == null)
            $limit = 5;
        $paginator = $this->ProduitService->recupererTousProduitPagination($page, $limit);
        return $this->render('Produit/Produits.html.twig', [
            'paginator' => $paginator
        ]);
    }

    /**
     * @Route("/Produits/{id<^\d+$>}", name="afficher_Produit")
     */
    public function afficherProduit(int $id): Response
    {
        $produit = $this->ProduitService->recupererProduitParId($id);
        return $this->render('Produit/Produit.html.twig', [
            'Produit' => $produit
        ]);
    }

    /**
     * @Route("/Produits/ajout", name="ajout_Produit",methods={"GET","POST"})
     */
    public function ajoutProduit(Request $request): Response
    {
        if ($request->getMethod() == "GET")
            return $this->render('Produit/ajout.produit.html.twig', []);
        else {
            $newProduit = new Produit();

            $newProduit->setLibelle($request->get("libelle"));
            $newProduit->setDescription($request->get("descriptif"));
            $newProduit->setPrix($request->get("prix"));
            $newProduit->setQuantite($request->get("quantite"));
            $newProduit->setDisponibilite($request->get("disponibilite"));
            // $newProduit->setPhoto($request->get("photo"));
            // $newProduit->setEvenement($request->get("evenement"));

            $newProduit = $this->ProduitService->enregistrerProduit($newProduit);


            return $this->redirectToRoute("liste_Produit", []);
        }
    }

    /**
     * @Route("/Produits/supprimerProduit/{id}", name="supprimer_Produit",methods={"GET"})
     */
    public function supprimerProduit(int $id): Response
    {
        $this->ProduitService->supprimerProduit($id);
        return $this->redirectToRoute("liste_Produit", []);
    }
}
