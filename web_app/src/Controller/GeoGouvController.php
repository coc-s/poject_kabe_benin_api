<?php

namespace App\Controller;

use App\Service\GeoGouvServiceRest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class GeoGouvController extends AbstractController
{
    private GeoGouvServiceRest $geoGouvServiceRest;

    public function __construct(GeoGouvServiceRest $geoGouvServiceRest
)
    {
        $this->geoGouvServiceRest=$geoGouvServiceRest;
    }
    /**
     * @Route("/geo/gouvOld", name="geo_gouvOld")
     */
    public function indexOld(): Response
    {
        //appler Api
        $mesRegionJson = file_get_contents("https://geo.api.gouv.fr/regions");
        //deserialiser l'objet
        //$regions = $this->decoder->decode($mesRegionJson,'json');
        //$regions = $this->denormalizer->denormalize($regions,"App\Entity\Region[]");
        
        $regions = $this->serializer->deserialize($mesRegionJson,"App\Entity\Region[]",'json');

        //envoyer à la vue

        return $this->render('geo_gouv/index.html.twig', [
            'regions' => $regions
        ]);
    }

     /**
     * @Route("/geo/gouv/regions", name="geo_gouv_regions")
     */
    public function index(): Response
    {
        $regions = $this->geoGouvServiceRest->recupererToutesRegions();

        
        return $this->render('geo_gouv/index.html.twig', [
            'regions' => $regions
        ]);
    }

     /**
     * @Route("/geo/gouv/departement", name="geo_gouv_departement")
     */
    public function afficherDepartements(Request $request): Response
    {
        $regions = $this->geoGouvServiceRest->recupererToutesRegions();


        $codeRegion = $request->get('code_region');
        if ($codeRegion == null || $codeRegion == "" || $codeRegion == "ToutesRegions") {
            $codeRegion = null;
        } 



        $departements = $this->geoGouvServiceRest->recupererDepartementsParRegion($codeRegion);

        return $this->render('geo_gouv/departements.html.twig', [
            'departements' => $departements,'regions'=>$regions,"selectedCodeRegion" => $codeRegion
        ]);
    }
}
