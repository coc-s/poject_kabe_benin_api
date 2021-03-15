<?php

namespace App\Controller;

use App\Entity\Adherent;
use App\Service\AdherentServiceRest;
use App\Service\GeoGouvServiceRest;
use App\Service\IAdherentService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class AdherentController extends AbstractController
{
    private IAdherentService $adherentService;

    public function __construct(
        IAdherentService $adherentService
    ) {
        $this->adherentService = $adherentService;
    }
    /**
     * @Route("/adherents", name="liste_adherent")
     */
    public function index(Request $request): Response
    {
        $page = $request->get("page");
        $limit = $request->get("limit");

        if ($page == null)
            $page = 1;
        if ($limit == null)
            $limit = 5;
        $paginator = $this->adherentService->recupererTousAdherentPagination($page, $limit);
        return $this->render('adherent/adherents.html.twig', [
            'paginator' => $paginator
        ]);
    }

    /**
     * @Route("/adherents/{id<^\d+$>}", name="afficher_adherent")
     */
    public function afficherAdherent(int $id): Response
    {
        $adherent = $this->adherentService->recupererAdherentParId($id);
        return $this->render('adherent/adherent.html.twig', [
            'adherent' => $adherent
        ]);
    }

    /**
     * @Route("/adherents/inscription", name="inscription_adherent",methods={"GET","POST"})
     */
    public function inscriptionAdherent(Request $request): Response
    {
        if ($request->getMethod() == "GET")
            return $this->render('adherent/inscription.adherent.html.twig', []);
        else {
            $newAdherent = new Adherent();

            $newAdherent->setparrainage($request->get("parrainage"));
            $newAdherent->setevenement($request->get("evenement"));
            $newAdherent->setdon($request->get("don"));
           

            $newAdherent = $this->adherentService->enregistrerAdherent($newAdherent);


            return $this->redirectToRoute("liste_adherent", []);
        }
    }

    /**
     * @Route("/adherents/supprimerAdherent/{id}", name="supprimer_adherent",methods={"GET"})
     */
    public function supprimerAdherent(int $id): Response
    {
        $this->adherentService->supprimerAdherent($id);
        return $this->redirectToRoute("liste_adherent", []);
    }
}
