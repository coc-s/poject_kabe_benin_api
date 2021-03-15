<?php

namespace App\Service;

use App\Entity\Evenement;
use App\Entity\PaginatorResponse;
use App\Helper\SerializerHelper;
use Exception;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class EvenementServiceRest implements IEvenementService
{
    private HttpClientInterface $client;
    private SerializerHelper $serializerHelper;

    public function __construct(HttpClientInterface $client,SerializerHelper $serializerHelper)
    {
        $this->serializerHelper=$serializerHelper;
        $this->client=$client;
    }

    public function  recupererTousEvenementPagination(?int $page,?int $limit): PaginatorResponse
    {
        //appler Api
        $response = $this->client->request(
            'GET',
            "http://localhost:8000/api/evenements?page=".($page?$page:"")."&limit=".($limit?$limit:"")
        );
        $statusCode = $response->getStatusCode();
        $content = $response->getContent();
        //envoyer à la vue
        $paginatorEvenement = $this->serializerHelper->deserializePaginator($content,'App\Entity\Evenement'); 
        return $paginatorEvenement;
    }

    public function recupererTousEvenement(): array
    {
        //appler Api
        $response = $this->client->request(
            'GET',
            "http://localhost:8000/api/evenements"
        );
        $statusCode = $response->getStatusCode();
        $content = $response->getContent();
        //deserialiser l'objet
        $evenement = $this->serializerHelper->serializer->deserialize($content, "App\Entity\Evenement[]", 'json');
        //envoyer à la vue

        return $evenement;
    }

    public function recupererEvenementParId(int $id): array
    {
        //appler Api
        $response = $this->client->request(
            'GET',
            "http://localhost:8000/api/evenements/$id"
        );
        $statusCode = $response->getStatusCode();
        $content = $response->getContent();
        //deserialiser l'objet
        $departements = $this->serializerHelper->serialize->deserialize($content, "App\Entity\Departement", 'json');
        //envoyer à la vue

        return $departements;
    }

    public function enregistrerEvenement(Evenement $evenement): evenement
    {
        $evenementTab = $this->serializerHelper->normalizer->normalize($evenement);
        //appler Api
       
        $response = $this->client->request(
            'POST',
            'http://localhost:8000/api/evenements',
            ['json'=> $evenementTab]
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
        $evenement = $this->serializerHelper->serializer->deserialize($content, "App\Entity\Evenement", 'json');
        //envoyer à la vue

        return $evenement;
    }

    public function mettreAjourEvenement(Evenement $evenement): bool
    {
        $evenementTab = $this->serializerHelper->normalizer->normalize($evenement);
        //appler Api
        $response = $this->client->request(
            'PUT',
            "http://localhost:8000/api/evenements/" . $evenement->getId(),
            ["json"=>$evenementTab]
        );

        $statusCode = $response->getStatusCode();

        if ($statusCode != 200) {
            //possible de recuperer les messages d'erreurs ici
            return false;
        }

        return true;
    }
    public function supprimerEvenement(int $id): bool
    {

        $response = $this->client->request(
            "DELETE",
            "http://localhost:8000/api/evenements/$id"
        );

        $statusCode = $response->getStatusCode();

        if ($statusCode != 200) {
            //possible de recuperer les messages d'erreurs ici
            return false;
        }

        return true;
    }

   
}
