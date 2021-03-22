<?php

namespace App\Controller;
use App\Controller\IndexRouteController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class IndexRouteController extends AbstractController
{
    
    /**
     * @Route("/accueils", name="accueil")
     */
    public function accueil(Request $request): Response
    {
        return $this->render('accueil.html.twig');
    }
     
       /**
     * @Route("/villageKabes", name="VillageKabe")
     */
    public function villageKabe(Request $request): Response
    {
        return $this->render('villageKabe.html.twig');
    }

     /**
     * @Route("/inscriptions", name="inscription")
     */
    public function inscription(Request $request): Response
    {
        return $this->render('inscription.html.twig');
    }


     /**
     * @Route("/connexions", name="connexion")
     */
    public function connexion(Request $request): Response
    {
        return $this->render('connexion.html.twig');
    }  
    
    /**
     * @Route("/faireUnDons", name="faireUnDon")
     */
    public function faireUnDon(Request $request): Response
    {
        return $this->render('faireUnDon.html.twig');
    }  

     /**
     * @Route("/paiementDons", name="paiementDon")
     */
    public function paiementDon(Request $request): Response
    {
        return $this->render('paiementDon.html.twig');
    }  

    /**
     * @Route("/evenementKabes", name="evenementKabe")
     */
    public function evenementKabe(Request $request): Response
    {
        return $this->render('evenementKabe.html.twig');
    }  

    /**
     * @Route("/nousContacters", name="nousContacter")
     */
    public function nousContacter(Request $request): Response
    {
        return $this->render('nousContacter.html.twig');
    }  

 /**
     * @Route("/projets", name="projet")
     */
    public function projet(Request $request): Response
    {
        return $this->render('projet.html.twig');
    }  

/**
     * @Route("/ventes", name="vente")
     */
    public function vente(Request $request): Response
    {
        return $this->render('vente.html.twig');
    }  

}