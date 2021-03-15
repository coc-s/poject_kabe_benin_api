<?php

namespace App\Controller;

use App\Entity\Parrainage;
use App\Service\ParrainageServiceRest;
use App\Service\GeoGouvServiceRest;
use App\Service\IParrainageService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class ParrainageController extends AbstractController
{
    private IParrainageService $parrainageService;

    public function __construct(
        IParrainageService $parrainageService
    ) {
        $this->parrainageService = $parrainageService;
    }
    /**
     * @Route("/parrainages", name="liste_parrainage")
     */
    public function index(Request $request): Response
    {
        $page = $request->get("page");
        $limit = $request->get("limit");

        if ($page == null)
            $page = 1;
        if ($limit == null)
            $limit = 5;
        $paginator = $this->parrainageService->recupererTousparrainagePagination($page, $limit);
        return $this->render('parrainage/parrainages.html.twig', [
            'paginator' => $paginator
        ]);
    }

    /**
     * @Route("/parrainages/{id<^\d+$>}", name="afficher_parrainage")
     */
    public function afficherParrainage(int $id): Response
    {
        $parrainage = $this->parrainageService->recupererparrainageParId($id);
        return $this->render('parrainage/parrainage.html.twig', [
            'parrainage' => $parrainage
        ]);
    }

    /**
     * @Route("/parrainages/ajout", name="ajout_parrainage",methods={"GET","POST"})
     */
    public function ajoutParrainage(Request $request): Response
    {
        if ($request->getMethod() == "GET")
            return $this->render('parrainage/ajout.parrainage.html.twig', []);
        else {
            $newParrainage = new Parrainage();

            $newParrainage->setNomEnfant($request->get("nom_enfant"));
            $newParrainage->setPrenomEnfant($request->get("prenom_enfant"));
            $newParrainage->setDateNaissEnfant($request->get("date_naiss_enfant"));
            $newParrainage->setSexe($request->get("sexe"));
            $newParrainage->setDateParrainage($request->get("date_parrainage"));
            $newParrainage->setEcole($request->get("ecole"));
            $newParrainage->setVillage($request->get("village"));

            $newParrainage = $this->parrainageService->enregistrerParrainage($newParrainage);


            return $this->redirectToRoute("liste_Parrainage", []);
        }
    }

    /**
     * @Route("/parrainages/supprimerParrainage/{id}", name="supprimer_parrainage",methods={"GET"})
     */
    public function supprimerParrainage(int $id): Response
    {
        $this->parrainageService->supprimerParrainage($id);
        return $this->redirectToRoute("liste_Parrainage", []);
    }
}
