<?php

namespace App\Service;

use Exception;
use App\Helper\SerializerHelper;
use App\Entity\PaginatorResponse;
use App\Entity\ProjetHumanitaire;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class ProjetHumanitaireServiceRest implements IProjetHumanitaireService
{
    private HttpClientInterface $client;
    private SerializerHelper $serializerHelper;

    public function __construct(HttpClientInterface $client,SerializerHelper $serializerHelper)
    {
        $this->serializerHelper=$serializerHelper;
        $this->client=$client;
    }

    public function  recupererTousProjetHumanitairePagination(?int $page,?int $limit): PaginatorResponse
    {
        //appler Api
        $response = $this->client->request(
            'GET',
            "http://localhost:8000/api/projetHumanitaires?page=".($page?$page:"")."&limit=".($limit?$limit:"")
        );
        $statusCode = $response->getStatusCode();
        $content = $response->getContent();
        //envoyer à la vue
        $paginatorProjetHumanitaire = $this->serializerHelper->deserializePaginator($content,'App\Entity\ProjetHumanitaire'); 
        return $paginatorProjetHumanitaire;
    }

    public function recupererTousProjetHumanitaire(): array
    {
        //appler Api
        $response = $this->client->request(
            'GET',
            "http://localhost:8000/api/projetHumanitaires"
        );
        $statusCode = $response->getStatusCode();
        $content = $response->getContent();
        //deserialiser l'objet
        $projetHumanitaire = $this->serializerHelper->serializer->deserialize($content, "App\Entity\ProjetHumanitaire[]", 'json');
        //envoyer à la vue

        return $projetHumanitaire;
    }

    public function recupererProjetHumanitaireParId(int $id): array
    {
        //appler Api
        $response = $this->client->request(
            'GET',
            "http://localhost:8000/api/projetHumanitaires/$id"
        );
        $statusCode = $response->getStatusCode();
        $content = $response->getContent();
        //deserialiser l'objet
        $departements = $this->serializerHelper->serialize->deserialize($content, "App\Entity\Departement", 'json');
        //envoyer à la vue

        return $departements;
    }

    public function enregistrerProjetHumanitaire(ProjetHumanitaire $projetHumanitaire): ProjetHumanitaire
    {
        $projetHumanitaireTab = $this->serializerHelper->normalizer->normalize($projetHumanitaire);
        //appler Api
       
        $response = $this->client->request(
            'POST',
            'http://localhost:8000/api/projetHumanitaires',
            ['json'=> $projetHumanitaireTab]
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
        $projetHumanitaire = $this->serializerHelper->serializer->deserialize($content, "App\Entity\ProjetHumanitaire", 'json');
        //envoyer à la vue

        return $projetHumanitaire;
    }

    public function mettreAjourProjetHumanitaire(ProjetHumanitaire $projetHumanitaire): bool
    {
        $projetHumanitaireTab = $this->serializerHelper->normalizer->normalize($projetHumanitaire);
        //appler Api
        $response = $this->client->request(
            'PUT',
            "http://localhost:8000/api/projetHumanitaires/" . $projetHumanitaire->getId(),
            ["json"=>$projetHumanitaireTab]
        );

        $statusCode = $response->getStatusCode();

        if ($statusCode != 200) {
            //possible de recuperer les messages d'erreurs ici
            return false;
        }

        return true;
    }
    public function supprimerProjetHumanitaire(int $id): bool
    {

        $response = $this->client->request(
            "DELETE",
            "http://localhost:8000/api/projetHumanitaires/$id"
        );

        $statusCode = $response->getStatusCode();

        if ($statusCode != 200) {
            //possible de recuperer les messages d'erreurs ici
            return false;
        }

        return true;
    }

   
}
