<?php

namespace App\Service;

use App\Entity\Produit;
use App\Entity\PaginatorResponse;
use App\Helper\SerializerHelper;
use Exception;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ProduitServiceRest implements IProduitService
{
    private HttpClientInterface $client;
    private SerializerHelper $serializerHelper;

    public function __construct(HttpClientInterface $client,SerializerHelper $serializerHelper)
    {
        $this->serializerHelper=$serializerHelper;
        $this->client=$client;
    }

    public function  recupererTousProduitPagination(?int $page,?int $limit): PaginatorResponse
    {
        //appler Api
        $response = $this->client->request(
            'GET',
            "http://localhost:8000/api/produits?page=".($page?$page:"")."&limit=".($limit?$limit:"")
        );
        $statusCode = $response->getStatusCode();
        $content = $response->getContent();
        //envoyer à la vue
        $paginatorProduit = $this->serializerHelper->deserializePaginator($content,'App\Entity\Produit'); 
        return $paginatorProduit;
    }

    public function recupererTousProduit(): array
    {
        //appler Api
        $response = $this->client->request(
            'GET',
            "http://localhost:8000/api/produits"
        );
        $statusCode = $response->getStatusCode();
        $content = $response->getContent();
        //deserialiser l'objet
        $produit = $this->serializerHelper->serializer->deserialize($content, "App\Entity\Produit[]", 'json');
        //envoyer à la vue

        return $produit;
    }

    public function recupererProduitParId(int $id): array
    {
        //appler Api
        $response = $this->client->request(
            'GET',
            "http://localhost:8000/api/produits/$id"
        );
        $statusCode = $response->getStatusCode();
        $content = $response->getContent();
        //deserialiser l'objet
        $departements = $this->serializerHelper->serialize->deserialize($content, "App\Entity\Departement", 'json');
        //envoyer à la vue

        return $departements;
    }

    public function enregistrerProduit(Produit $produit): Produit
    {
        $produitTab = $this->serializerHelper->normalizer->normalize($produit);
        //appler Api
       
        $response = $this->client->request(
            'POST',
            'http://localhost:8000/api/produits',
            ['json'=> $produitTab]
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
        $produit = $this->serializerHelper->serializer->deserialize($content, "App\Entity\Produit", 'json');
        //envoyer à la vue

        return $produit;
    }

    public function mettreAjourProduit(Produit $produit): bool
    {
        $produitTab = $this->serializerHelper->normalizer->normalize($produit);
        //appler Api
        $response = $this->client->request(
            'PUT',
            "http://localhost:8000/api/produits/" . $produit->getId(),
            ["json"=>$produitTab]
        );

        $statusCode = $response->getStatusCode();

        if ($statusCode != 200) {
            //possible de recuperer les messages d'erreurs ici
            return false;
        }

        return true;
    }
    public function supprimerProduit(int $id): bool
    {

        $response = $this->client->request(
            "DELETE",
            "http://localhost:8000/api/produits/$id"
        );

        $statusCode = $response->getStatusCode();

        if ($statusCode != 200) {
            //possible de recuperer les messages d'erreurs ici
            return false;
        }

        return true;
    }

   
}
