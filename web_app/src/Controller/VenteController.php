<?php

namespace App\Controller;

use App\Entity\Vente;
use App\Service\VenteServiceRest;
use App\Service\GeoGouvServiceRest;
use App\Service\IVenteService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class VenteController extends AbstractController
{
    private IVenteService $venteService;

    public function __construct(
        IVenteService $venteService
    ) {
        $this->venteService = $venteService;
    }
    /**
     * @Route("/ventes", name="liste_vente")
     */
    public function index(Request $request): Response
    {
        $page = $request->get("page");
        $limit = $request->get("limit");

        if ($page == null)
            $page = 1;
        if ($limit == null)
            $limit = 5;
        $paginator = $this->venteService->recupererTousVentePagination($page, $limit);
        return $this->render('vente/ventes.html.twig', [
            'paginator' => $paginator
        ]);
    }

    /**
     * @Route("/ventes/{id<^\d+$>}", name="afficher_vente")
     */
    public function afficherVente(int $id): Response
    {
        $vente = $this->venteService->recupererVenteParId($id);
        return $this->render('vente/vente.html.twig', [
            'vente' => $vente
        ]);
    }

    /**
     * @Route("/ventes/inscription", name="inscription_vente",methods={"GET","POST"})
     */
    public function inscriptionVente(Request $request): Response
    {
        if ($request->getMethod() == "GET")
            return $this->render('vente/inscription.vente.html.twig', []);
        else {
            $newVente = new Vente();

            $newVente->setproduit($request->get("produit"));
            $newVente->setevenement($request->get("evenement"));
           

            $newVente = $this->venteService->enregistrerVente($newVente);


            return $this->redirectToRoute("liste_vente", []);
        }
    }

    /**
     * @Route("/ventes/supprimerVente/{id}", name="supprimer_vente",methods={"GET"})
     */
    public function supprimerVente(int $id): Response
    {
        $this->venteService->supprimerVente($id);
        return $this->redirectToRoute("liste_vente", []);
    }

    /**
     * @Route("/{id}/edit", name="vente_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Vente $vente): Response
    {
        $form = $this->createForm(VenteType::class, $vente);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('vente_index');
        }

        return $this->render('vente/edit.html.twig', [
            'vente' => $vente,
            'form' => $form->createView(),
        ]);
    }
}
