<?php

namespace App\Service;

use App\Entity\Parrainage;
use App\Entity\PaginatorResponse;
use App\Helper\SerializerHelper;
use Exception;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ParrainageServiceRest implements IParrainageService
{
    private HttpClientInterface $client;
    private SerializerHelper $serializerHelper;

    public function __construct(HttpClientInterface $client,SerializerHelper $serializerHelper)
    {
        $this->serializerHelper=$serializerHelper;
        $this->client=$client;
    }

    public function  recupererTousParrainagePagination(?int $page,?int $limit): PaginatorResponse
    {
        //appler Api
        $response = $this->client->request(
            'GET',
            "http://localhost:8000/api/parrainages?page=".($page?$page:"")."&limit=".($limit?$limit:"")
        );
        $statusCode = $response->getStatusCode();
        $content = $response->getContent();
        //envoyer à la vue
        $paginatorParrainage = $this->serializerHelper->deserializePaginator($content,'App\Entity\Parrainage'); 
        return $paginatorParrainage;
    }

    public function recupererTousParrainage(): array
    {
        //appler Api
        $response = $this->client->request(
            'GET',
            "http://localhost:8000/api/parrainages"
        );
        $statusCode = $response->getStatusCode();
        $content = $response->getContent();
        //deserialiser l'objet
        $parrainage = $this->serializerHelper->serializer->deserialize($content, "App\Entity\Parrainage[]", 'json');
        //envoyer à la vue

        return $parrainage;
    }

    public function recupererParrainageParId(int $id): array
    {
        //appler Api
        $response = $this->client->request(
            'GET',
            "http://localhost:8000/api/parrainages/$id"
        );
        $statusCode = $response->getStatusCode();
        $content = $response->getContent();
        //deserialiser l'objet
        $departements = $this->serializerHelper->serialize->deserialize($content, "App\Entity\Departement", 'json');
        //envoyer à la vue

        return $departements;
    }

    public function enregistrerParrainage(Parrainage $parrainage): Parrainage
    {
        $parrainageTab = $this->serializerHelper->normalizer->normalize($parrainage);
        //appler Api
       
        $response = $this->client->request(
            'POST',
            'http://localhost:8000/api/parrainages',
            ['json'=> $parrainageTab]
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
        $parrainage = $this->serializerHelper->serializer->deserialize($content, "App\Entity\Parrainage", 'json');
        //envoyer à la vue

        return $parrainage;
    }

    public function mettreAjourParrainage(Parrainage $parrainage): bool
    {
        $parrainageTab = $this->serializerHelper->normalizer->normalize($parrainage);
        //appler Api
        $response = $this->client->request(
            'PUT',
            "http://localhost:8000/api/parrainages/" . $parrainage->getId(),
            ["json"=>$parrainageTab]
        );

        $statusCode = $response->getStatusCode();

        if ($statusCode != 200) {
            //possible de recuperer les messages d'erreurs ici
            return false;
        }

        return true;
    }
    public function supprimerParrainage(int $id): bool
    {

        $response = $this->client->request(
            "DELETE",
            "http://localhost:8000/api/parrainages/$id"
        );

        $statusCode = $response->getStatusCode();

        if ($statusCode != 200) {
            //possible de recuperer les messages d'erreurs ici
            return false;
        }

        return true;
    }

   
}
