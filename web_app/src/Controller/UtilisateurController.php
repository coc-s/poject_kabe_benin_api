<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Service\UtilisateurServiceRest;
use App\Service\GeoGouvServiceRest;
use App\Service\IUtilisateurService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class UtilisateurController extends AbstractController
{
    private IUtilisateurService $utilisateurService;

    public function __construct(
        IUtilisateurService $utilisateurService
    ) {
        $this->UtilisateurService = $utilisateurService;
    }
    /**
     * @Route("/Utilisateurs", name="liste_Utilisateur")
     */
    public function index(Request $request): Response
    {
        $page = $request->get("page");
        $limit = $request->get("limit");

        if ($page == null)
            $page = 1;
        if ($limit == null)
            $limit = 5;
        $paginator = $this->UtilisateurService->recupererTousUtilisateurPagination($page, $limit);
        return $this->render('Utilisateur/Utilisateurs.html.twig', [
            'paginator' => $paginator
        ]);
    }

    /**
     * @Route("/Utilisateurs/{id<^\d+$>}", name="afficher_Utilisateur")
     */
    public function afficherUtilisateur(int $id): Response
    {
        $utilisateur = $this->UtilisateurService->recupererUtilisateurParId($id);
        return $this->render('Utilisateur/Utilisateur.html.twig', [
            'Utilisateur' => $utilisateur
        ]);
    }

    /**
     * @Route("/Utilisateurs/inscription", name="inscription_Utilisateur",methods={"GET","POST"})
     */
    public function inscriptionUtilisateur(Request $request): Response
    {
        if ($request->getMethod() == "GET")
            return $this->render('Utilisateur/ajout.Utilisateur.html.twig', []);
        else {
            $newUtilisateur = new Utilisateur();

            $newUtilisateur->setNom($request->get("nom"));
            $newUtilisateur->setPrenom($request->get("prenom"));
            $newUtilisateur->setEmail($request->get("email"));
            $newUtilisateur->setTelephone($request->get("telephone"));
            $newUtilisateur->setAdresse($request->get("adresse"));
            $newUtilisateur->setCodePostal($request->get("codePostal"));
            $newUtilisateur->setVille($request->get("ville"));
            $newUtilisateur->setPassword($request->get("password"));

            $newUtilisateur = $this->UtilisateurService->enregistrerUtilisateur($newUtilisateur);


            return $this->redirectToRoute("Utilisateur", []);
        }
    }

    /**
     * @Route("/Utilisateurs/supprimerUtilisateur/{id<^\d+$>}", name="supprimer_Utilisateur",methods={"GET"})
     */
    public function supprimerUtilisateur(int $id): Response
    {
        
        $this->UtilisateurService->supprimerUtilisateur($id);
        return $this->redirectToRoute("liste_Utilisateur", []);
    }
}
