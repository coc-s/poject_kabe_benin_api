<?php

namespace App\Service;

use App\Entity\Don;
use App\Entity\PaginatorResponse;
use App\Helper\SerializerHelper;
use Exception;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class DonServiceRest implements IDonService
{
    private HttpClientInterface $client;
    private SerializerHelper $serializerHelper;

    public function __construct(HttpClientInterface $client,SerializerHelper $serializerHelper)
    {
        $this->serializerHelper=$serializerHelper;
        $this->client=$client;
    }

    public function  recupererTousDonPagination(?int $page,?int $limit): PaginatorResponse
    {
        //appler Api
        $response = $this->client->request(
            'GET',
            "http://localhost:8000/api/dons?page=".($page?$page:"")."&limit=".($limit?$limit:"")
        );
        $statusCode = $response->getStatusCode();
        $content = $response->getContent();
        //envoyer à la vue
        $paginatorDon = $this->serializerHelper->deserializePaginator($content,'App\Entity\Don'); 
        return $paginatorDon;
    }

    public function recupererTousDon(): array
    {
        //appler Api
        $response = $this->client->request(
            'GET',
            "http://localhost:8000/api/dons"
        );
        $statusCode = $response->getStatusCode();
        $content = $response->getContent();
        //deserialiser l'objet
        $don = $this->serializerHelper->serializer->deserialize($content, "App\Entity\Don[]", 'json');
        //envoyer à la vue

        return $don;
    }

    public function recupererDonParId(int $id): array
    {
        //appler Api
        $response = $this->client->request(
            'GET',
            "http://localhost:8000/api/dons/$id"
        );
        $statusCode = $response->getStatusCode();
        $content = $response->getContent();
        //deserialiser l'objet
        $departements = $this->serializerHelper->serialize->deserialize($content, "App\Entity\Departement", 'json');
        //envoyer à la vue

        return $departements;
    }

    public function enregistrerDon(Don $don): Don
    {
        $donTab = $this->serializerHelper->normalizer->normalize($don);
        //appler Api
       
        $response = $this->client->request(
            'POST',
            'http://localhost:8000/api/dons',
            ['json'=> $donTab]
        );

        $statusCode = $response->getStatusCode();

        if ($statusCode != 201) {
            throw new Exception("Creation impossible");
        }

        $url = $response->getHeaders()["location"][0];

        $response = $this->client->request(
            'GET',
            'http://localhost:8000' . $url
        );

        $statusCode = $response->getStatusCode();
        if ($statusCode != 200) {
            throw new Exception("Creation ok mais recuperation impossible");
        }

        $content = $response->getContent();
        //deserialiser l'objet
        $don = $this->serializerHelper->serializer->deserialize($content, "App\Entity\Don", 'json');
        //envoyer à la vue

        return $don;
    }

    public function mettreAjourDon(Don $don): bool
    {
        $donTab = $this->serializerHelper->normalizer->normalize($don);
        //appler Api
        $response = $this->client->request(
            'PUT',
            "http://localhost:8000/api/dons/" . $don->getId(),
            ["json"=>$donTab]
        );

        $statusCode = $response->getStatusCode();

        if ($statusCode != 200) {
            //possible de recuperer les messages d'erreurs ici
            return false;
        }

        return true;
    }
    public function supprimerDon(int $id): bool
    {

        $response = $this->client->request(
            "DELETE",
            "http://localhost:8000/api/dons/$id"
        );

        $statusCode = $response->getStatusCode();

        if ($statusCode != 200) {
            throw new Exception("Supression impossible");
            return false;
        }

        return true;
    }

   
}
