<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Service\AdminServiceRest;
use App\Service\GeoGouvServiceRest;
use App\Service\IAdminService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends AbstractController
{
    private IAdminService $adminService;

    public function __construct(
        IAdminService $adminService
    ) {
        $this->adminService = $adminService;
    }
    /**
     * @Route("/admins", name="liste_Admin")
     */
    public function index(Request $request): Response
    {
        $page = $request->get("page");
        $limit = $request->get("limit");

        if ($page == null)
            $page = 1;
        if ($limit == null)
            $limit = 5;
        $paginator = $this->adminService->recupererTousAdminPagination($page, $limit);
        return $this->render('admin/admins.html.twig', [
            'paginator' => $paginator
        ]);
    }

    /**
     * @Route("/admins/{id<^\d+$>}", name="afficher_admin")
     */
    public function afficherAdmin(int $id): Response
    {
        $admin = $this->adminService->recupererAdminParId($id);
        return $this->render('admin/admin.html.twig', [
            'admin' => $admin
        ]);
    }

    /**
     * @Route("/admins/inscription", name="inscription_admin",methods={"GET","POST"})
     */
    public function inscriptionAdmin(Request $request): Response
    {
        if ($request->getMethod() == "GET")
            return $this->render('admin/inscription.admin.html.twig', []);
        else {
            $newAdmin = new Admin();

            $newAdmin = $this->adminService->enregistrerAdmin($newAdmin);


            return $this->redirectToRoute("liste_Admin", []);
        }
    }

    /**
     * @Route("/admins/supprimerAdmin/{id}", name="supprimer_admin",methods={"GET"})
     */
    public function supprimerAdmin(int $id): Response
    {
        $this->adminService->supprimerAdmin($id);
        return $this->redirectToRoute("liste_Admin", []);
    }
}
