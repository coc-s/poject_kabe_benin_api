<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Service\EvenementServiceRest;
use App\Service\IEvenementService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class EvenementController extends AbstractController
{
    private IEvenementService $EvenementService;

    public function __construct(
        IEvenementService $EvenementService
    ) {
        $this->EvenementService = $EvenementService;
    }
    /**
     * @Route("/Evenements", name="liste_Evenement")
     */
    public function index(Request $request): Response
    {
        $page = $request->get("page");
        $limit = $request->get("limit");

        if ($page == null)
            $page = 1;
        if ($limit == null)
            $limit = 5;
        $paginator = $this->EvenementService->recupererTousEvenementPagination($page, $limit);
        return $this->render('Evenement/Evenements.html.twig', [
            'paginator' => $paginator
        ]);
    }

    /**
     * @Route("/Evenements/{id<^\d+$>}", name="afficher_Evenement")
     */
    public function afficherEvenement(int $id): Response
    {
        $Evenement = $this->EvenementService->recupererEvenementParId($id);
        return $this->render('Evenement/Evenement.html.twig', [
            'Evenement' => $Evenement
        ]);
    }

    /**
     * @Route("/Evenements/ajoutEvenement", name="ajout_Evenement",methods={"GET","POST"})
     */
    public function ajoutEvenement(Request $request): Response
    {
        if ($request->getMethod() == "GET")
            return $this->render('Evenement/ajout.Evenement.html.twig', []);
        else {
            $newEvenement = new Evenement();

            $newEvenement->setLibelle($request->get("libelle"));
            $newEvenement->setDate($request->get("date"));
           
            $newEvenement = $this->EvenementService->enregistrerEvenement($newEvenement);


            return $this->redirectToRoute("liste_Evenement", []);
        }
    }

    /**
     * @Route("/Evenements/supprimerEvenement/{id}", name="supprimer_Evenement",methods={"GET"})
     */
    public function supprimerEvenement(int $id): Response
    {
        $this->EvenementService->supprimerEvenement($id);
        return $this->redirectToRoute("liste_Evenement", []);
    }
}
