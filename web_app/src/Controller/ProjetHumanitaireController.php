<?php

namespace App\Controller;

use App\Entity\ProjetHumanitaire;
use App\Service\ProjetHumanitaireServiceRest;
use App\Service\GeoGouvServiceRest;
use App\Service\IProjetHumanitaireService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class ProjetHumanitaireController extends AbstractController
{
    private IProjetHumanitaireService $projetHumanitaireService;

    public function __construct(
        IProjetHumanitaireService $projetHumanitaireService
    ) {
        $this->ProjetHumanitaireService = $projetHumanitaireService;
    }
    /**
     * @Route("/projetHumanitaires", name="liste_projetHumanitaire")
     */
    public function index(Request $request): Response
    {
        $page = $request->get("page");
        $limit = $request->get("limit");

        if ($page == null)
            $page = 1;
        if ($limit == null)
            $limit = 5;
        $paginator = $this->ProjetHumanitaireService->recupererTousProjetHumanitairePagination($page, $limit);
        return $this->render('projet_humanitaire/projetHumanitaires.html.twig', [
            'paginator' => $paginator
        ]);
    }

    /**
     * @Route("/projetHumanitaires/{id<^\d+$>}", name="afficher_projetHumanitaire")
     */
    public function afficherProjetHumanitaire(int $id): Response
    {
        $projetHumanitaire = $this->ProjetHumanitaireService->recupererProjetHumanitaireParId($id);
        return $this->render('projet_humanitaire/projetHumanitaire.html.twig', [
            'ProjetHumanitaire' => $projetHumanitaire
        ]);
    }

    /**
     * @Route("/projetHumanitaires/ajout", name="ajout_projetHumanitaire",methods={"GET","POST"})
     */
    public function ajoutProjetHumanitaire(Request $request): Response
    {
        if ($request->getMethod() == "GET")
            return $this->render('projet_humanitaire/ajout.projetHumanitaire.html.twig', []);
        else {
            $newProjetHumanitaire = new ProjetHumanitaire();

            $newProjetHumanitaire->setPhoto($request->get("photo"));
            $newProjetHumanitaire->setLibelle($request->get("libelle"));
            $newProjetHumanitaire->setDescription($request->get("descriptif"));


            $newProjetHumanitaire = $this->ProjetHumanitaireService->enregistrerProjetHumanitaire($newProjetHumanitaire);


            return $this->redirectToRoute("liste_projetHumanitaire", []);
        }
    }

    /**
     * @Route("/projetHumanitaires/supprimerProjetHumanitaire/{id}", name="supprimer_projetHumanitaire",methods={"GET"})
     */
    public function supprimerProjetHumanitaire(int $id): Response
    {
        $this->ProjetHumanitaireService->supprimerProjetHumanitaire($id);
        return $this->redirectToRoute("liste_projetHumanitaire", []);
    }
}
