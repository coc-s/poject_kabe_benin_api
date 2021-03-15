<?php

namespace App\Service;

use App\Entity\Region;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\Serializer\Encoder\DecoderInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class GeoGouvServiceRest 
{
    private SerializerInterface $serializer;
    private HttpClientInterface $client;

    public function __construct(HttpClientInterface $client,SerializerInterface $serializer)
    {
        $this->serializer= $serializer;
        $this->client = $client;
    }
    
    public function recupererToutesRegions(): array
    {
        //appler Api
        $response = $this->client->request(
            'GET',
            'https://geo.api.gouv.fr/regions'
        );
        $statusCode = $response->getStatusCode();
        $content = $response->getContent();
        //deserialiser l'objet
        $regions = $this->serializer->deserialize($content,"App\Entity\Region[]",'json');
        //envoyer à la vue

        return $regions;
    }

    public function recupererTousDepartements(): array
    {
        //appler Api
        $response = $this->client->request(
            'GET',
            'https://geo.api.gouv.fr/departements'
        );
        $statusCode = $response->getStatusCode();
        $content = $response->getContent();
        //deserialiser l'objet
        $departements = $this->serializer->deserialize($content,"App\Entity\Departement[]",'json');
        //envoyer à la vue

        return $departements;
    }

    public function recupererDepartementsParRegion(string $codeRegion=null): array
    {
        if ($codeRegion == null) {
            $url = "https://geo.api.gouv.fr/departements";
        } else {
            $url = "https://geo.api.gouv.fr/regions/$codeRegion/departements";
        }

        $response = $this->client->request(
            'GET',
            $url
        );
        $statusCode = $response->getStatusCode();
        $content = $response->getContent();
        //deserialiser l'objet
        $departements = $this->serializer->deserialize($content,"App\Entity\Departement[]",'json');
        //envoyer à la vue

        return $departements;
    }

  
}
