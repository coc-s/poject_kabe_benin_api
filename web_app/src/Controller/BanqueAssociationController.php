<?php

namespace App\Controller;

use App\Entity\BanqueAssociation;
use App\Service\IBanqueAssociationService;
use App\Service\BanqueAssociationServiceRest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BanqueAssociationController extends AbstractController
{
    private IBanqueAssociationService $banqueAssociationService;

    public function __construct(
        IBanqueAssociationService $banqueAssociationService
    ) {
        $this->banqueAssociationService = $banqueAssociationService;
    }
    /**
     * @route("/banqueAssociations", name="liste_banqueAssociation",methods={"GET"})
     */
    public function index(Request $request): Response
    {
        $page = $request->get("page");
        $limit = $request->get("limit");

        if ($page == null)
            $page = 1;
        if ($limit == null)
            $limit = 5;
        $paginator = $this->banqueAssociationService->recupererTousBanqueAssociationPagination($page, $limit);
        return $this->render('BanqueAssociation/banqueAssociations.html.twig', [
            'paginator' => $paginator
        ]);
    }

    /**
     * @Route("/banqueAssociations/{id<^\d+$>}", name="afficher_banqueAssociation")
     */
    public function afficherBanqueAssociation(int $id): Response
    {
        $banqueAssociation = $this->banqueAssociationService->recupererBanqueAssociationParId($id);
        return $this->render('BanqueAssociation/banqueAssociation.html.twig', [
            'BanqueAssociation' => $banqueAssociation
        ]);
    }

    /**
     * @Route("/banqueAssociations/inscription", name="inscription_banqueAssociation",methods={"GET","POST"})
     */
    public function inscriptionBanqueAssociation(Request $request): Response
    {
        if ($request->getMethod() == "GET")
            return $this->render('BanqueAssociation/inscription.BanqueAssociation.html.twig', []);
        else {
            $newBanqueAssociation = new BanqueAssociation();

            $newBanqueAssociation = $this->banqueAssociationService->enregistrerBanqueAssociation($newBanqueAssociation);


            return $this->redirectToRoute("liste_banqueAssociation", []);
        }
    }

    /**
     * @Route("/banqueAssociations/supprimerBanqueAssociation/{id}", name="supprimer_banqueAssociation",methods={"GET"})
     */
    public function supprimerBanqueAssociation(int $id): Response
    {
        $this->banqueAssociationService->supprimerBanqueAssociation($id);
        return $this->redirectToRoute("liste_banqueAssociation", []);
    }
}
