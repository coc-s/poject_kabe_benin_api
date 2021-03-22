<?php

namespace App\Service;

use App\Entity\Vente;
use App\Entity\PaginatorResponse;
use App\Helper\SerializerHelper;
use Exception;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class VenteServiceRest implements IVenteService
{
    private HttpClientInterface $client;
    private SerializerHelper $serializerHelper;

    public function __construct(HttpClientInterface $client,SerializerHelper $serializerHelper)
    {
        $this->serializerHelper=$serializerHelper;
        $this->client=$client;
    }

    public function  recupererTousVentePagination(?int $page,?int $limit): PaginatorResponse
    {
        //appler Api
        $response = $this->client->request(
            'GET',
            "http://localhost:8000/api/ventes?page=".($page?$page:"")."&limit=".($limit?$limit:"")
        );
        $statusCode = $response->getStatusCode();
        $content = $response->getContent();
        //envoyer à la vue
        $paginatorVente = $this->serializerHelper->deserializePaginator($content,'App\Entity\Vente'); 
        return $paginatorVente;
    }

    public function recupererTousVente(): array
    {
        //appler Api
        $response = $this->client->request(
            'GET',
            "http://localhost:8000/api/ventes"
        );
        $statusCode = $response->getStatusCode();
        $content = $response->getContent();
        //deserialiser l'objet
        $vente = $this->serializerHelper->serializer->deserialize($content, "App\Entity\Vente[]", 'json');
        //envoyer à la vue

        return $vente;
    }

    public function recupererVenteParId(int $id): array
    {
        //appler Api
        $response = $this->client->request(
            'GET',
            "http://localhost:8000/api/ventes/$id"
        );
        $statusCode = $response->getStatusCode();
        $content = $response->getContent();
        //deserialiser l'objet
        $ventes[]= $this->serializerHelper->serializer->deserialize($content, "App\Entity\Vente", 'json');
        //envoyer à la vue

        return $ventes;
    }

    public function enregistrerVente(Vente $vente): Vente
    {
        $venteTab = $this->serializerHelper->normalizer->normalize($vente);
        //appler Api
       
        $response = $this->client->request(
            'POST',
            'http://localhost:8000/api/ventes',
            ['json'=> $venteTab]
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
        $vente = $this->serializerHelper->serializer->deserialize($content, "App\Entity\Vente", 'json');
        //envoyer à la vue

        return $vente;
    }

    public function mettreAjourVente(Vente $vente): bool
    {
        $venteTab = $this->serializerHelper->normalizer->normalize($vente);
        //appler Api
        $response = $this->client->request(
            'PUT',
            "http://localhost:8000/api/ventes/" . $vente->getId(),
            ["json"=>$venteTab]
        );

        $statusCode = $response->getStatusCode();

        if ($statusCode != 200) {
            //possible de recuperer les messages d'erreurs ici
            return false;
        }

        return true;
    }
    public function supprimerVente(int $id): bool
    {

        $response = $this->client->request(
            "DELETE",
            "http://localhost:8000/api/ventes/$id"
        );

        $statusCode = $response->getStatusCode();

        if ($statusCode != 200) {
            //possible de recuperer les messages d'erreurs ici
            throw new Exception("Suppression impossible");

            return false;
        }

        return true;
    }

   
}
