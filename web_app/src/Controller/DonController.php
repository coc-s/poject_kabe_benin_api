<?php

namespace App\Controller;

use App\Entity\Don;
use App\Service\DonServiceRest;
use App\Service\IDonService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class DonController extends AbstractController
{
    private IDonService $donService;

    public function __construct(
        IDonService $donService
    ) {
        $this->donService = $donService;
    }
    /**
     * @Route("/dons", name="liste_don")
     */
    public function index(Request $request): Response
    {
        $page = $request->get("page");
        $limit = $request->get("limit");

        if ($page == null)
            $page = 1;
        if ($limit == null)
            $limit = 5;
        $paginator = $this->donService->recupererTousDonPagination($page, $limit);
        return $this->render('Don/dons.html.twig', [
            'paginator' => $paginator
        ]);
    }

    /**
     * @Route("/dons/{id<^\d+$>}", name="afficher_don")
     */
    public function afficherDon(int $id): Response
    {
        $don = $this->donService->recupererDonParId($id);
        return $this->render('Don/don.html.twig', [
            'Don' => $don
        ]);
    }

    /**
     * @Route("/dons/ajoutDon", name="ajout_don",methods={"GET","POST"})
     */
    public function ajoutDon(Request $request): Response
    {
        if ($request->getMethod() == "GET")
            return $this->render('Don/ajout.Don.html.twig', []);
        else {
            $newDon = new Don();

            $newDon->setId($request->get("id"));
            $newDon->setMontant($request->get("montant"));            
            $newDon->setDate($request->get("date"));
           
            $newDon = $this->donService->enregistrerDon($newDon);


            return $this->redirectToRoute("liste_don", []);
        }
    }

    /**
     * @Route("/dons/supprimerDon/{id}", name="supprimer_don",methods={"GET"})
     */
    public function supprimerDon(int $id): Response
    {
        $this->donService->supprimerDon($id);
        return $this->redirectToRoute("liste_don", []);
    }
}
